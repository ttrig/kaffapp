<?php

namespace Tests;

use App\Models\Data;
use App\Models\Device;

class DataFactory
{
    private $attributes = [];
    private $states = [];

    public function states(...$states): self
    {
        foreach ($states as $state) {
            $this->states[] = $state;
        }

        return $this;
    }

    public function forDevice(Device $device): self
    {
        $this->attributes['device_id'] = $device->id;

        return $this;
    }

    public function make(array $override = []): Data
    {
        \Facades\DataFactory::clearResolvedInstance(static::class);

        return factory(Data::class)
            ->states($this->states)
            ->make(array_merge($this->attributes, $override));
    }

    public function create(array $override = []): Data
    {
        return tap($this->make($override))->save();
    }
}
