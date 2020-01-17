<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'device_data';

    protected $guarded = [];

    protected $hidden = [
        'id',
        'ip',
    ];

    protected $casts = [
        'value' => 'int',
    ];

    protected $appends = [
        'percent',
        'centiliter',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function getPercentAttribute(): ?int
    {
        if (
            ! is_int($this->value) ||
            ! $this->device->value_when_full
        ) {
            return null;
        }

        if ($this->value <= $this->device->value_when_empty ?? 0) {
            return 0;
        }

        $value = $this->value - $this->device->value_when_empty;
        $max = $this->device->value_when_full - $this->device->value_when_empty;

        $percent = number_format(($value / $max) * 100);

        return min(100, $percent);
    }

    public function getCentiliterAttribute(): ?int
    {
        if (! $this->percent || ! is_int($this->device->capacity_in_cl)) {
            return null;
        }

        return round($this->device->capacity_in_cl * ($this->percent / 100));
    }
}
