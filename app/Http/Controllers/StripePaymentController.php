<?php

namespace App\Http\Controllers;

use App\Models\AdRequest;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripePaymentController extends Controller
{
    public function checkout(AdRequest $adRequest)
    {
        if ($adRequest->investment_amount <= 0) {
            return back()->with('error', 'El monto de inversión debe ser mayor a 0.');
        }

        if ($adRequest->stripe_payment_status === 'paid') {
            return back()->with('error', 'Este anuncio ya ha sido pagado.');
        }

        Stripe::setApiKey(config('services.stripe.secret') ?? env('STRIPE_SECRET'));

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'crc',
                            'product' => env('STRIPE_AD_REQUEST_PRODUCT_ID'),
                            'unit_amount' => (int) round($adRequest->investment_amount * 100),
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('ad-requests.payment.success', ['ad_request_id' => $adRequest->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('ad-requests.payment.cancel', ['ad_request_id' => $adRequest->id]),
                'client_reference_id' => $adRequest->id,
                'metadata' => [
                    'ad_request_id' => $adRequest->id,
                ],
            ]);

            $adRequest->update([
                'stripe_session_id' => $session->id,
                'stripe_payment_status' => 'pending',
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al iniciar el pago: ' . $e->getMessage());
        }
    }

    public function success(Request $request, $ad_request_id)
    {
        return redirect()->route('filament.admin.resources.ad-requests.index')
            ->with('status', 'Pago completado con éxito. El estado se actualizará en breve.');
    }

    public function cancel(Request $request, $ad_request_id)
    {
        return redirect()->route('filament.admin.resources.ad-requests.index')
            ->with('error', 'El pago fue cancelado.');
    }
}
