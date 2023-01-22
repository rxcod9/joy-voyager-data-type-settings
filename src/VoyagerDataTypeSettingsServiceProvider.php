<?php

declare(strict_types=1);

namespace Joy\VoyagerDataTypeSettings;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Joy\VoyagerDataTypeSettings\Console\Commands\DataTypeSettings;
use Joy\VoyagerDataTypeSettings\Models\DataTypeSetting;
use Joy\VoyagerDataTypeSettings\Policies\DataTypeSettingPolicy;
use TCG\Voyager\Facades\Voyager;

/**
 * Class VoyagerDataTypeSettingsServiceProvider
 *
 * @category  Package
 * @package   JoyVoyagerDataTypeSettings
 * @author    Ramakant Gangwar <gangwar.ramakant@gmail.com>
 * @copyright 2021 Copyright (c) Ramakant Gangwar (https://github.com/rxcod9)
 * @license   http://github.com/rxcod9/joy-voyager-data-type-settings/blob/main/LICENSE New BSD License
 * @link      https://github.com/rxcod9/joy-voyager-data-type-settings
 */
class VoyagerDataTypeSettingsServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        DataTypeSetting::class => DataTypeSettingPolicy::class,
    ];

    /**
     * Boot
     *
     * @return void
     */
    public function boot()
    {
        Voyager::useModel('DataTypeSetting', DataTypeSetting::class);

        Voyager::addAction(\Joy\VoyagerDataTypeSettings\Actions\DataTypeSettingsAction::class);

        $this->registerPublishables();

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'joy-voyager-data-type-settings');

        $this->mapApiRoutes();

        $this->mapWebRoutes();

        if (config('joy-voyager-data-type-settings.database.autoload_migrations', true)) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'joy-voyager-data-type-settings');

        $this->loadAuth();
    }

    public function loadAuth()
    {
        // DataType Policies
        $this->registerPolicies();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(__DIR__ . '/../routes/web.php');
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix(config('joy-voyager-data-type-settings.route_prefix', 'api'))
            ->middleware('api')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/voyager-data-type-settings.php', 'joy-voyager-data-type-settings');

        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }
    }

    /**
     * Register publishables.
     *
     * @return void
     */
    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__ . '/../config/voyager-data-type-settings.php' => config_path('joy-voyager-data-type-settings.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/joy-voyager-data-type-settings'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/joy-voyager-data-type-settings'),
        ], 'translations');
    }

    protected function registerCommands(): void
    {
        $this->app->singleton('command.joy.voyager.data-type-settings', function () {
            return new DataTypeSettings();
        });

        $this->commands([
            'command.joy.voyager.data-type-settings',
        ]);
    }
}
