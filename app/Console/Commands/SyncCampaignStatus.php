<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Models\Campaign;

class SyncCampaignStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:sync-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize the status of all campaigns based on their social media metrics.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Synchronizing campaign status...');

        $campaigns = Campaign::with('campaign_socials')->get();
        $updatedCount = 0;

        foreach ($campaigns as $campaign) {
            if ($campaign->campaign_status === 'scheduled') {
                continue;
            }

            foreach ($campaign->campaign_socials as $social) {
                if ($social->reactions >= 10 && $social->comments >= 2) {
                    $campaign->update(['campaign_status' => 'scheduled']);
                    $this->info('Campaign #' . $campaign->id . ' updated to scheduled for '. $social->platform.'.');
                    $updatedCount++;
                    break;
                }
            }
        }

        $this->info('Campaign status updated for ' . $updatedCount . ' campaigns.');

        return Command::SUCCESS;
    }
}
