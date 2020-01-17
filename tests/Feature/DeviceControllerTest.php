<?php

namespace Tests\Feature;

use App\Models\Device;
use Tests\TestCase;

class DeviceControllerTest extends TestCase
{
    public function test_happy_path()
    {
        $device = factory(Device::class)->create();

        $this->get(route('device', $device))->assertOk();
    }
}
