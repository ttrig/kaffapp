<?php

namespace App\Http\Controllers;

use App\Events\DataWasReceived;
use App\Models\Device;
use App\Repositories\DataRepository;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ApiController extends BaseController
{
    public function getDevice(DataRepository $repo, Device $device)
    {
        $todaysData = $repo->todaysData($device);

        return [
            'latest' => $todaysData->last(),
            'latestFull' => $repo->latestFullData($todaysData),
            'chart' => $repo->chartData($todaysData),
        ];
    }

    public function postData(Request $request)
    {
        $device = Auth::user();

        // TODO remove nullable?
        $request->validate([
            'value' => [
                'nullable',
                'required',
                'numeric',
                'min' => $device->value_when_empty,
                'max' => $device->value_when_full,
            ],
        ]);

        $data = $device->data()->create([
            'value' => $request->value,
            // TODO use the device to calculate the "real" value?
            #'percent' => $request->value / $device->value_when_full,
            'ip' => $request->getClientIp(),
        ]);

        event(new DataWasReceived($data));

        return $data;
    }
}
