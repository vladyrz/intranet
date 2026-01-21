<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Offer::where('user_id', $user->id);

        // Example of extra filtering if needed (e.g., ?offer_status=rejected)
        if ($request->has('offer_status')) {
            $query->where('offer_status', $request->offer_status);
        }

        $offers = $query->latest()->paginate(15);

        return OfferResource::collection($offers);
    }

    public function show(Offer $offer)
    {
        // Simple check if policy doesn't exist yet, or use policy if created
        if ($offer->user_id !== request()->user()->id) {
            abort(403, 'Unauthorized access to this offer.');
        }

        return new OfferResource($offer);
    }
}
