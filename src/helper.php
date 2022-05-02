<?php

use Joy\VoyagerDataTypeSettings\DataTypeSettings\DataTypeSettings;
use TCG\Voyager\Models\DataType;

// if (! function_exists('joyVoyagerDataTypeSettings')) {
//     /**
//      * Helper
//      */
//     function joyVoyagerDataTypeSettings($argument1 = null)
//     {
//         //
//     }
// }

if (!function_exists('dataTypeSetting')) {
    function dataTypeSetting(DataType $dataType, $key, $default = null)
    {
        return DataTypeSettings::dataTypeSetting($dataType, $key, $default);
    }
}
