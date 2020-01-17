@extends('layouts.base')

<div id="app" class="h-100">
  <div class="w-full flex flex-col items-center justify-center font-sans">
    <h1 class="text-6xl my-4 text-white">Devices</h1>
    @foreach ($devices as $device)
      <a href="{{ route('device.show', $device) }}" class="bg-blue-500 hover:bg-blue-400 text-white text-2xl font-bold py-4 px-6 border-b-4 border-blue-700 hover:border-blue-500 rounded">
        {{ $device->name ?: '#' . $device->id }}
      </a>
    @endforeach
  </div>
</div>
