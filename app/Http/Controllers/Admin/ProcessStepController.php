<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcessStep;
use Illuminate\Http\Request;

class ProcessStepController extends Controller
{
    public function index()
    {
        $steps = ProcessStep::orderBy('sort_order')->get();
        return view('admin.process-steps.index', compact('steps'));
    }

    public function create()
    {
        return view('admin.process-steps.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'nullable|string|max:10',
            'sort_order'  => 'integer',
            'is_active'   => 'boolean',
        ]);

        ProcessStep::create([
            'title'       => $request->title,
            'description' => $request->description,
            'icon'        => $request->icon,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.process-steps.index')
            ->with('success', 'Paso creado correctamente.');
    }

    public function edit(ProcessStep $processStep)
    {
        return view('admin.process-steps.edit', compact('processStep'));
    }

    public function update(Request $request, ProcessStep $processStep)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'nullable|string|max:10',
            'sort_order'  => 'integer',
            'is_active'   => 'boolean',
        ]);

        $processStep->update([
            'title'       => $request->title,
            'description' => $request->description,
            'icon'        => $request->icon,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.process-steps.index')
            ->with('success', 'Paso actualizado correctamente.');
    }

    public function destroy(ProcessStep $processStep)
    {
        $processStep->delete();
        return redirect()->route('admin.process-steps.index')
            ->with('success', 'Paso eliminado correctamente.');
    }
}
