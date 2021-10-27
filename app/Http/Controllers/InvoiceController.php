<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Invoice;
use App\Models\Package;
use Illuminate\Validation\Rule;
use LaravelDaily\Invoices\Invoice as LDInvoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices =  Invoice::orderBy('invoice_no', 'desc')->paginate(20);

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $packages = Package::orderBy('name', 'asc')->get();
        $brands   = Brand::orderBy('name', 'asc')->get();

        return view('invoices.create', [
            'packages' => $packages,
            'brands' => $brands,
        ]);
    }

    public function store()
    {
        $record = auth()->user()->invoices()->create($this->validateAttributes());

        $invoice = $this->generateInvoicePdf($record);

        return $invoice->download();
    }

    protected function generateInvoicePdf(Invoice $record)
    {
        // Customer details
        $customer = new Buyer([
            'name'          => $record->client_name,
            'custom_fields' => ['email' => $record->client_email],
        ]);

        // Purchased items/services
        if ($record->is_customized) {
            $item = (new InvoiceItem())->title('Customized Package')->pricePerUnit($record->customized_price);
        } else {
            $item = (new InvoiceItem())->title($record->package->name)->pricePerUnit($record->package->price);
        }

        // Additional notes
        $notes = ['in regards of delivery or something else'];
        $notes = implode("<br>", $notes);

        // Applying vat
        $vat = request()->has('vat') ? 20 : 0;

        $invoice = LDInvoice::make()
            ->buyer($customer)
            ->series(Date('Y'))
            ->logo(public_path($record->brand->logo))
            ->sequence($record->id)
            ->addItem($item)
            ->currencySymbol($record->packageCurrency)
            ->taxRate($vat)
            ->notes($notes)
            ->filename('Invoice-' . date('Y') . '-' . str_pad($record->id, 4, '0', STR_PAD_LEFT))
            ->save('public');

        return $invoice;
    }

    protected function validateAttributes(Invoice $invoice = null)
    {

        return request()->validate(
            [
                'invoice_no'       => ['required', Rule::unique('invoices', 'invoice_no')->ignore($invoice)],
                'package_id'       => 'nullable|required',
                'brand_id'         => 'required|exists:brands,id',
                'client_name'      => 'required|string|min:3|max:255',
                'client_email'     => 'required|email|max:255',
                'is_customized'    => 'nullable|boolean',
                'vat'              => 'nullable|boolean',
                'currency'         => 'nullable|required_if:package_id,custom_package|in:$,£,₨',
                'customized_price' => 'nullable|required_if:package_id,custom_package|numeric',
            ],
            [
                'customized_price.required_if' => 'Please specify the custom package price.'
            ]
        );
    }
}
