<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workcompletion extends Model
{
    protected $table = 'workcompletion';
    public $timestamps = false;

    protected $fillable = [
        'remarks',
        'employee',
        'trans_date',
        'process',
        'work_allocation',
    ];

    protected $casts = [
        'trans_date' => 'date',
    ];

    public function employeeRecord()
    {
        return $this->belongsTo(Employee::class, 'employee', 'id_employee');
    }

    public function items()
    {
        return $this->hasMany(Workcompletionitem::class, 'work_completion_id', 'id')->orderBy('ordinal');
    }
}
