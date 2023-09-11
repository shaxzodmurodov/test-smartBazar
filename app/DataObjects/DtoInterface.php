<?php

namespace App\DataObjects;

use Illuminate\Support\Collection;

interface DtoInterface
{
    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return Collection
     */
    public function toCollection(): Collection;

    /**
     * @param array $parameters
     * @return AbstractDataObject
     */
    public static function make(array $parameters): AbstractDataObject;

    /**
     * @return mixed
     */
    public function add(string $key, $value): AbstractDataObject;

    /**
     * @return array
     */
    public function only(): array;

    /**
     * @return bool
     */
    public function isEmpty(): bool;
}
