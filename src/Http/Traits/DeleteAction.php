<?php

namespace Joy\VoyagerDataTypeSettings\Http\Traits;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

trait DeleteAction
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

    public function delete($id, Request $request)
    {
        // Check permission
        $this->authorize(
            'delete',
            Voyager::model('DataTypeSetting'),
        );

        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->whereSlug($slug)->firstOrFail();

        $setting = Voyager::model('DataTypeSetting')->whereDataTypeSlug($dataType->slug)->whereId((int) $id)->firstOrFail();

        Voyager::model('DataTypeSetting')->whereDataTypeSlug($dataType->slug)->destroy($id);

        request()->session()->flash('data_type_setting_tab', $setting->group);

        return back()->with([
            'message'    => __('voyager::settings.successfully_deleted'),
            'alert-type' => 'success',
        ]);
    }
}
