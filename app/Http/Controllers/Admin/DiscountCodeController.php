<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DiscountCodeController extends Controller
{
    public function index()
    {
        $codes = DiscountCode::orderByDesc('created_at')->get();
        return view('admin.discount-codes.index', compact('codes'));
    }

    public function create()
    {
        return view('admin.discount-codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'       => 'required|string|max:50|unique:discount_codes,code',
            'percentage' => 'required|integer|min:1|max:100',
            'is_active'  => 'boolean',
            'uses_limit' => 'nullable|integer|min:1',
        ]);

        DiscountCode::create([
            'code'       => strtoupper(trim($request->code)),
            'percentage' => $request->percentage,
            'is_active'  => $request->boolean('is_active', true),
            'uses_limit' => $request->uses_limit,
        ]);

        return redirect()->route('admin.discount-codes.index')
            ->with('success', 'Código de descuento creado correctamente.');
    }

    public function edit(DiscountCode $discountCode)
    {
        return view('admin.discount-codes.edit', compact('discountCode'));
    }

    public function update(Request $request, DiscountCode $discountCode)
    {
        $request->validate([
            'code'       => ['required', 'string', 'max:50', Rule::unique('discount_codes', 'code')->ignore($discountCode->id)],
            'percentage' => 'required|integer|min:1|max:100',
            'is_active'  => 'boolean',
            'uses_limit' => 'nullable|integer|min:1',
        ]);

        $discountCode->update([
            'code'       => strtoupper(trim($request->code)),
            'percentage' => $request->percentage,
            'is_active'  => $request->boolean('is_active'),
            'uses_limit' => $request->uses_limit,
        ]);

        return redirect()->route('admin.discount-codes.index')
            ->with('success', 'Código de descuento actualizado correctamente.');
    }

    public function destroy(DiscountCode $discountCode)
    {
        $discountCode->delete();
        return redirect()->route('admin.discount-codes.index')
            ->with('success', 'Código eliminado correctamente.');
    }
}
