<?php

namespace App\Http\Controllers\Api;

use App\DataObjects\Shop\CreateOrUpdateShopDto;
use App\Filters\Shop\ShopFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateShopRequest;
use App\Http\Resources\ShopResource;
use App\Services\ShopService;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Throwable;

class ShopController extends Controller
{
    public function index(ShopFilter $filter, ShopService $service)
    {
        try {
            $merchants = $service->getShops($filter);

            return $this->sendResponse(data: $merchants);
        } catch (Exception $exception) {
            return $this->sendResponse(code: $exception->getCode(), message: $exception->getMessage());
        }
    }

    public function show(int $id, ShopService $service)
    {
        try {
            $merchant = $service->getShop(new ShopFilter([
                'id' => $id
            ]));

            return $this->sendResponse(data: $merchant);
        } catch (Exception $exception) {
            return $this->sendResponse(code: $exception->getCode(), message: $exception->getMessage());
        }
    }

    public function store(CreateShopRequest $request, ShopService $service)
    {
        try {
            $merchant = $service->createOrUpdate(new CreateOrUpdateShopDto($request->mergeIfMissing([
                'user_id' => auth()->id()
            ])->all()));
        } catch (BindingResolutionException $e) {
            return $this->sendResponse(code: $e->getCode(), message: $e->getMessage());
        }

        return $this->sendResponse(data: new ShopResource($merchant));
    }

    public function destroy(Request $request, ShopService $service)
    {
        try {
            $service->delete($request->input('id'));
        } catch (Throwable $exception) {
            return $this->sendResponse(code: $exception->getCode(), message: $exception->getMessage());
        }

        return $this->sendResponse(data: null);
    }
}
