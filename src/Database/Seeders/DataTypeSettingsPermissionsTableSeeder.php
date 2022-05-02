<?php

namespace Joy\VoyagerDataTypeSettings\Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;

class DataTypeSettingsPermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        Permission::generateFor('data_type_settings');
    }
}
