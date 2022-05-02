<?php

namespace Joy\VoyagerDataTypeSettings\Events;

use Illuminate\Queue\SerializesModels;
use Joy\VoyagerDataTypeSettings\Models\DataTypeSetting;

class DataTypeSettingUpdated
{
    use SerializesModels;

    public $dataTypeSetting;

    public function __construct(DataTypeSetting $dataTypeSetting)
    {
        $this->dataTypeSetting = $dataTypeSetting;
    }
}
