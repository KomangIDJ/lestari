<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workallocationitem extends Model
{
    protected $table = 'workallocationitem';
    protected $primaryKey = 'idm';
    public $timestamps = false;

    protected $fillable = [
        'work_allocation_id',
        'ordinal',
        'qty',
        'weight',
        'fg',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
    ];

    public function allocation()
    {
        return $this->belongsTo(Workallocation::class, 'work_allocation_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'fg', 'id_product');
    }
}
