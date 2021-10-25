<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'invoice_no',
        'user_id',
        'package_id',
        'brand_id',
        'client_name',
        'client_email',
        'is_customized',
        'currency',
        'customized_price',
        'vat',
        'total',
        'pdf_path',
    ];

    protected $with = ['package', 'brand'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($invoice) {
            $invoice->update(['pdf_path' => 'Invoice-' . date('Y') . '-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) . '.pdf']);
            $vat = 0;
            $total = 0;

            // Setting up vat value
            if (!is_null($invoice->vat)) {
                if ($invoice->is_customized) {
                    $vat = ($invoice->customized_price * 20) / 100;
                    $total = $invoice->customized_price + $vat;
                } else {
                    $vat = ($invoice->package->price * 20) / 100;
                    $total = $invoice->package->price + $vat;
                }
            } else {
                $total = $invoice->is_customized ?  $invoice->customized_price : $invoice->package->price;
            }

            $invoice->update(['vat' => $vat]);


            // Setting up total value
            $invoice->update(['total' => $total]);
        });
    }


    public function setInvoiceNoAttribute($value)
    {
        $lastRecord = $this::latest()->first();

        $id = is_null($lastRecord) ? 1 : ($lastRecord->id + 1);

        $invoiceNo = Date('Y') . '-' . str_pad($id, 4, '0', STR_PAD_LEFT);

        $this->attributes['invoice_no'] = $invoiceNo;
    }

    public function setPackageIdAttribute($value)
    {
        $this->attributes['package_id']     = ($value != 'custom_package') ? $value : null;
        $this->attributes['is_customized']  = ($value != 'custom_package') ? false : true;
    }

    public function getPackageCurrencyAttribute()
    {
        if ($this->is_customized) {
            return $this->currency;
        } else {
            return $this->package->currency;
        }
    }

    public function getFormattedCustomizedPriceAttribute()
    {
        if ($this->is_customized) return $this->currency . $this->customized_price;
    }



    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
