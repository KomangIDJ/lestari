<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workallocation extends Model
{
    protected $table = 'workallocation';
    public $timestamps = false;

    protected $fillable = [
        'remarks',
        'employee',
        'trans_date',
        'process',
        'sw',
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
        return $this->hasMany(Workallocationitem::class, 'work_allocation_id', 'id')->orderBy('ordinal');
    }
}
