<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */

    public $collects = '';
    public $extraMeta = null;

    public function __construct($collection, $collects = null, $extraMeta = null)
    {
        $this->collects = $collects;
        $this->extraMeta = $extraMeta;
        parent::__construct($collection);
    }

    public function toArray($request)
    {
        return $this->collection;
    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent());
        if (isset($jsonResponse->links) && isset($jsonResponse->meta)) {
            unset($jsonResponse->links);
        }

        if (!is_null($this->extraMeta)) {
            $jsonResponse->extraMeta=$this->extraMeta;
        }

        $response->setContent(json_encode($jsonResponse));
    }
}
