<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $band_id
 * @property int $value
 * @property int $lastfm_count
 * @property int $likes_count
 * @property int $dislikes_count
 *
 * Class BandTelegramUser
 *
 * @package App
 */
class BandTelegramUser extends Model
{
    const TABLE_NAME = 'band_telegram_user';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'band_id' => 'int',
        'value' => 'int',
        'lastfm_count' => 'int'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(TelegramUser::class);
    }

    /**
     * @param Builder $query
     * @param int $userId
     * @param int $bandId
     * @return Builder
     */
    public function scopeFindByBandAndUser(Builder $query, int $userId, int $bandId): Builder
    {
        return $query->where('band_id', '=', $bandId)->where('user_id','=',$userId);
    }
}
