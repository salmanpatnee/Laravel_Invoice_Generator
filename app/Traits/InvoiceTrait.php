<?php

namespace App\Traits;

use App\Models\Invoice;

trait InvoiceTrait
{

    protected static function getInvoiceSno($id)
    {
        return date('Y') . '-' . str_pad($id, 4, '0', STR_PAD_LEFT);
    }

    protected static function getInvoicePath($id)
    {
        return "Invoice-" . self::getInvoiceSno($id) . ".pdf";
    }

    public function setInvoiceNoAttribute($value)
    {
        $lastRecord = $this::latest()->first();

        $id = is_null($lastRecord) ? 1 : ($lastRecord->id + 1);

        $this->attributes['invoice_no'] = self::getInvoiceSno($id);
    }
}
