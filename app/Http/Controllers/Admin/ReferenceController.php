<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionReference;
use Illuminate\Support\Facades\Storage;

class ReferenceController extends Controller
{
    public function destroy(CommissionReference $reference)
    {
        Storage::disk('public')->delete($reference->image_path);
        $commissionId = $reference->commission_id;
        $reference->delete();

        return redirect()->route('admin.commissions.show', $commissionId)
            ->with('success', 'Imagen eliminada correctamente.');
    }
}