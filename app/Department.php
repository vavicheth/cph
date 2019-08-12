<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'name_kh', 'abr', 'abr_kh', 'beds', 'description', 'active'];
    protected $hidden = [];


    public function invoices() {
        return $this->hasMany(Invoice::class, 'department_id');
    }

}
