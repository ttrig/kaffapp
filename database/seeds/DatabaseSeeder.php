<?php

use App\Models\Data;
use App\Models\Device;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // TODO DeviceFactory here
        factory(Device::class)
            ->create()
            ->data()
            ->saveMany([
                $this->makeData(null, '08:00:00'),
                $this->makeData(null, '08:01:00'),

                //  water in
                $this->makeData(90, '08:05:00'),

                // start
                $this->makeData(95, '08:06:00'),

                // full
                $this->makeData(100, '08:10:00'),
                $this->makeData(100, '08:11:00'),
                $this->makeData(100, '08:12:00'),

                // first cup
                $this->makeData(90, '08:13:00'),
                $this->makeData(90, '08:14:00'),
                $this->makeData(90, '08:15:00'),

                // more cups
                $this->makeData(20, '08:16:00'),
                $this->makeData(20, '08:17:00'),
                $this->makeData(20, '08:18:00'),

                // last cup
                $this->makeData(5, '08:19:00'),
                $this->makeData(6, '08:20:00'),
                $this->makeData(5, '08:21:00'),
                $this->makeData(4, '08:22:00'),

                // water in
                $this->makeData(90, '08:28:00'),
                $this->makeData(97, '08:29:00'),

                // full
                $this->makeData(99, '08:33:00'),
                $this->makeData(100, '08:34:00'),
                $this->makeData(100, '08:35:00'),
                $this->makeData(100, '08:36:00'),
                $this->makeData(100, '08:37:00'),

                $this->makeData(80, '08:40:00'),
                $this->makeData(79, '08:41:00'),
            ])
        ;
    }

    private function makeData(?int $value, string $timeString): Data
    {
        return factory(Data::class)->make([
            'value' => $value,
            'created_at' => Carbon::createFromTimeString($timeString),
        ]);
    }
}
