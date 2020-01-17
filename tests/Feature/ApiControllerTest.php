<?php

namespace Tests\Feature;

use App\Models\Data;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_getDevice_returns_correct_data()
    {
        Carbon::setTestNow('2000-01-01 12:00:00');

        // TODO use DeviceFactory::withData()->create()
        $device = factory(Device::class)->create();

        $latestData = factory(Data::class)->make(['value' => 7]);

        $fullData = factory(Data::class)->make([
            'value' => 10,
            'created_at' => now()->subHour(),
        ]);

        $yesterdayData = factory(Data::class)->make([
            'created_at' => now()->subDay(),
        ]);

        $device->data()->saveMany([$latestData, $fullData, $yesterdayData]);

        #$this->actingAs($device, 'api')
        $this->getJson(route('api.get-device', $device))
            ->assertOk()
            ->assertJsonPath('latest.value', 7)
            ->assertJsonPath('latest.percent', 70)
            ->assertJsonPath('latest.created_at', '2000-01-01T11:00:00.000000Z')
            ->assertJsonPath('latestFull.value', 10)
            ->assertJsonPath('latestFull.percent', 100)
            ->assertJsonPath('latestFull.created_at', '2000-01-01T10:00:00.000000Z')
            ->assertJsonCount(2, 'chart')
            ->assertJsonPath('chart', [
                [
                    'x' => '2000-01-01 11:00:00',
                    'y' => 100,
                ], [
                    'x' => '2000-01-01 12:00:00',
                    'y' => 70,
                ],
            ]);
    }

    public function test_postData_saves_data_correctly()
    {
        $device = factory(Device::class)->create();

        $this->actingAs($device, 'api')
            ->postJson(route('api.post-data', ['value' => 5]))
            ->assertStatus(201);

        $this->assertDatabaseHas('device_data', [
            'value' => 5,
            'device_id' => $device->id,
            'ip' => '127.0.0.1',
        ]);
    }
}
