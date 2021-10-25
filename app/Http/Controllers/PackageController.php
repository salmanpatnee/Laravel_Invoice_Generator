<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('name', 'asc')->get();

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store()
    {
        $attributes = $this->validateAttributes();

        Package::create($attributes);

        return redirect(route('packages.index'))->with('message', 'Package added.');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Package $package)
    {
        $attributes = $this->validateAttributes($package);

        $package->update($attributes);

        return redirect(route('packages.index'))->with('message', 'Package updated.');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect(route('packages.index'))->with('message', 'Brand deleted.');
    }


    protected function validateAttributes(Package $package = null)
    {

        return request()->validate(
            [
                'name'        => ['required', Rule::unique('packages', 'name')->ignore($package), 'min:3', 'max:255'],
                'description' => 'nullable|string|max:255',
                'price'       => 'required|numeric',
                'currency'    => 'required|in:$,£,₨'
            ]
        );
    }
}
