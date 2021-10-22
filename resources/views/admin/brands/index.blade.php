<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Brands') }}
            </h2>
            <a href="{{ route('brands.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Add
                New</a>
        </div>

    </x-slot>

    <div class="container">

        @if (session('message'))
            <div class="mt-3 mx-auto alert alert-success alert-dismissible fade show" style="max-width: 500px;"
                role="alert">
                <strong>Yay!</strong> {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                @if (count($brands))

                    <table class="table table-striped mt-5">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Logo</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <th>{{ $brand->name }}</th>
                                    <td>
                                        <img src="{{ asset($brand->thumbnail) }}" class="img-thumbnail" width="100">
                                    </td>
                                    <td>

                                        <a href="{{ route('brands.edit', $brand->id) }}"
                                            class="btn btn-secondary btn-sm">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <form class="d-inline"
                                            action="{{ route('brands.destroy', $brand->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @else

                @endif

            </div>
        </div>
    </div>
</x-app-layout>
