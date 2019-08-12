<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Province extends Model
{
    use SoftDeletes;

    protected $fillable = ['code', 'province_kh', 'province_en', 'description'];
    protected $hidden = [];



}
