<?php

namespace App\Services;

use App\DataObjects\Shop\CreateOrUpdateShopDto;
use App\Filters\Shop\ShopFilter;
use App\Filters\QueryFilter;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ShopService
{
    /**
     * @param CreateOrUpdateShopDto $dto
     * @return Shop|Builder|Model
     */
    public function createOrUpdate(CreateOrUpdateShopDto $dto): Shop|Model|Builder
    {
        return Shop::query()->updateOrCreate([
            'id' => $dto->id
        ],$dto->toArray());
    }

    /**
     * @param int $id
     * @return bool|mixed|null
     */
    public function delete(int $id): mixed
    {
        return Shop::query()->where('id', $id)->delete();
    }

    /**
     * @param ShopFilter $filter
     * @return AnonymousResourceCollection
     */
    public function getShops(ShopFilter $filter): AnonymousResourceCollection
    {
        $shops = $this->getByFilter($filter)->paginateFilter();

        return ShopResource::collection($shops);
    }

    /**
     * @param ShopFilter $filter
     * @return ShopResource
     */
    public function getShop(ShopFilter $filter): ShopResource
    {
        $shop = $this->getByFilter($filter)->firstOrFail();

        return new ShopResource($shop);
    }

    /**
     * @param QueryFilter $filter
     * @return Shop|Builder
     */
    private function getByFilter(QueryFilter $filter): Shop|Builder
    {
        return Shop::query()->filter($filter);
    }
}
