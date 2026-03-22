<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionPackage;
use Illuminate\Http\Request;
use App\Models\Category;

class PackageController extends Controller
{
    public function index()
    {
        $packages = CommissionPackage::orderBy('sort_order')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.packages.create', compact('categories'));
    }

    public function edit(CommissionPackage $package)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.packages.edit', compact('package', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'features'    => 'required|string',
            'is_featured' => 'boolean',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ]);

        CommissionPackage::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'features'    => array_filter(array_map('trim', explode("\n", $request->features))),
            'is_featured' => $request->boolean('is_featured'),
            'is_active'   => $request->boolean('is_active', true),
            'sort_order'  => $request->sort_order ?? 0,
            'category_id' => $request->category_id,

        ]);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paquete creado correctamente.');
    }


    public function update(Request $request, CommissionPackage $package)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'features'    => 'required|string',
            'is_featured' => 'boolean',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ]);

        $package->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'features'    => array_filter(array_map('trim', explode("\n", $request->features))),
            'is_featured' => $request->boolean('is_featured'),
            'is_active'   => $request->boolean('is_active', true),
            'sort_order'  => $request->sort_order ?? 0,
            'category_id' => $request->category_id,

        ]);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paquete actualizado correctamente.');
    }

    public function destroy(CommissionPackage $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paquete eliminado correctamente.');
    }
}