<?php

namespace App\DataObjects\Merchant;

use App\DataObjects\AbstractDataObject;

/**
 * @property $id
 * @property $name
 * @property $status
 * @property $user_id
 */
class CreateOrUpdateMerchantDto extends AbstractDataObject
{

    /**
     * @inheritDoc
     */
    public function only(): array
    {
        return [
            'user_id'   => $this->user_id,
            'name'      => $this->name,
            'status'    => $this->status,
        ];
    }
}
