<?php

namespace Tests\Unit\Model;

use App\Models\Data;
use App\Models\Device;
use App\Repositories\DataRepository;
use Facades\Tests\DataFactory;
use Facades\Tests\DeviceFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DataRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_todaysData_returns_correct_data()
    {
        $device = factory(Device::class)->create();

        Carbon::setTestNow('2020-01-01 06:00:00');

        $device->data()->save(factory(Data::class)->make());

        Carbon::setTestNow('2020-01-01 07:00:00');

        $device->data()->save(factory(Data::class)->make());

        $this->assertEquals(1, (new DataRepository())->todaysData($device)->count());
    }

    public function test_chartData_returns_correct_data()
    {
        $data = factory(Data::class, 2)->create();

        $result = (new DataRepository())->chartData($data);

        $this->assertEquals(2, $result->count());
        $this->assertNotEmpty($result->pluck('x'));
        $this->assertNotEmpty($result->pluck('y'));
    }

    public function test_latestFullData_returns_null_when_not_found()
    {
        $device = factory(Device::class)->create();

        $device->data()->save(factory(Data::class)->create(['value' => 5]));

        $this->assertNull((new DataRepository())->latestFullData($device->data));
    }

    public function test_latestFullData_without_minuteSpan()
    {
        $device = factory(Device::class)->create([
            'minutes_to_brew' => 5,
        ]);

        $device->data()->saveMany([
            factory(Data::class)->create(['created_at' => '2020-01-01 08:00:00', 'value' => null]),
            factory(Data::class)->create(['created_at' => '2020-01-01 08:01:00', 'value' => 1]),
            factory(Data::class)->create(['created_at' => '2020-01-01 08:02:00', 'value' => 3]),
            factory(Data::class)->create(['created_at' => '2020-01-01 08:03:00', 'value' => 5]),
            factory(Data::class)->create(['created_at' => '2020-01-01 08:04:00', 'value' => 7]),
            factory(Data::class)->create(['created_at' => '2020-01-01 08:05:00', 'value' => 9]),
            factory(Data::class)->create(['created_at' => '2020-01-01 08:06:00', 'value' => 10]),
            factory(Data::class)->create(['created_at' => '2020-01-01 09:00:00', 'value' => null]),
            factory(Data::class)->create(['created_at' => '2020-01-01 09:01:00', 'value' => 1]),
            factory(Data::class)->create(['created_at' => '2020-01-01 09:02:00', 'value' => 3]),
            factory(Data::class)->create(['created_at' => '2020-01-01 09:03:00', 'value' => 5]),
            factory(Data::class)->create(['created_at' => '2020-01-01 09:04:00', 'value' => 7]),
            factory(Data::class)->create(['created_at' => '2020-01-01 09:05:00', 'value' => 9]),
            factory(Data::class)->create(['created_at' => '2020-01-01 09:06:00', 'value' => 10]),
            factory(Data::class)->create(['created_at' => '2020-01-01 09:07:00', 'value' => 10]),
            factory(Data::class)->create(['created_at' => '2020-01-01 09:08:00', 'value' => 10]),
            factory(Data::class)->create(['created_at' => '2020-01-01 09:09:00', 'value' => 8]),
        ]);

        $result = (new DataRepository())->latestFullData($device->data);

        $this->assertEquals('2020-01-01 09:08:00', $result->created_at->toDateTimeString());
    }

    public function test_latestFullData_with_minuteSpan()
    {
        Carbon::setTestNow('2020-01-01 08:00:00');

        $data = [
            ['created_at' => now()->subHour(), 'value' => 9],
            ['created_at' => now()->subHour()->addMinute(), 'value' => 10],
            ['created_at' => now()->addMinutes(0), 'value' => null],
            ['created_at' => now()->addMinutes(1), 'value' => 1],
            ['created_at' => now()->addMinutes(2), 'value' => 3],
            ['created_at' => now()->addMinutes(3), 'value' => 5],
            ['created_at' => now()->addMinutes(3), 'value' => 10],
            ['created_at' => now()->addMinutes(4), 'value' => 7],
            ['created_at' => now()->addMinutes(5), 'value' => 9],
            ['created_at' => now()->addMinutes(6), 'value' => 10],
            ['created_at' => now()->addMinutes(8), 'value' => 8],
            ['created_at' => now()->addMinutes(10), 'value' => 6],
            ['created_at' => now()->addMinutes(12), 'value' => 10],
        ];

        $device = DeviceFactory::withData($data)->create([
            'minutes_to_brew' => 5,
        ]);

        $result = (new DataRepository())->latestFullData($device->data, $device->minutes_to_brew);
#dd($result);
        $this->assertEquals('2020-01-01 08:06:00', $result->created_at->toDateTimeString());
    }
}
