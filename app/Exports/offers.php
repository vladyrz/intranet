<?php

namespace App\Exports;

use App\Models\Offer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class offers implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Offer::with(['user', 'organization', 'personal_customer'])->get();
    }

    private function translateStatus(string $status): string
    {
        $map = [
            'pending' => __('translate.offer.options_offer_status.0'),
            'received' => __('translate.offer.options_offer_status.1'),
            'sent' => __('translate.offer.options_offer_status.2'),
            'approved' => __('translate.offer.options_offer_status.3'),
            'rejected' => __('translate.offer.options_offer_status.4'),
            'signed' => __('translate.offer.options_offer_status.5'),
        ];

        return $map[$status] ?? $status;
    }

    public function map($row): array
    {
        return [
            $row->property_name ?? '',
            $row->property_value_usd ?? '',
            $row->property_value_crc ?? '',
            $row->organization->organization_name ?? '',
            $row->user->name ?? '',
            $row->personal_customer->full_name ?? '',
            $row->personal_customer->national_id ?? '',
            $row->personal_customer->phone_number ?? '',
            $row->personal_customer->email ?? '',
            $row->offer_amount_usd ?? '',
            $row->offer_amount_crc ?? '',
            $this->translateStatus($row->offer_status ?? ''),
            $row->rejection_reason ?? '',
            $row->created_at ?? '',
            $row->updated_at ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            __('translate.offer.property_name'),
            __('translate.offer.property_value_usd'),
            __('translate.offer.property_value_crc'),
            __('translate.offer.organization_id'),
            __('translate.offer.user_id'),
            __('translate.offer.personal_customer_id'),
            __('translate.offer.personal_customer_national_id'),
            __('translate.offer.personal_customer_phone_number'),
            __('translate.offer.personal_customer_email'),
            __('translate.offer.offer_amount_usd'),
            __('translate.offer.offer_amount_crc'),
            __('translate.offer.offer_status'),
            __('translate.offer.rejection_reason'),
            __('translate.offer.created_at'),
            __('translate.offer.updated_at'),
        ];
    }
}
