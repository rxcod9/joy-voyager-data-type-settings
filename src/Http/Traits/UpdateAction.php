<?php

namespace Joy\VoyagerDataTypeSettings\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

trait UpdateAction
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

    public function update($id, Request $request)
    {
        // Check permission
        $this->authorize(
            'edit',
            Voyager::model('DataTypeSetting'),
        );

        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->whereSlug($slug)->firstOrFail();

        $settings = Voyager::model('DataTypeSetting')->whereDataTypeSlug($dataType->slug)->get();

        foreach ($settings as $setting) {
            $content = $this->getContentBasedOnType($request, 'data_type_settings', (object) [
                'type'  => $setting->type,
                'field' => str_replace('.', '_', $setting->key),
                'group' => $setting->group,
            ], $setting->details);

            if ($setting->type == 'image' && $content == null) {
                continue;
            }

            if ($setting->type == 'file' && $content == null) {
                continue;
            }

            $key = preg_replace('/^' . Str::slug($setting->group) . './i', '', $setting->key);

            $setting->group = $request->input(str_replace('.', '_', $setting->key) . '_group');
            $setting->key   = implode('.', [Str::slug($setting->group), $key]);
            $setting->value = $content;
            $setting->data_type_slug = $dataType->slug;
            $setting->save();
        }

        request()->flashOnly('data_type_setting_tab');

        return back()->with([
            'message'    => __('voyager::settings.successfully_saved'),
            'alert-type' => 'success',
        ]);
    }
}
