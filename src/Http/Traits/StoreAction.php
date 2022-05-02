<?php

namespace Joy\VoyagerDataTypeSettings\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

trait StoreAction
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

    public function store(Request $request)
    {
        // Check permission
        $this->authorize(
            'add',
            Voyager::model('DataTypeSetting'),
        );

        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->whereSlug($slug)->firstOrFail();

        $key       = implode('.', [Str::slug($request->input('group')), $request->input('key')]);
        $key_check = Voyager::model('DataTypeSetting')->whereDataTypeSlug($dataType->slug)->where('key', $key)->get()->count();

        if ($key_check > 0) {
            return back()->with([
                'message'    => __('voyager::settings.key_already_exists', ['key' => $key]),
                'alert-type' => 'error',
            ]);
        }

        $lastSetting = Voyager::model('DataTypeSetting')->whereDataTypeSlug($dataType->slug)->orderBy('order', 'DESC')->first();

        if (is_null($lastSetting)) {
            $order = 0;
        } else {
            $order = intval($lastSetting->order) + 1;
        }

        $request->merge(['data_type_slug' => $dataType->slug]);
        $request->merge(['order' => $order]);
        $request->merge(['value' => null]);
        $request->merge(['key' => $key]);

        Voyager::model('DataTypeSetting')->create($request->except(['data_type_setting_tab']));

        request()->flashOnly('data_type_setting_tab');

        return back()->with([
            'message'    => __('voyager::settings.successfully_created'),
            'alert-type' => 'success',
        ]);
    }
}
