<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property int $chat_id
 * @property int $user_id
 * @property int $message_type_id
 *
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read MessageType $messageType
 *
 * Class Message
 *
 * @package App
 */
class InboundMessage extends Model
{
    const TABLE_NAME = 'inbound_messages';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'chat_id' => 'int',
        'message_type_id' => 'int',
    ];

    /**
     * @return BelongsTo
     */
    public function messageType(): BelongsTo
    {
        return $this->belongsTo(MessageType::class);
    }
}
