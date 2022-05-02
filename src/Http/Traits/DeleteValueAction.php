<?php

namespace Joy\VoyagerDataTypeSettings\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Facades\Voyager;

trait DeleteValueAction
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

    public function delete_value($id, Request $request)
    {
        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->whereSlug($slug)->firstOrFail();
        $setting = Voyager::model('DataTypeSetting')->whereDataTypeSlug($dataType->slug)->whereId((int) $id)->firstOrFail();

        // Check permission
        $this->authorize(
            'delete',
            $setting,
        );

        if (isset($setting->id)) {
            // If the type is an image... Then delete it
            if ($setting->type == 'image') {
                if (Storage::disk(config('voyager.storage.disk'))->exists($setting->value)) {
                    Storage::disk(config('voyager.storage.disk'))->delete($setting->value);
                }
            }
            $setting->value = '';
            $setting->save();
        }

        request()->session()->flash('data_type_setting_tab', $setting->group);

        return back()->with([
            'message'    => __('voyager::settings.successfully_removed', ['name' => $setting->display_name]),
            'alert-type' => 'success',
        ]);
    }
}
