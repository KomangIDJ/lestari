<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyReportController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.daily', $this->buildReportData($request->query('date', now()->toDateString())));
    }

    public function print(Request $request)
    {
        return view('reports.print', $this->buildReportData($request->query('date', now()->toDateString())));
    }

    private function buildReportData(string $date): array
    {
        $spkHeaders = DB::select(
            "
            SELECT
                wa.id,
                wa.sw,
                wa.trans_date,
                wa.process,
                wa.remarks,
                e.name AS employee_name,
                e.rank AS employee_rank,
                COUNT(wai.idm) AS item_count,
                COALESCE(SUM(wai.qty), 0) AS total_qty
            FROM workallocation wa
            LEFT JOIN employee e ON e.id_employee = wa.employee
            LEFT JOIN workallocationitem wai ON wai.work_allocation_id = wa.id
            WHERE DATE(wa.trans_date) = ?
            GROUP BY wa.id, wa.sw, wa.trans_date, wa.process, wa.remarks, e.name, e.rank
            ORDER BY wa.sw ASC
            ",
            [$date]
        );

        $spkIds = array_column($spkHeaders, 'id');
        $spkItems = $this->loadAllocationItems($spkIds);

        $notaHeaders = DB::select(
            "
            SELECT
                wc.id,
                wc.work_allocation,
                wc.trans_date,
                wc.process,
                wc.remarks,
                e.name AS employee_name,
                e.rank AS employee_rank,
                COUNT(wci.idm) AS item_count,
                COALESCE(SUM(wci.qty), 0) AS total_qty
            FROM workcompletion wc
            LEFT JOIN employee e ON e.id_employee = wc.employee
            LEFT JOIN workcompletionitem wci ON wci.work_completion_id = wc.id
            WHERE DATE(wc.trans_date) = ?
            GROUP BY wc.id, wc.work_allocation, wc.trans_date, wc.process, wc.remarks, e.name, e.rank
            ORDER BY wc.work_allocation ASC
            ",
            [$date]
        );

        $notaIds = array_column($notaHeaders, 'id');
        $notaItems = $this->loadCompletionItems($notaIds);

        $summary = [
            'spk_count' => count($spkHeaders),
            'spk_items' => array_sum(array_map(fn ($row) => (int) $row->item_count, $spkHeaders)),
            'nota_count' => count($notaHeaders),
            'nota_items' => array_sum(array_map(fn ($row) => (int) $row->item_count, $notaHeaders)),
        ];

        return compact('date', 'spkHeaders', 'spkItems', 'notaHeaders', 'notaItems', 'summary');
    }

    private function loadAllocationItems(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $rows = DB::select(
            "
            SELECT
                wai.work_allocation_id,
                wai.ordinal,
                wai.qty,
                wai.weight,
                p.description AS product_description
            FROM workallocationitem wai
            LEFT JOIN product p ON p.id_product = wai.fg
            WHERE wai.work_allocation_id IN ($placeholders)
            ORDER BY wai.work_allocation_id ASC, wai.ordinal ASC
            ",
            $ids
        );

        return $this->groupRows($rows, 'work_allocation_id');
    }

    private function loadCompletionItems(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $rows = DB::select(
            "
            SELECT
                wci.work_completion_id,
                wci.ordinal,
                wci.qty,
                wci.weight,
                p.description AS product_description
            FROM workcompletionitem wci
            LEFT JOIN product p ON p.id_product = wci.fg
            WHERE wci.work_completion_id IN ($placeholders)
            ORDER BY wci.work_completion_id ASC, wci.ordinal ASC
            ",
            $ids
        );

        return $this->groupRows($rows, 'work_completion_id');
    }

    private function groupRows(array $rows, string $groupKey): array
    {
        $grouped = [];

        foreach ($rows as $row) {
            $key = $row->{$groupKey};
            if (! isset($grouped[$key])) {
                $grouped[$key] = [];
            }

            $grouped[$key][] = $row;
        }

        return $grouped;
    }
}
