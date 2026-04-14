<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

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

        $nextOrder = PortfolioItem::max('sort_order') + 1;

        PortfolioItem::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image_path'  => $imagePath,
            'category_id' => $request->category_id,
            'sort_order'  => $nextOrder,
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
            'is_visible'  => $request->boolean('is_visible', true),
        ]);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Pieza actualizada correctamente.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer|exists:portfolio_items,id']);

        DB::transaction(function () use ($request) {
            foreach ($request->order as $position => $id) {
                PortfolioItem::where('id', $id)->update(['sort_order' => $position]);
            }
        });

        return response()->json(['ok' => true]);
    }

    public function destroy(PortfolioItem $portfolio)
    {
        Storage::disk('public')->delete($portfolio->image_path);
        $portfolio->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Pieza eliminada correctamente.');
    }
}