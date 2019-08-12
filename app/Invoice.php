<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Invoice
 *
 * @package App
 * @property string $date
 * @property string $patient
 * @property integer $invstate_id
 * @property decimal $total
 * @property text $description
*/
class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = ['date', 'invstate_id', 'total', 'description', 'patient_id','department_id','creator'];
    protected $dates = ['date'];
    protected $hidden = [];
    
    

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setPatientIdAttribute($input)
    {
        $this->attributes['patient_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setInvstateIdAttribute($input)
    {
        $this->attributes['invstate_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setTotalAttribute($input)
    {
        $this->attributes['total'] = $input ? $input : null;
    }
    
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id')->withTrashed();
    }

    public function user_creator()
    {
        return $this->belongsTo(User::class, 'creator');
    }


    public function invoicedetail()
    {
        return $this->hasMany(Invoicedetail::class, 'invoice_id');
    }


    public function invstate()
    {
        return $this->belongsTo(Invstate::class, 'invstate_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function medicines()
    {
        return $this->belongsToMany('App\Medicine', 'Invoicedetails', 'invoice_id', 'medicine_id');
    }



    
}
