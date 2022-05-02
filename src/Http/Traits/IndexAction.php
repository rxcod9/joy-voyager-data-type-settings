<?php

namespace Joy\VoyagerDataTypeSettings\Http\Traits;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

trait IndexAction
{
    //***************************************
    //               ____
    //              |  _ \
    //              | |_) |
    //              |  _ <
    //              | |_) |
    //              |____/
    //
    //      DataTypeSettings DataTable our Data Type (B)READ
    //
    //****************************************

    public function index(Request $request)
    {
        // Check permission
        $this->authorize(
            'browse',
            Voyager::model('DataTypeSetting'),
        );


        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->whereSlug($slug)->firstOrFail();

        $types        = Voyager::model('DataTypeSetting')->whereDataTypeSlug($dataType->slug)->orderBy('order', 'ASC')->get();
        $dataTypeSettings = Voyager::model('DataTypeSetting')->whereDataTypeSlug($dataType->slug)->orderBy('order', 'ASC')->get();

        $settingTypes                                        = [];
        $settings                                            = [];
        $settingTypes[__('voyager::settings.group_general')] = [];
        $settings[__('voyager::settings.group_general')]     = [];
        foreach ($types as $d) {
            $s = $dataTypeSettings->where('data_type_setting_type_id', $d->id)->first();
            if ($d->group == '' || $d->group == __('voyager::settings.group_general')) {
                $settingTypes[__('voyager::settings.group_general')][] = $d;
                $settings[__('voyager::settings.group_general')][]     = $s;
            } else {
                $settingTypes[$d->group][] = $d;
                $settings[$d->group][]     = $s;
            }
        }
        if (count($settingTypes[__('voyager::settings.group_general')]) == 0) {
            unset($settingTypes[__('voyager::settings.group_general')]);
        }
        if (count($settings[__('voyager::settings.group_general')]) == 0) {
            unset($settings[__('voyager::settings.group_general')]);
        }

        $groups_data = Voyager::model('DataTypeSetting')->whereDataTypeSlug($dataType->slug)->select('group')->distinct()->get();
        $groups      = [];
        foreach ($groups_data as $group) {
            if ($group->group != '') {
                $groups[] = $group->group;
            }
        }

        $active = (request()->session()->has('data_type_setting_tab')) ? request()->session()->get('data_type_setting_tab') : old('user_setting_tab', key($settings));

        return Voyager::view(
            'joy-voyager-data-type-settings::settings.index',
            compact('settingTypes', 'settings', 'groups', 'active', 'dataType')
        );
    }
}
