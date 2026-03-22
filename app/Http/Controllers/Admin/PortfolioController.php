<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class PortfolioController extends Controller
{
    public function index()
    {
        $items = PortfolioItem::orderBy('sort_order')->get();
        return view('admin.portfolio.index', compact('items'));
    }

public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.portfolio.create', compact('categories'));
    }

    public function edit(PortfolioItem $portfolio)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.portfolio.edit', compact('portfolio', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'sort_order'  => 'integer',
            'is_visible'  => 'boolean',
        ]);

        $imagePath = $request->file('image')->store('portfolio', 'public');

        PortfolioItem::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image_path'  => $imagePath,
            'category_id' => $request->category_id,
            'sort_order'  => $request->sort_order ?? 0,
            'is_visible'  => $request->boolean('is_visible', true),
        ]);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Pieza agregada correctamente.');
    }



    public function update(Request $request, PortfolioItem $portfolio)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'sort_order'  => 'integer',
            'is_visible'  => 'boolean',
        ]);

        $imagePath = $portfolio->image_path;

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($portfolio->image_path);
            $imagePath = $request->file('image')->store('portfolio', 'public');
        }

        $portfolio->update([
            'title'       => $request->title,
            'description' => $request->description,
            'image_path'  => $imagePath,
            'category_id' => $request->category_id,
            'sort_order'  => $request->sort_order ?? 0,
            'is_visible'  => $request->boolean('is_visible', true),
        ]);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Pieza actualizada correctamente.');
    }

    public function destroy(PortfolioItem $portfolio)
    {
        Storage::disk('public')->delete($portfolio->image_path);
        $portfolio->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Pieza eliminada correctamente.');
    }
}