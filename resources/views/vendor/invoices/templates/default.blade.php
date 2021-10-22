<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $invoice->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" href="{{ public_path('vendor/invoices/bootstrap.min.css') }}">

    <style type="text/css" media="screen">
        * {
            font-family: "DejaVu Sans";
        }

        html {
            margin: 0;
        }

        body {
            font-size: 10px;
            margin: 36pt;
        }

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        table,
        th,
        tr,
        td,
        p,
        div {
            line-height: 1.1;
        }

        .party-header {
            font-size: 1.5rem;
            font-weight: 400;
        }

        .total-amount {
            font-size: 12px;
            font-weight: 700;
        }

    </style>
</head>

<body>



    <table class="table mt-5" width="100%">
        <tbody>
            <tr>
                <td width="100%" style="text-align:center;" class="border-0 pl-0">
                    @if ($invoice->logo)
                        <img src="{{ $invoice->getLogo() }}" alt="logo" height="100">
                    @endif
                </td>
            </tr>
            {{-- <tr>
                    <td width="100%" class="border-0 pl-0">
                        <p style="font-size: 20px; text-align: center">Invoice</p>
                    </td>
                </tr> --}}
        </tbody>
    </table>
    <hr style="margin:1em 0; border-top:1px solid #F0F3FD;">
    <table class="table mt-5" width="100%">
        <tbody>
            <tr>
                <td width="50%" class="border-0 pl-0">

                    <p style="font-size: 16px;">{{ __('invoices::invoice.date') }}:
                        <strong>{{ $invoice->getDate() }}</strong>
                    </p>
                </td>
                <td width=" 50%" class="border-0 pl-0">
                    <p style="font-size: 16px; text-align:right;">{{ __('invoices::invoice.serial') }}
                        <strong>{{ $invoice->getSerialNumber() }}</strong>
                    </p>

                </td>
            </tr>
        </tbody>
    </table>
    <hr style="margin:1em 0; border-top:1px solid #F0F3FD;">

    <table style="margin-top:30px; margin-bottom:30px;" class="table">
        <thead>
            <tr>
                <th class="border-0 pl-0 party-header" width="50%" style="text-align: left; font-size:14px;">
                    Invoiced To:
                </th>
            </tr>
            <tr>
                <td>
                    @if ($invoice->buyer->name)
                        <p class="buyer-name">
                            Name: {{ $invoice->buyer->name }}
                        </p>
                    @endif

                    @if ($invoice->buyer->address)
                        <p class="buyer-address">
                            {{ __('invoices::invoice.address') }}: {{ $invoice->buyer->address }}
                        </p>
                    @endif

                    @if ($invoice->buyer->code)
                        <p class="buyer-code">
                            {{ __('invoices::invoice.code') }}: {{ $invoice->buyer->code }}
                        </p>
                    @endif

                    @if ($invoice->buyer->vat)
                        <p class="buyer-vat">
                            {{ __('invoices::invoice.vat') }}: {{ $invoice->buyer->vat }}
                        </p>
                    @endif

                    @if ($invoice->buyer->phone)
                        <p class="buyer-phone">
                            {{ __('invoices::invoice.phone') }}: {{ $invoice->buyer->phone }}
                        </p>
                    @endif

                    @foreach ($invoice->buyer->custom_fields as $key => $value)
                        <p class="buyer-custom-field">
                            {{ ucfirst($key) }}: {{ $value }}
                        </p>
                    @endforeach
                </td>
            </tr>
        </thead>

    </table>

    {{-- Table --}}
    <table class="table" width="100%">
        <thead style="background-color: #f0f3fd; height:30px">
            <tr>
                <th style="padding:20px" scope="col" class="border-0 pl-0">{{ __('invoices::invoice.description') }}
                </th>
                @if ($invoice->hasItemUnits)
                    <th scope="col" class="text-center border-0">{{ __('invoices::invoice.units') }}</th>
                @endif
                <th scope="col" class="text-center border-0">{{ __('invoices::invoice.quantity') }}</th>
                <th scope="col" class="text-right border-0">{{ __('invoices::invoice.price') }}</th>
                @if ($invoice->hasItemDiscount)
                    <th scope="col" class="text-right border-0">{{ __('invoices::invoice.discount') }}</th>
                @endif
                @if ($invoice->hasItemTax)
                    <th scope="col" class="text-right border-0">{{ __('invoices::invoice.tax') }}</th>
                @endif
                <th scope="col" class="text-right border-0 pr-0">{{ __('invoices::invoice.sub_total') }}</th>
            </tr>
        </thead>
        <tbody>
            {{-- Items --}}
            @foreach ($invoice->items as $item)
                <tr>
                    <td style="border-bottom:1px solid #ccc; padding:10px;" class="pl-0">{{ $item->title }}
                    </td>
                    @if ($invoice->hasItemUnits)
                        <td class="text-center">{{ $item->units }}</td>
                    @endif
                    <td style="border-bottom:1px solid #ccc; padding:10px; text-align:center;" class="text-center">
                        {{ $item->quantity }}</td>
                    <td style="border-bottom:1px solid #ccc; padding:10px; text-align:center;" class="text-right">
                        {{ $invoice->formatCurrency($item->price_per_unit) }}
                    </td>
                    @if ($invoice->hasItemDiscount)
                        <td style="border-bottom:1px solid #ccc; padding:10px; text-align:center;"
                            class="text-right">
                            {{ $invoice->formatCurrency($item->discount) }}
                        </td>
                    @endif
                    @if ($invoice->hasItemTax)
                        <td style="border-bottom:1px solid #ccc; padding:10px; text-align:center;"
                            class="text-right">
                            {{ $invoice->formatCurrency($item->tax) }}
                        </td>
                    @endif

                    <td style="border-bottom:1px solid #ccc; padding:10px; text-align:center;" class="text-right pr-0">
                        {{ $invoice->formatCurrency($item->sub_total_price) }}
                    </td>
                </tr>
            @endforeach
            {{-- Summary --}}
            @if ($invoice->hasItemOrInvoiceDiscount())
                <tr>
                    <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                    <td class="text-right pl-0">{{ __('invoices::invoice.total_discount') }}</td>
                    <td class="text-right pr-0">
                        {{ $invoice->formatCurrency($invoice->total_discount) }}
                    </td>
                </tr>
            @endif
            @if ($invoice->taxable_amount)
                <tr>
                    <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                    <td class="text-right pl-0">{{ __('invoices::invoice.taxable_amount') }}</td>
                    <td class="text-right pr-0">
                        {{ $invoice->formatCurrency($invoice->taxable_amount) }}
                    </td>
                </tr>
            @endif
            @if ($invoice->tax_rate)
                <tr>
                    <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                    <td class="text-right pl-0">{{ __('invoices::invoice.tax_rate') }}</td>
                    <td class="text-right pr-0">
                        {{ $invoice->tax_rate }}%
                    </td>
                </tr>
            @endif
            @if ($invoice->hasItemOrInvoiceTax())
                <tr>
                    <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                    <td class="text-right pl-0">{{ __('invoices::invoice.total_taxes') }}</td>
                    <td class="text-right pr-0">
                        {{ $invoice->formatCurrency($invoice->total_taxes) }}
                    </td>
                </tr>
            @endif
            @if ($invoice->shipping_amount)
                <tr>
                    <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                    <td class="text-right pl-0">{{ __('invoices::invoice.shipping') }}</td>
                    <td class="text-right pr-0">
                        {{ $invoice->formatCurrency($invoice->shipping_amount) }}
                    </td>
                </tr>
            @endif
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td style="background-color: #f0f3fd; height:30px; text-align:center;" class="text-right pl-0">
                    {{ __('invoices::invoice.total_amount') }}</td>
                <td style="background-color: #f0f3fd; height:30px; text-align:center;"
                    class="text-right pr-0 total-amount">
                    {{ $invoice->formatCurrency($invoice->total_amount) }}
                </td>
            </tr>
        </tbody>
    </table>

    @if ($invoice->notes)
        <p>
            {{ trans('invoices::invoice.notes') }}: {!! $invoice->notes !!}
        </p>
    @endif

    <script type="text/php">
        if (isset($pdf) && $PAGE_COUNT > 1) {
                                                                                                                                                                                                                                                                                                $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
                                                                                                                                                                                                                                                                                                $size = 10;
                                                                                                                                                                                                                                                                                                $font = $fontMetrics->getFont("Verdana");
                                                                                                                                                                                                                                                                                                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                                                                                                                                                                                                                                                                                                $x = ($pdf->get_width() - $width);
                                                                                                                                                                                                                                                                                                $y = $pdf->get_height() - 35;
                                                                                                                                                                                                                                                                                                $pdf->page_text($x, $y, $text, $font, $size);
                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                        
                                                                                                                                                                        
                                                        </script>
</body>

</html>
