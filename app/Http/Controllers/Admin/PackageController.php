<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionPackage;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

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
        $products   = Product::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.packages.create', compact('categories', 'products'));
    }

    public function edit(CommissionPackage $package)
    {
        $categories      = Category::where('is_active', true)->orderBy('sort_order')->get();
        $products        = Product::where('is_active', true)->orderBy('sort_order')->get();
        $packageProducts = $package->products->keyBy('id');
        return view('admin.packages.edit', compact('package', 'categories', 'products', 'packageProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'features'    => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
            'products'    => 'nullable|array',
            'products.*'  => 'exists:products,id',
            'quantities'  => 'nullable|array',
        ]);

        $package = CommissionPackage::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'features'    => $request->features
                ? array_values(array_filter(array_map('trim', explode("\n", $request->features))))
                : [],
            'is_featured' => $request->boolean('is_featured'),
            'is_active'   => $request->boolean('is_active', true),
            'sort_order'  => CommissionPackage::max('sort_order') + 1,
            'category_id' => $request->category_id,
        ]);

        if ($request->has('products')) {
            $sync = [];
            foreach ($request->products as $productId) {
                $sync[$productId] = ['quantity' => max(1, (int) ($request->quantities[$productId] ?? 1))];
            }
            $package->products()->sync($sync);
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paquete creado correctamente.');
    }


    public function update(Request $request, CommissionPackage $package)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'features'    => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
            'products'    => 'nullable|array',
            'products.*'  => 'exists:products,id',
            'quantities'  => 'nullable|array',
        ]);

        $package->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'features'    => $request->features
                ? array_values(array_filter(array_map('trim', explode("\n", $request->features))))
                : [],
            'is_featured' => $request->boolean('is_featured'),
            'is_active'   => $request->boolean('is_active', true),
            'sort_order'  => $request->sort_order ?? 0,
            'category_id' => $request->category_id,
        ]);

        $sync = [];
        if ($request->has('products')) {
            foreach ($request->products as $productId) {
                $sync[$productId] = ['quantity' => max(1, (int) ($request->quantities[$productId] ?? 1))];
            }
        }
        $package->products()->sync($sync);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paquete actualizado correctamente.');
    }

    public function destroy(CommissionPackage $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paquete eliminado correctamente.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer|exists:commission_packages,id']);
        DB::transaction(function () use ($request) {
            foreach ($request->order as $position => $id) {
                CommissionPackage::where('id', $id)->update(['sort_order' => $position]);
            }
        });
        return response()->json(['ok' => true]);
    }
}