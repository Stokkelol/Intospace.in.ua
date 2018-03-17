<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Latest
 *
 * @package app\Bot\ResponseMessages\CommandResponses
 */
class Latest extends BaseCommand implements Command
{
    /**
     * @return array
     */
    public function prepare(): array
    {
        $posts = $this->post->active(5)->get();

        $this->associatePostAndUser($posts);
        
        $result = [];
        foreach ($posts as $post) {
            $result[] = static::POSTS_ENDPOINT . $post->slug;
        }

        return $result;
    }

    /**
     * @param Collection $posts
     * @return void
     */
    public function associatePostAndUser(Collection $posts): void
    {
        foreach ($posts as $post) {
            $gatherer = StatisticGatherer::createFromCommand($post, $this->user);
            $gatherer->associateBandAndUser()->associateTagAndUser();
        }
    }
}