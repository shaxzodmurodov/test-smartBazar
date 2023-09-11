<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Shop */
class ShopResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'address'   => $this->address,
            'schedule'  => $this->schedule,
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
            'distance'  => $this?->distance,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
