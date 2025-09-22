<?php

namespace App\Mail;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignScheduled extends Mailable
{
    use Queueable, SerializesModels;

    public Campaign $campaign;

    /**
     * Create a new message instance.
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Campaña a pautar')
                    ->view('mails.campaign_scheduled')
                    ->with([
                        'campaignName' => $this->campaign->title,
                    ]);
    }
}
