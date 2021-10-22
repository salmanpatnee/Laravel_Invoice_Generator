<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Package') }}
            </h2>
            <a href="{{ route('packages.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Back</a>
        </div>
    </x-slot>

    <x-jet-authentication-card>
        <x-slot name="logo"></x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('packages.update', $package->id) }}">
            @csrf
            @method('PATCH')
            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <input type="text" name="name" id="name" value="{{ old('name', $package->name) }}"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                    required>
            </div>

            <div class="mt-4">
                <x-jet-label for="description" value="{{ __('Description') }}" />
                <textarea name="description" id="description"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">{{ old('description', $package->description) }}
                </textarea>
            </div>

            <div class="mt-4">
                <x-jet-label for="price" value="{{ __('Price') }}" />
                <input type="number" name="price" id="price" value="{{ old('price', $package->price) }}"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                    required>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Update Package') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
