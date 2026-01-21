<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->property_name,
            'offer_status' => $this->offer_status,
            'amount_usd' => $this->offer_amount_usd,
            'amount_crc' => $this->offer_amount_crc,
            'description' => $this->description,
        ];
    }
}
