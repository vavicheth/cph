<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extend extends Model
{
    use SoftDeletes;

    protected $fillable = ['percentage', 'description','default'];
    protected $hidden = [];
}
