<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Merchant */
class MerchantCollection extends ResourceCollection
{
    public $collection = MerchantResource::class;
    public function toArray(Request $request): array
    {
        return [
            'data'      => $this->collection,
            'total'     => $this->resource->total(),
            'page'      => $this->resource->currentPage(),
            'per_page'  => $this->resource->perPage(),
        ];
    }
}
