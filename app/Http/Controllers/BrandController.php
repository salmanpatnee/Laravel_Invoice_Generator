<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('name', 'asc')->get();

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store()
    {
        $attributes = $this->validateAttributes();

        if (request()->has('logo')) {
            $file = $this->uploadThumbnail(request()->file('logo'), $attributes['name']);
            $attributes['logo'] = $file;
        }

        Brand::create($attributes);

        return redirect(route('brands.index'))->with('message', 'Brand added.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Brand $brand)
    {
        $attributes = $this->validateAttributes($brand);

        $attributes['logo'] = $attributes['old_logo'];

        if (request()->has('logo')) {
            File::delete($attributes['logo']);
            $file = $this->uploadThumbnail(request()->file('logo'), $attributes['name']);
            $attributes['logo'] = $file;
        }

        $brand->update($attributes);

        return redirect(route('brands.index'))->with('message', 'Brand updated.');
    }

    public function destroy(Brand $brand)
    {
        File::delete($brand->logo);

        $brand->delete();

        return redirect(route('brands.index'))->with('message', 'Brand deleted.');
    }

    protected function uploadThumbnail($image, $fileName)
    {

        $file = '/images/brands' . Str::slug($fileName, '-') . '.png';

        $isUploaded = Image::make($image)->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('png')->save(public_path($file));

        return ($isUploaded) ? $file : false;
    }

    protected function validateAttributes(Brand $brand = null)
    {

        return request()->validate(
            [
                'name'     => ['required', Rule::unique('brands', 'name')->ignore($brand), 'min:3', 'max:255'],
                'logo'     => 'image|mimes:jpg,jpeg,webp,png|max:2048',
                'old_logo' => 'string'
            ]
        );
    }
}
