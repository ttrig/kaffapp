@extends('layouts.base')

@push('scripts')
  <script src="{{ mix('js/device.js') }}"></script>
@endpush

<div id="app" class="container mx-auto h-100">
  <device id="{{ $device->id }}"></device>
</div>
