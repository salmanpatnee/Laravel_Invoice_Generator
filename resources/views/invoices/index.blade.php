<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoices') }}
            </h2>
            <a href="{{ route('invoices.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Create
                New</a>
        </div>

    </x-slot>

    <div class="container">



        <div class="row">
            <div class="col-md-12">
                @if (count($invoices))

                    <table class="table table-striped mt-5">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">RM Name</th>
                                <th scope="col">Package</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Client Email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <th>{{ $invoice->invoice_no }}</th>
                                    <td>
                                        {{ $invoice->seller->name }} <b>({{ $invoice->seller->code }})</b>
                                    </td>
                                    <td>
                                        @if ($invoice->is_customized)
                                            Customized Package <b>({{ $invoice->customized_price }})</b>
                                        @else
                                            {{ $invoice->package->name }} <b>(${{ $invoice->package->price }})</b>
                                        @endif

                                    </td>
                                    <td>
                                        {{ $invoice->brand->name }}
                                    </td>
                                    <td>
                                        {{ $invoice->client_name }}
                                    </td>
                                    <td>
                                        {{ $invoice->client_email }}
                                    </td>
                                    <td>
                                        <a href="{{ Storage::path($invoice->pdf_path) }}" target="_blank"
                                            class="btn btn-danger btn-sm">
                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $invoices->links() }}
                @else

                @endif

            </div>
        </div>
    </div>
</x-app-layout>
