<?php

namespace Tests\Unit\Model;

use App\Models\Data;
use App\Models\Device;
use Facades\Tests\DataFactory;
use Facades\Tests\DeviceFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataTest extends TestCase
{
    use RefreshDatabase;

    public function test_percent_with_easy_device_values()
    {
        $device = DeviceFactory::create([
            'value_when_empty' => 0,
            'value_when_full' => 100,
        ]);

        $data = DataFactory::forDevice($device)->create(['value' => null]);

        $this->assertNull($data->percent);

        $data->value = 0;
        $this->assertEquals(0, $data->percent);

        $data->value = 50;
        $this->assertEquals(50, $data->percent);

        $data->value = 100;
        $this->assertEquals(100, $data->percent);

        $data->value = 150;
        $this->assertEquals(100, $data->percent);
    }

    public function test_percent_with_realistic_device_values()
    {
        $device = DeviceFactory::create([
            'value_when_empty' => 74,
            'value_when_full' => 496,
        ]);

        $data = DataFactory::forDevice($device)->create(['value' => null]);

        $this->assertNull($data->percent);

        $data->value = 0;
        $this->assertEquals(0, $data->percent);

        $data->value = 50;
        $this->assertEquals(0, $data->percent);

        $data->value = 74;
        $this->assertEquals(0, $data->percent);

        $data->value = 100;
        $this->assertEquals(6, $data->percent);

        $data->value = 200;
        $this->assertEquals(30, $data->percent);

        $data->value = 300;
        $this->assertEquals(54, $data->percent);

        $data->value = 486;
        $this->assertEquals(98, $data->percent);

        $data->value = 496;
        $this->assertEquals(100, $data->percent);

        $data->value = 700;
        $this->assertEquals(100, $data->percent);
    }

    public function test_centiliter()
    {
        $device = factory(Device::class)->create([
            'value_when_empty' => 0,
            'value_when_full' => 100,
            'capacity_in_cl' => 125,
        ]);

        $data = $device->data()->save(factory(Data::class)->make(['value' => null]));
        $this->assertNull($data->centiliter);

        $data->value = 0;
        $this->assertEquals(0, $data->centiliter);

        $data->value = 50;
        $this->assertEquals(63, $data->centiliter);

        $data->value = 100;
        $this->assertEquals(125, $data->centiliter);

        $data->value = 200;
        $this->assertEquals(125, $data->centiliter);
    }
}
