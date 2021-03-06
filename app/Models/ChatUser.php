<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property int $chat_id
 * @property int $active
 *
 * Class ChatUser
 *
 * @package App
 */
class ChatUser extends Model
{
    const TABLE_NAME = 'chat_user';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var array
     */
    protected $casts = [
        'user_id' => 'int',
        'chat_id' => 'int',
        'active' => 'false'
    ];
}
