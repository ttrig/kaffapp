<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Routing\Controller as BaseController;

class DeviceController extends BaseController
{
    public function __invoke(Device $device)
    {
        #dd($device);
        return view('device', compact('device'));
    }
}
