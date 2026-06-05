<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workcompletionitem extends Model
{
    protected $table = 'workcompletionitem';
    protected $primaryKey = 'idm';
    public $timestamps = false;

    protected $fillable = [
        'work_completion_id',
        'ordinal',
        'qty',
        'weight',
        'link_id',
        'link_ord',
        'fg',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
    ];

    public function completion()
    {
        return $this->belongsTo(Workcompletion::class, 'work_completion_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'fg', 'id_product');
    }
}
