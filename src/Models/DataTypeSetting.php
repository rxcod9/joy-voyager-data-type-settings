<?php

namespace Joy\VoyagerDataTypeSettings\Models;

use Illuminate\Database\Eloquent\Model;
use Joy\VoyagerDataTypeSettings\Events\DataTypeSettingUpdated;

class DataTypeSetting extends Model
{
    protected $table = 'data_type_settings';

    protected $guarded = [];

    public $timestamps = false;

    protected $dispatchesEvents = [
        'updating' => DataTypeSettingUpdated::class,
    ];
}
