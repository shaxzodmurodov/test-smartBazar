<?php

namespace App\DataObjects;

use Arr;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

abstract class AbstractDataObject implements DtoInterface
{
    /**
     * @var Object created from array
     */
    protected $object;

    /**
     * Validation rules for the DTO
     * @var array $rules
     */
    protected $rules = [];

    /**
     * @var $validator
     */
    private $validator;

    /**
     * @param array $parameters
     * @throws BindingResolutionException
     */
    public function __construct(array $parameters = [])
    {
        $this->object = collect($parameters);
        $this->validate();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->only();
    }

    /**
     * @return Collection
     */
    public function toCollection(): Collection
    {
        return collect($this->only());
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return $this->toCollection()->toJson();
    }

    /**
     * @param array $parameters
     * @return self
     * @throws BindingResolutionException
     */
    public static function make(array $parameters = []): self
    {
        return new static($parameters);
    }

    /**
     * @param string $property
     * @return mixed
     */
    public function __get(string $property)
    {
        return $this->object->get($property);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->object->isEmpty();
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isNull(string $key): bool
    {
        return $this->object->get($key) === null;
    }

    /**
     * @return void
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    protected function validate(): void
    {
        $fields = Arr::undot(array_keys($this->rules));

        $this->validator = validator()->make($this->object->only($fields)->toArray(), $this->rules);

        if (! empty($this->rules) && $this->validator->fails()) {
            throw new ValidationException($this->validator);
        }
    }

    /**
     * @inheritDoc
     */
    public function add(string $key, $value): self
    {
        $this->object->put($key, $value);
        return $this;
    }
}
