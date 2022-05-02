<?php

namespace Joy\VoyagerDataTypeSettings\Actions;

use Illuminate\Http\Request;
use TCG\Voyager\Actions\AbstractAction;
use TCG\Voyager\Facades\Voyager;

class DataTypeSettingsAction extends AbstractAction
{
    public function getTitle()
    {
        return __('joy-voyager-data-type-settings::generic.data_type_settings_btn');
    }

    public function getIcon()
    {
        return 'voyager-settings';
    }

    public function getPolicy()
    {
        return 'browse';
    }

    public function getAttributes()
    {
        return [
            'id'     => 'data_type_settings_btn',
            'class'  => 'btn btn-sm btn-primary',
            'target' => '_blank',
        ];
    }

    public function getDefaultRoute()
    {
        return route('voyager.' . $this->dataType->slug . '.data-type-settings.index');
    }

    public function shouldActionDisplayOnDataType()
    {
        return config('joy-voyager-data-type-settings.enabled', true) !== false
            && isInPatterns(
                $this->dataType->slug,
                config('joy-voyager-data-type-settings.allowed_slugs', ['*'])
            )
            && !isInPatterns(
                $this->dataType->slug,
                config('joy-voyager-data-type-settings.not_allowed_slugs', [])
            );
    }

    protected function getSlug(Request $request)
    {
        if (isset($this->slug)) {
            $slug = $this->slug;
        } else {
            $slug = explode('.', $request->route()->getName())[1];
        }

        return $slug;
    }

    public function massAction($ids, $comingFrom)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $this->getSlug(request());

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        // Gate::authorize('edit', app($dataType->model_name));

        return redirect()->route('voyager.' . $dataType->slug . '.data-type-settings.index');
    }
}
