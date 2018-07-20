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
                'blocks_detail' => [
                    'href' => \URL::to('/') . '/api/blocks/{blockNumber}',
                    'templated' => true
                ],
                'stats' => [
                    'href' => route('api_stats')
                ],
                'stats_24' => [
                    'href' => route('api_stats_24')
                ]
            ]
        ];
    }
}
