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
                ],
                'stats_highest_volume' => [
                    'href' => route('api_stats_highest_volume')
                ],
                'stats_highest_volume_top10' => [
                    'href' => route('api_stats_highest_volume_top10')
                ],
                'stats_highest_fee' => [
                    'href' => route('api_stats_highest_fee')
                ],
                'stats_highest_fee_top10' => [
                    'href' => route('api_stats_highest_fee_top10')
                ],
                'foundation' => [
                    'href' => route('api_foundation')
                ],

                'timeline_daily' => [
                    'href' => route('api_timeline_daily')
                ],
                'timeline_weekly' => [
                    'href' => route('api_timeline_weekly')
                ],
                'timeline_monthly' => [
                    'href' => route('api_timeline_monthly')
                ],
                'timeline_yearly' => [
                    'href' => route('api_timeline_yearly')
                ]
            ]
        ];
    }
}
