<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;
use App\Models\CommissionReference;
use Illuminate\Support\Facades\Storage;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = Commission::latest()->paginate(10);
        return view('admin.commissions.index', compact('commissions'));
    }

    public function show(Commission $commission)
    {
        return view('admin.commissions.show', compact('commission'));
    }

    public function edit(Commission $commission)
    {
        return view('admin.commissions.edit', compact('commission'));
    }

    public function update(Request $request, Commission $commission)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,delivered,paid',
            'price'  => 'nullable|numeric|min:0',
            'notes'  => 'nullable|string',
        ]);

        $commission->update($request->only('status', 'price', 'notes'));

        return redirect()->route('admin.commissions.index')
            ->with('success', 'Comisión actualizada correctamente.');
    }

    public function destroy(Commission $commission)
    {
        $commission->delete();
        return redirect()->route('admin.commissions.index')
            ->with('success', 'Comisión eliminada correctamente.');
    }

public function store(Request $request)
    {
        $request->validate([
            'client_name'     => 'required|string|max:255',
            'client_email'    => 'required|email',
            'client_discord'  => 'nullable|string|max:255',
            'commission_type' => 'required|string',
            'description'     => 'required|string',
            'status'          => 'required|in:pending,in_progress,delivered,paid',
            'price'           => 'nullable|numeric|min:0',
            'notes'           => 'nullable|string',
            'references.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $commission = Commission::create([
            'client_name'     => $request->client_name,
            'client_email'    => $request->client_email,
            'client_discord'  => $request->client_discord,
            'commission_type' => $request->commission_type,
            'description'     => $request->description,
            'status'          => $request->status,
            'price'           => $request->price,
            'notes'           => $request->notes,
        ]);

        if ($request->hasFile('references')) {
            foreach ($request->file('references') as $image) {
                $path = $image->store('references', 'public');
                CommissionReference::create([
                    'commission_id' => $commission->id,
                    'image_path'    => $path,
                ]);
            }
        }

        return redirect()->route('admin.commissions.index')
            ->with('success', 'Comisión creada correctamente.');
    }

    public function create()
    {
        return view('admin.commissions.create');
    }
}