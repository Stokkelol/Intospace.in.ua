<?php
declare(strict_types=1);

namespace App\Bot\Jobs;

use App\Models\TelegramUser;
use App\Support\Logger\Logger;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Telegram\Bot\Api;

/**
 * Class EveningMessage
 *
 * @package App\Bot\Jobs
 */
class EveningMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TelegramUser
     */
    private $user;

    /**
     * @var Api
     */
    private $telegram;

    /**
     * Create a new job instance.
     *
     * @param TelegramUser $user
     * @param Api $telegram
     */
    public function __construct(TelegramUser $user, Api $telegram)
    {
        $this->user = $user;
        $this->telegram = $telegram;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        //
    }

    /**
     * @param \Throwable $e
     */
    public function failed(\Throwable $e): void
    {
        Logger::exception($e);
    }
}
