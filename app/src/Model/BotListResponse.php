<?php


namespace App\Model;


class BotListResponse
{
    /**
     * @var BotListItem[]
     */
    private $items;

    /**
     * BotListResponse constructor.
     * @param BotListItem[] $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * @return BotListItem[]
     */
    public function getItems() : array
    {
        return $this->items;
    }

}
