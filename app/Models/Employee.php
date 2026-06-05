<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';
    protected $primaryKey = 'id_employee';
    public $timestamps = false;

    protected $fillable = [
        'entry_date',
        'name',
        'rank',
        'gender',
    ];

    protected $casts = [
        'entry_date' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'id_employee';
    }

    public function workAllocations()
    {
        return $this->hasMany(Workallocation::class, 'employee', 'id_employee');
    }

    public function workCompletions()
    {
        return $this->hasMany(Workcompletion::class, 'employee', 'id_employee');
    }
}
