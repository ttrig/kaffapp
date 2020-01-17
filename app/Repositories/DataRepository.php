<?php

namespace App\Repositories;

use App\Models\Data;
use App\Models\Device;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class DataRepository
{
    public function todaysData(Device $device)
    {
        return $device->data()
            ->where('created_at', '>=', now()->startOfDay()->hour(7))
            ->orderBy('created_at')
            ->get();
    }

    public function chartData(Collection $data): Collection
    {
        return $data->map(fn($data) => [
            'x' => $data->created_at->format('Y-m-d H:i:s'),
            'y' => $data->percent,
        ]);
    }

    public function latestFullData(Collection $data, ?Device $device = null): ?Data
    {
        if ($data->isEmpty()) {
            return null;
        }

        if (! $device || ! $device->minutes_to_brew) {
            return $data->reverse()->firstWhere('percent', 100);
        }

        foreach ($data->where('percent', 100) as $fullData) {
            $estimatedStart = Carbon::parse($fullData->created_at)
                ->subMinutes($device->minutes_to_brew);

            $batchData = $data
                ->filter(fn($data) => $data->created_at < $fullData->created_at)
                ->filter(fn($data) => $data->created_at > $estimatedStart)
                ->filter(fn($data) => $data->value <= $device->value_when_max) // can this happen?
                ->filter(fn($data) => $data->percent > 70) // TODO calc this
            ;

            #if ($batchData->count() < $todo) {
            if ($batchData->isEmpty()) {
                continue;
            }

            return $fullData;
        }

        return null;
    }
}
