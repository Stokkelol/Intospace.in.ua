<?php
declare(strict_types=1);

namespace App\Bot\Jobs;

use App\Bot\ResponseMessages\CommandResponses\StatisticGatherer;
use App\Models\BroadcastMessage;
use App\Models\MessageType;
use App\Models\OutboundMessage;
use App\Models\OutboundMessageContext;
use App\Models\OutboundMessageText;

/**
 * Trait Saver
 *
 * @package App\Bot\Jobs
 */
trait Saver
{
    /**
     * @return OutboundMessage
     */
    protected function saveMessages(): OutboundMessage
    {
        $outboundMessage = new OutboundMessage();
        $outboundMessage->chat()->associate($this->chat);
        $outboundMessage->user()->associate($this->user);
        $outboundMessage->message_type_id = MessageType::ENTITIES;
        $outboundMessage->save();

        $outboundMessageText = new OutboundMessageText();
        $outboundMessageText->outboundMessage()->associate($outboundMessage);
        $outboundMessageText->message = $this->message;
        $outboundMessageText->save();

        $broadcastMessage = new BroadcastMessage();
        $broadcastMessage->user()->associate($this->user);
        $broadcastMessage->chat()->associate($this->chat);
        $broadcastMessage->outboundMessage()->associate($outboundMessage);
        $broadcastMessage->save();

        $context = new OutboundMessageContext();
        $context->band()->associate($this->band);
        $context->outboundMessage()->associate($outboundMessage);

        if ($this->youtubeHandler->getAlbum() !== null) {
            $context->album()->associate($this->youtubeHandler->getAlbum());
        }

        if ($this->youtubeHandler->getTrack() !== null) {
            $context->track()->associate($this->youtubeHandler->getTrack());
        }

        $context->save();

        $gatherer = new StatisticGatherer($this->user);
        $gatherer->associateBandAndUser($this->band);
        $gatherer->associateTagAndUser($this->band);

        return $outboundMessage;
    }
}