<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invstate extends Model
{
    use SoftDeletes;

    protected $fillable = ['state', 'description'];
    protected $hidden = [];
}
