<?php

namespace Joy\VoyagerDataTypeSettings\DataTypeSettings;

use Illuminate\Support\Facades\Cache;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Facades\Voyager;

class DataTypeSettings
{
    public static $setting_cache = null;

    /**
     * Get data type setting
     */
    public static function dataTypeSetting(DataType $dataType, $key, $default = null)
    {
        $globalCache = config('voyager.settings.cache', false);

        if ($globalCache && Cache::tags('data-type-settings-' . $dataType->slug)->has($key)) {
            return Cache::tags('data-type-settings-' . $dataType->slug)->get($key);
        }

        if (self::$setting_cache === null || (self::$setting_cache[$dataType->slug] ?? null) === null) {
            if ($globalCache) {
                // A key is requested that is not in the cache
                // this is a good opportunity to update all keys
                // albeit not strictly necessary
                Cache::tags('data-type-settings-' . $dataType->slug)->flush();
            }

            $settings = Voyager::model('DataTypeSetting')->whereDataTypeSlug($dataType->slug)->orderBy('order')->get();
            foreach ($settings as $setting) {
                $keys                                                      = explode('.', $setting->key);
                @self::$setting_cache[$dataType->slug][$keys[0]][$keys[1]] = optional($setting)->value ?? null;

                if ($globalCache) {
                    Cache::tags('data-type-settings-' . $dataType->slug)->forever($setting->key, $setting->value);
                }
            }
        }

        $parts = explode('.', $key);

        if (count($parts) == 2) {
            return @self::$setting_cache[$dataType->slug][$parts[0]][$parts[1]] ?: $default;
        } else {
            return @self::$setting_cache[$dataType->slug][$parts[0]] ?: $default;
        }
    }
}
