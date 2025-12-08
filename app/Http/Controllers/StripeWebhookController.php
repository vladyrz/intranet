<?php

namespace App\Http\Controllers;

use App\Models\AdRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret') ?? env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Stripe Webhook Error: Invalid Payload');
            return response()->json(['error' => 'Invalid Payload'], 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Stripe Webhook Error: Invalid Signature');
            return response()->json(['error' => 'Invalid Signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;
            default:
            // Unexpected event type
            // Log::info('Received unknown event type ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    protected function handleCheckoutSessionCompleted($session)
    {
        $adRequestId = $session->metadata->ad_request_id ?? $session->client_reference_id;

        if ($adRequestId) {
            $adRequest = AdRequest::find($adRequestId);

            if ($adRequest) {
                $adRequest->update([
                    'stripe_payment_status' => 'paid',
                    'paid_at' => now(),
                    // 'investment_amount' => $session->amount_total / 100, // Optional: Confirm amount
                ]);
                Log::info("AdRequest ID {$adRequestId} marked as paid.");
            } else {
                Log::error("AdRequest ID {$adRequestId} not found for Stripe Session {$session->id}");
            }
        } else {
            Log::error("No ad_request_id found in metadata for Stripe Session {$session->id}");
        }
    }
}
