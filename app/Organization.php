<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Organization
 *
 * @package App
 * @property string $name_kh
 * @property string $name_en
 * @property string $address
 * @property string $contact
 * @property text $description
 * @property tinyInteger $active
*/
class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = ['name_kh', 'name_en', 'address', 'contact', 'description', 'active'];
    protected $hidden = [];
    
    
    
}
