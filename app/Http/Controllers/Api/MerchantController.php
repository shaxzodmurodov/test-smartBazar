<?php

namespace App\Http\Controllers\Api;

use App\DataObjects\Merchant\CreateOrUpdateMerchantDto;
use App\Filters\Merchant\MerchantFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdateMerchantRequest;
use App\Http\Resources\MerchantResource;
use App\Services\MerchantService;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Throwable;

class MerchantController extends Controller
{
    public function index(MerchantFilter $filter, MerchantService $service)
    {
        try {
            $merchants = $service->getMerchants($filter);

            return $this->sendResponse(data: $merchants);
        } catch (Exception $exception) {
            return $this->sendResponse(code: $exception->getCode(), message: $exception->getMessage());
        }
    }

    public function show(int $id, MerchantService $service)
    {
        try {
            $merchant = $service->getMerchant(new MerchantFilter([
                'id' => $id
            ]));

            return $this->sendResponse(data: $merchant);
        } catch (Exception $exception) {
            return $this->sendResponse(code: $exception->getCode(), message: $exception->getMessage());
        }
    }

    public function store(CreateOrUpdateMerchantRequest $request, MerchantService $service)
    {
        try {
            $merchant = $service->createOrUpdate(new CreateOrUpdateMerchantDto($request->mergeIfMissing([
                'user_id' => auth()->id()
            ])->all()));
        } catch (BindingResolutionException $e) {
            return $this->sendResponse(code: $e->getCode(), message: $e->getMessage());
        }

        return $this->sendResponse(data: new MerchantResource($merchant));
    }

    public function destroy(Request $request, MerchantService $service)
    {
        try {
            $service->delete($request->input('id'));
        } catch (Throwable $exception) {
            return $this->sendResponse(code: $exception->getCode(), message: $exception->getMessage());
        }

        return $this->sendResponse(data: null);
    }
}
