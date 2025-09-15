<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;
use Carbon\Carbon;

class FinishCampaigns extends Command
{
    protected $signature = 'campaign:finish';
    protected $description = 'Set campaigns to finished if end_date has passed.';

    public function handle()
    {
        $today = Carbon::today();

        $campaigns = Campaign::where('campaign_status', 'scheduled')
            ->whereDate('end_date', '<=', $today)
            ->get();

        foreach ($campaigns as $campaign) {
            $campaign->update(['campaign_status' => 'finished']);
            $this->info('Campaign #' . $campaign->id . ' updated to finished.');
        }

        return Command::SUCCESS;
    }
}
