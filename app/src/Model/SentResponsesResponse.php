<?php


namespace App\Model;


class SentResponsesResponse
{

    /**
     * @var SentResponsesItem[]
     */
    private $items;

    /**
     * SentResponsesResponse constructor.
     * @param SentResponsesItem[] $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * @return SentResponsesItem[]
     */
    public function getItems() : array
    {
        return $this->items;
    }

}
