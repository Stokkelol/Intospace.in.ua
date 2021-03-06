<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use App\Bot\Interfaces\ResponseMessage;
use App\Bot\Keyboard\Base;
use App\Bot\ResponseMessages\Interfaces\Command;
use App\Models\Chat;
use App\Models\MessageType;
use App\Models\OutboundMessage;
use App\Models\OutboundMessageContext;
use App\Models\OutboundMessageText;
use App\Models\TelegramUser;
use Telegram\Bot\Api;

/**
 * Class Factory
 *
 * @package App\Bot\ResponseMessages
 */
abstract class Response implements ResponseMessage
{
    /**
     * @var Api
     */
    protected $telegram;

    /**
     * @var string|null
     */
    protected $text;

    /**
     * @var array
     */
    protected $request;

    /**
     * @var
     */
    protected $chat;

    /**
     * @var array
     */
    protected $responseMessage = [];

    /**
     * @var array
     */
    protected $callbackResponses = [];

    /**
     * @var TelegramUser
     */
    protected $user;

    /**
     * @var bool
     */
    protected $responseIsArray = false;

    /**
     * @var int
     */
    protected $type;

    /**
     * @var string
     */
    protected $parseMode = 'Markdown';

    /**
     * @var Command
     */
    protected $command;

    /**
     * @var array
     */
    protected $keyboard = [];

    /**
     * @var array|null
     */
    protected $callback;

    /**
     * @var int
     */
    protected $updateId;

    /**
     * @param int $type
     * @param Api $telegram
     * @return ResponseMessage
     */
    public static function factory(int $type, Api $telegram)
    {
        switch ($type) {
            case MessageType::TEXT:
                return new TextResponse($telegram, $type);
                break;
            case MessageType::ENTITIES:
                return new CommandResponse($telegram, $type);
                break;
            case MessageType::CALLBACK:
                return new CallbackResponse($telegram, $type);
                break;
        }
    }

    /**
     * @return void
     */
    abstract protected function createResponse(): void;

    /**
     * @return void
     */
    abstract protected function send(): void;

    /**
     * @return Api
     */
    public function getApi(): Api
    {
        return $this->telegram;
    }

    /**
     * Factory constructor.
     *
     * @param Api $telegram
     * @param int $type
     */
    public function __construct(Api $telegram, int $type)
    {
        $this->telegram = $telegram;
        $this->type = $type;
    }

    /**
     * @return TelegramUser
     */
    public function getUser(): TelegramUser
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return Chat
     */
    public function getChat(): Chat
    {
        return $this->chat;
    }

    /**
     * @return string
     */
    public function getParseMode(): string
    {
        return $this->parseMode;
    }

    /**
     * @param array $request
     * @param Chat $chat
     * @param TelegramUser $user
     */
    public function setParameters(array $request, Chat $chat, TelegramUser $user): void
    {
        $this->request = $request;
        $this->chat = $chat;
        $this->user = $user;
        $this->text = $request['message']['text'] ?? null;
        $this->callback = $request['callback_query'] ?? null;
        $this->updateId = $request['update_id'];
    }

    /**
     * @return void
     */
    public function sendResponse()
    {
        $this->createResponse();
        $this->beforeResponse();
        $this->send();
    }

    /**
     * @return void
     */
    protected function beforeResponse(): void
    {
        $outboundMessage = new OutboundMessage();
        $outboundMessage->message_type_id = $this->type;
        $outboundMessage->user_id = $this->user->id;
        $outboundMessage->chat_id = $this->chat->id;
        $outboundMessage->inbound_message_id = $this->request['update_id'];
        $outboundMessage->save();

        $preparer = new Base;
        $counter = 1;
        foreach ($this->responseMessage as $key => $value) {
            $text = new OutboundMessageText();
            $text->message = $value;
            $text->outboundMessage()->associate($outboundMessage);
            $text->save();

            $this->keyboard[$counter][] = $preparer->prepare($text);
            $counter++;
        }

        if ($this->command !== null) {
            $context = new OutboundMessageContext();
            $context->outboundMessage()->associate($outboundMessage);
            $context->band()->associate($this->command->getBand());

            if ($this->command->getAlbum() !== null) {
                $context->album()->associate($this->command->getAlbum());
            }

            if ($this->command->getTrack() !== null) {
                $context->track()->associate($this->command->getTrack());
            }

            $context->save();
        }
    }
}