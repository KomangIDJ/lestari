<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id_product';
    public $timestamps = false;

    protected $fillable = [
        'sub_category',
        'serial_no',
        'description',
        'carat',
    ];

    public function getRouteKeyName(): string
    {
        return 'id_product';
    }

    public function workAllocationItems()
    {
        return $this->hasMany(Workallocationitem::class, 'fg', 'id_product');
    }

    public function workCompletionItems()
    {
        return $this->hasMany(Workcompletionitem::class, 'fg', 'id_product');
    }
}
