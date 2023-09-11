<?php

namespace App\Filters\Merchant;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class MerchantFilter extends QueryFilter
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
        $this->builder->where('user_id', auth()->id());
    }

    /**
     * @param $value
     * @return Builder
     */
    public function filterSearch($value): Builder
    {
        return $this->builder->where('name', 'like', $value.'%');
    }

    /**
     * @param $value
     * @return Builder
     */
    public function filterStatus($value): Builder
    {
        return $this->builder->where('status', $value);
    }

    /**
     * @param $value
     * @return Builder
     */
    public function filterId($value): Builder
    {
        return $this->builder->where('id', $value);
    }
}
