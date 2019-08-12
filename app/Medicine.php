<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Medicine
 *
 * @package App
 * @property string $name
 * @property string $type
 * @property decimal $price
 * @property decimal $extend_price
 * @property string $expire_date
 * @property string $company
 * @property tinyInteger $manual
 * @property text $description
 * @property tinyInteger $active
*/
class Medicine extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'type', 'price', 'extend_price', 'expire_date', 'company', 'manual', 'description', 'active'];
    protected $hidden = [];
    
    

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setPriceAttribute($input)
    {
        $this->attributes['price'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setExtendPriceAttribute($input)
    {
        $this->attributes['extend_price'] = $input ? $input : null;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setExpireDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['expire_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['expire_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getExpireDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    public  function invoicedetails()
    {
        return $this->hasMany(Invoicedetail::class, 'medicine_id');
    }

    public  function invoices()
    {
        return $this->belongsToMany('App\Invoice', 'invoicedetails', 'medicine_id', 'invoice_id');
    }
    
}
