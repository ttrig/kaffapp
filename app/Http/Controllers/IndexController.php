<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Routing\Controller as BaseController;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $devices = Device::all();

        if (false || $devices->count() === 1) {
            redirect()->route('device.show', $devices->first());
        }

        return view('index', compact('devices'));
    }
}
