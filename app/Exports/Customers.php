<?php

namespace App\Exports;

use App\Models\CustomerReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Customers implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CustomerReport::with(['user', 'organization'])->get();
    }

    public function map($report): array
    {
        return [
            $report->user->name ?? '',
            $report->customer_name ?? '',
            $report->national_id ?? '',
            $report->email ?? '',
            $report->phone_number ?? '',
            $report->property_name ?? '',
            $report->organization->organization_name ?? '',
            $report->budget_usd ?? '',
            $report->budget_crc ?? '',
            $report->expected_commission_usd ?? '',
            $report->expected_commission_crc ?? '',
            $report->financing ? 'Sí' : 'No',
            $report->report_status ?? '',
            $report->rejection_reason ?? '',
            $report->created_at ?? '',
            $report->updated_at ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            __('translate.customer_report.user_id'),
            __('translate.customer_report.customer_name'),
            __('translate.customer_report.national_id'),
            __('translate.customer_report.email'),
            __('translate.customer_report.phone_number'),
            __('translate.customer_report.property_name'),
            __('translate.customer_report.organization_id'),
            __('translate.customer_report.budget_usd'),
            __('translate.customer_report.budget_crc'),
            __('translate.customer_report.expected_commission_usd'),
            __('translate.customer_report.expected_commission_crc'),
            __('translate.customer_report.financing'),
            __('translate.customer_report.report_status'),
            __('translate.offer.rejection_reason'),
            __('translate.customer_report.created_at'),
            __('translate.customer_report.updated_at'),
        ];
    }
}
