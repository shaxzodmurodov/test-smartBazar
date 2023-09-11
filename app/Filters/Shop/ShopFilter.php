<?php

namespace App\Filters\Shop;

use App\Filters\QueryFilter;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;

/** @mixin Shop */
class ShopFilter extends QueryFilter
{
    protected $sortable = [
        'created_at' => 'created_at'
    ];
    protected $defaults = [
        'sort' => 'created_at',
        'sort_type' => 'desc'
    ];

    protected function before()
    {
        $longitude = $this->getInput('longitude');
        $latitude = $this->getInput('latitude');

        $this->builder
            ->selectRaw("shops.*");
        if (!empty($longitude) && !empty($latitude)) {
            $this->builder->selectRaw("SQRT(POW(69.1 * (latitude::float -  $latitude), 2) +
            POW(69.1 * ($longitude - longitude::float) * COS(latitude::float / 57.3), 2)
           ) as distance")
                ->orderBy('distance');
        }
        $this->builder
            ->join('merchants', 'shops.merchant_id', '=', 'merchants.id')
            ->where('merchants.user_id', auth()->id());
    }

    /**
     * @param $value
     * @return Builder
     */
    public function filterSearch($value): Builder
    {
        return $this->builder->where(function ($query) use ($value) {
            $query->where('address', 'like', '%'.$value.'%')
                ->orWhere('schedule', 'like', '%'.$value.'%')
                ->orWhere('latitude', 'like', $value.'%')
                ->orWhere('longitude', 'like', $value.'%')
            ;
        });
    }

    /**
     * @param $value
     * @return Builder
     */
    public function filterId($value): Builder
    {
        return $this->builder->where('shops.id', $value);
    }

    /**
     * @param $value
     * @return Builder
     */
    public function filterMerchantId($value): Builder
    {
        return $this->builder->where('merchant_id', $value);
    }
}
