<?php

namespace App\Http\Controllers;

use App\Models\PageSetting;
use App\Models\PortfolioItem;
use App\Models\SocialLink;
use App\Models\CommissionPackage;
use App\Models\Commission;
use App\Models\DiscountCode;
use App\Models\ProcessStep;
use App\Models\Faq;
use App\Models\MusicTrack;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\CommissionReference;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Product;


class HomeController extends Controller
{
    public function index()
    {
        $settings = PageSetting::pluck('value', 'key');

        $portfolio = PortfolioItem::where('is_visible', true)
            ->with('portfolioCategory')
            ->orderBy('sort_order')
            ->get();

        $portfolioCategories = $portfolio
            ->filter(fn($i) => $i->portfolioCategory !== null)
            ->map(fn($i) => $i->portfolioCategory)
            ->unique('id')
            ->values();

        $categories = Category::where('is_active', true)
            ->with(['packages' => function ($q) {
                $q->where('is_active', true)->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        $packages = CommissionPackage::where('is_active', true)
            ->whereNull('category_id')
            ->orderBy('sort_order')
            ->get();

        $socialLinks = SocialLink::where('is_active', true)
            ->whereNotNull('url')
            ->get();

        $slots = (int) ($settings['commission_slots'] ?? 8);

        $inProgress = Commission::where('status', 'in_progress')
            ->orderByDesc('is_priority')
            ->latest()
            ->take($slots)
            ->get();

        $availableSlots = max(0, $slots - $inProgress->count());

        $completedCommissions = Commission::whereIn('status', ['delivered', 'paid'])
            ->latest()
            ->take(8)
            ->get();

        $totalCompleted = Commission::whereIn('status', ['delivered', 'paid'])->count();

        $products = Product::where('is_active', true)
            ->with('category')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category_id');

        $processSteps = ProcessStep::where('is_active', true)->orderBy('sort_order')->get();
        $faqs         = Faq::where('is_active', true)->orderBy('sort_order')->get();
        $musicTracks  = MusicTrack::where('is_active', true)->orderBy('sort_order')->get();
        $portfolioCount = PortfolioItem::where('is_visible', true)->count();

        return view('home', compact(
            'settings',
            'portfolio',
            'portfolioCategories',
            'packages',
            'categories',
            'products',
            'socialLinks',
            'inProgress',
            'availableSlots',
            'slots',
            'completedCommissions',
            'totalCompleted',
            'processSteps',
            'faqs',
            'musicTracks',
            'portfolioCount'
        ));
    }

    public function contact(Request $request)
    {
        $request->validate([
            'client_name'     => 'required|string|max:255',
            'client_email'    => 'required|email',
            'commission_type' => 'required|string',
            'description'     => 'required|string',
            'references.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $commission = Commission::create([
            'client_name'     => $request->client_name,
            'client_email'    => $request->client_email,
            'client_discord'  => null,
            'commission_type' => $request->commission_type,
            'description'     => $request->description,
            'status'          => 'pending',
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

        $contactEmail = PageSetting::get('contact_email');

        if ($contactEmail) {
            Mail::to($contactEmail)->send(new ContactFormMail(
                clientName: $request->client_name,
                clientEmail: $request->client_email,
                commissionType: $request->commission_type,
                description: $request->description,
                references: $commission->references()->get(),
            ));
        }

        return redirect()->route('home', '#contacto')
            ->with('success', '¡Mensaje enviado! Te contactaré pronto.');
    }

    public function applyDiscount(Request $request)
    {
        $request->validate([
            'code'  => 'required|string',
            'total' => 'required|numeric|min:0',
        ]);

        $code = DiscountCode::where('code', strtoupper(trim($request->code)))->first();

        if (! $code || ! $code->isValid()) {
            return response()->json([
                'valid'   => false,
                'message' => 'Código inválido o expirado.',
            ]);
        }

        $discount = round($request->total * ($code->percentage / 100), 2);

        return response()->json([
            'valid'           => true,
            'percentage'      => $code->percentage,
            'discount_amount' => $discount,
            'final_total'     => round($request->total - $discount, 2),
            'message'         => "¡{$code->percentage}% de descuento aplicado!",
        ]);
    }
}
