<?php

namespace App\Services;

use App\DataObjects\Merchant\CreateOrUpdateMerchantDto;
use App\Filters\Merchant\MerchantFilter;
use App\Filters\QueryFilter;
use App\Http\Resources\MerchantResource;
use App\Models\Merchant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MerchantService
{
    /**
     * @param CreateOrUpdateMerchantDto $dto
     * @return Merchant|Builder|Model
     */
    public function createOrUpdate(CreateOrUpdateMerchantDto $dto): Merchant|Model|Builder
    {
        return Merchant::query()->updateOrCreate([
            'id' => $dto->id
        ],$dto->toArray());
    }

    /**
     * @param int $id
     * @return bool|mixed|null
     */
    public function delete(int $id): mixed
    {
        return Merchant::query()->where('id', $id)->delete();
    }

    public function getMerchants(MerchantFilter $filter)
    {
        $merchants = $this->getByFilter($filter)->paginateFilter();

        return MerchantResource::collection($merchants);
    }

    /**
     * @param MerchantFilter $filter
     * @return MerchantResource
     */
    public function getMerchant(MerchantFilter $filter)
    {
        $merchants = $this->getByFilter($filter)->first();

        return new MerchantResource($merchants);
    }

    /**
     * @param QueryFilter $filter
     * @return Merchant|Builder
     */
    private function getByFilter(QueryFilter $filter): Merchant|Builder
    {
        return Merchant::query()->filter($filter);
    }
}
