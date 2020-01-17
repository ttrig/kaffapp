<?php

namespace Tests;

use App\Models\Data;
use App\Models\Device;

class DeviceFactory
{
    private $attributes = [];
    private $dataModels = [];
    private $states = [];

    public function states(...$states): self
    {
        foreach ($states as $state) {
            $this->states[] = $state;
        }

        return $this;
    }

    public function withData(array $data): self
    {
        foreach ($data as $data) {
            if (! $data instanceof Data) {
                $data = factory(Data::class)->make($data);
            }
            $this->dataModels[] = $data;
        }

        return $this;
    }

    public function make(array $override = []): Device
    {
        \Facades\DeviceFactory::clearResolvedInstance(static::class);

        return factory(Device::class)
            ->states($this->states)
            ->make(array_merge($this->attributes, $override));
    }

    public function create(array $override = []): Device
    {
        $device = tap($this->make($override))->save();

        $device->data()->saveMany($this->dataModels);

        return $device;
    }
}
