<?php


namespace App\Model;


class JobsListResponse
{
    /**
     * @var JobsListItem[]
     */
    private $items;

    /**
     * JobsListResponse constructor.
     * @param JobsListItem[] $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * @return JobsListItem[]
     */
    public function getItems() : array
    {
        return $this->items;
    }


}
