<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Patient
 *
 * @package App
 * @property string $name
 * @property string $gender
 * @property integer $age
 * @property string $oranization
 * @property string $diagnostic
 * @property string $address
 * @property string $contact
 * @property string $description
*/
class Patient extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'gender', 'age', 'diagnostic', 'province_id', 'contact', 'description', 'oranization_id','creator'];
    protected $hidden = [];
    
    

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setAgeAttribute($input)
    {
        $this->attributes['age'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setOranizationIdAttribute($input)
    {
        $this->attributes['oranization_id'] = $input ? $input : null;
    }
    
    public function oranization()
    {
        return $this->belongsTo(Organization::class, 'oranization_id')->withTrashed();
    }
    
    public function invoices() {
        return $this->hasMany(Invoice::class, 'patient_id');
    }

    public function invoice() {
        return $this->hasOne(Invoice::class, 'patient_id');
    }

    public function province() {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function user_creator()
    {
        return $this->belongsTo(User::class, 'creator');
    }
}
