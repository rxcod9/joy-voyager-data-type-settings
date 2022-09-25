<?php

namespace Joy\VoyagerDataTypeSettings\Http\Traits;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

trait MoveDownAction
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

    public function move_down($id, Request $request)
    {
        // Check permission
        $this->authorize(
            'edit',
            Voyager::model('DataTypeSetting'),
        );

        $slug     = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->whereSlug($slug)->firstOrFail();

        $setting = Voyager::model('DataTypeSetting')->whereDataTypeSlug($dataType->slug)->whereId((int) $id)->firstOrFail();

        // Check permission
        $this->authorize(
            'browse',
            $setting,
        );

        $swapOrder = $setting->order;

        $previousSetting = Voyager::model('DataTypeSetting')
            ->whereDataTypeSlug($dataType->slug)
            ->where('order', '>', $swapOrder)
            ->where('group', $setting->group)
            ->orderBy('order', 'ASC')->first();
        $data = [
            'message'    => __('voyager::settings.already_at_bottom'),
            'alert-type' => 'error',
        ];

        if (isset($previousSetting->order)) {
            $setting->order = $previousSetting->order;
            $setting->save();
            $previousSetting->order = $swapOrder;
            $previousSetting->save();

            $data = [
                'message'    => __('voyager::settings.moved_order_down', ['name' => $setting->display_name]),
                'alert-type' => 'success',
            ];
        }

        request()->session()->flash('data_type_setting_tab', $setting->group);

        return back()->with($data);
    }
}
