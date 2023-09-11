<?php

namespace App\DataObjects\Shop;

use App\DataObjects\AbstractDataObject;

/**
 * @property $id
 * @property $merchant_id
 * @property $address
 * @property $schedule
 * @property $latitude
 * @property $longitude
 */
class CreateOrUpdateShopDto extends AbstractDataObject
{

    /**
     * @inheritDoc
     */
    public function only(): array
    {
        return [
            'merchant_id' => $this->merchant_id,
            'address'     => $this->address,
            'schedule'    => $this->schedule,
            'latitude'    => $this->latitude,
            'longitude'   => $this->longitude,
        ];
    }
}
