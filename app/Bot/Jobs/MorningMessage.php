<?php
declare(strict_types=1);

namespace App\Bot\Jobs;

use App\Bot\ResponseMessages\CommandResponses\BaseCommand;
use App\Bot\ResponseMessages\CommandResponses\StatisticGatherer;
use App\Models\BroadcastMessage;
use App\Models\Chat;
use App\Models\OutboundMessage;
use App\Models\Post;
use Illuminate\Container\Container;
use Telegram\Bot\Api;

/**
 * Class MorningMessage
 *
 * @package App\Bot\Jobs
 */
class MorningMessage extends BotJob
{
    /**
     * @var mixed
     */
    private $post;


    /**
     * Create a new job instance.
     *
     * @param Chat $chat
     * @param OutboundMessage $outboundMessage
     * @param BroadcastMessage $broadcastMessage
     * @throws \InvalidArgumentException
     */
    public function __construct(Chat $chat, OutboundMessage $outboundMessage, BroadcastMessage $broadcastMessage)
    {
        parent::__construct($chat);

        $user = $chat->users->first();

        $this->post = Post::query()->get()->random();

        $this->saveMessages($outboundMessage, $broadcastMessage, $user);

        $gatherer = new StatisticGatherer();
        $gatherer->associatePostAndUser($this->post, $user);
        $gatherer->associateTagAndUser($this->post, $user);

    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function handle(): void
    {
        $telegram = Container::getInstance()->make(Api::class);

        $telegram->sendMessage([
            'chat_id' => $this->chat->id,
            'text' => BaseCommand::POSTS_ENDPOINT . $this->post->slug
        ]);
    }
}
