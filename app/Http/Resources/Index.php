<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Index extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            '_links' => [
                'self' => [
                    'href' => route('api_index')
                ],
                'blocks_latest' => [
                    'href' => route('api_blocks_latest')
                ],
                'stats_24' => [
                    'href' => route('api_blocks_latest')
                ]
            ]
        ];
    }
}
