<?php

namespace Shopfolio\Repositories;

use Shopfolio\Models\Shop\Channel;

class ChannelRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return Channel::class;
    }
}
