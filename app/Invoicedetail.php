<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Invoicedetail
 *
 * @package App
 * @property string $invoice
 * @property string $medicine
 * @property string $type
 * @property integer $qty
 * @property decimal $unit_price
 * @property decimal $total
*/
class Invoicedetail extends Model
{
    use SoftDeletes;


    protected $fillable = ['type', 'qty', 'unit_price', 'total', 'invoice_id', 'medicine_id','extend_id','org_price','exchange_id'];
    protected $hidden = [];
//    protected $dates = ['deleted_at'];
    
    

    /**
     * Set to null if empty
     * @param $input
     */
    public function setInvoiceIdAttribute($input)
    {
        $this->attributes['invoice_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setMedicineIdAttribute($input)
    {
        $this->attributes['medicine_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setQtyAttribute($input)
    {
        $this->attributes['qty'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setUnitPriceAttribute($input)
    {
        $this->attributes['unit_price'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setTotalAttribute($input)
    {
        $this->attributes['total'] = $input ? $input : null;
    }
    
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id')->withTrashed();
    }
    
    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id')->withTrashed();
    }

    public function extend()
    {
        return $this->belongsTo(Extend::class, 'extend_id');
    }

    public function exchange()
    {
        return $this->belongsTo(Exchange::class, 'exchange_id');
    }
    
}
