<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Invoice') }}
            </h2>
            {{-- <a href="{{ route('brands.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Back</a> --}}
        </div>

    </x-slot>

    <x-jet-authentication-card>
        <x-slot name="logo"></x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('invoices.store') }}">
            @csrf
            <input type="hidden" name="invoice_no" value="0001">
            <div>
                <x-jet-label for="client_name" value="{{ __('Client Name') }}" />
                <input type="text" name="client_name" id="client_name" value="{{ old('client_name') }}"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                    required>
            </div>
            <div class="mt-4">
                <x-jet-label for="client_email" value="{{ __('Client Email') }}" />
                <input type="email" name="client_email" id="client_email" value="{{ old('client_email') }}"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                    required>
            </div>

            <div class="mt-4">
                <x-jet-label for="package_id" value="{{ __('Select Package') }}" />
                <select name="package_id" id="package_id"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">--Select Package--</option>
                    @foreach ($packages as $package)
                        <option {{ old('package_id') == $package->id ? 'selected' : '' }}
                            value="{{ $package->id }}">
                            {{ $package->name }} - {{ $package->formattedPrice }}</option>
                    @endforeach
                    <option {{ old('package_id') == 'custom_package' ? 'selected' : '' }} value="custom_package">
                        Custom Package</option>
                </select>
            </div>


            <div class="hidden"
                {{ old('package_id') == 'custom_package' ? 'style=display:inherit' : 'style=display:none' }}
                id="custom_pkg_prc">
                <div class="mt-4">
                    <x-jet-label for="customized_price" value="{{ __('Please Specify Custom Package Price') }}" />
                    <select name="currency" id="currency"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                        <option {{ old('currency') == '£' ? 'selected' : '' }} value="£">£</option>
                        <option {{ old('currency') == '$' ? 'selected' : '' }} value="$">$</option>
                        <option {{ old('currency') == '₨' ? 'selected' : '' }} value="₨">₨</option>
                    </select>
                </div>
                <div class="mt-4">
                    <input type="number" name="customized_price" id="customized_price"
                        value="{{ old('customized_price') }}"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                </div>
            </div>

            <div class="mt-4">
                <label class="block font-medium text-sm text-gray-700" for="vat"
                    style="display: flex; align-items: center;">
                    <input type="checkbox" name="vat" id="vat" value="1"> &nbsp; Add VAT
                </label>
            </div>



            <div class="mt-4">
                <x-jet-label for="brand_id" value="{{ __('Select Brand') }}" />
                <select name="brand_id" id="brand_id"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">--Select Brand--</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Generate Invoice') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
