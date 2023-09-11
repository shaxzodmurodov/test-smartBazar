<?php

namespace App\Models;

use App\Enum\MerchantStatus;
use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchant extends Model
{
    use SoftDeletes;
    use Filterable;
    protected $guarded = ['id'];

    protected $casts = [
        'status' => MerchantStatus::class
    ];

    /**
     * @return HasMany
     */
    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class);
    }
}
