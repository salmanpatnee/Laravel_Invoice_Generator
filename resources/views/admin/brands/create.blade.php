<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Brand') }}
            </h2>
            <a href="{{ route('brands.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Back</a>
        </div>

    </x-slot>

    <x-jet-authentication-card>
        <x-slot name="logo"></x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('brands.store') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                    required>
            </div>

            <div class="mt-4">
                <x-jet-label for="logo" value="{{ __('Logo') }}" />
                <input type="file" name="logo" id="logo" value="{{ old('logo') }}"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Add Brand') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
