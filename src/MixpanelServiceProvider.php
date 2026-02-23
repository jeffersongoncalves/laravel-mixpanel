<?php

namespace JeffersonGoncalves\Mixpanel;

use Illuminate\Support\Facades\Config;
use JeffersonGoncalves\Mixpanel\Settings\MixpanelSettings;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MixpanelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-mixpanel')
            ->hasViews();
    }

    public function packageRegistered(): void
    {
        parent::packageRegistered();

        Config::set('settings.settings', array_merge(
            Config::get('settings.settings', []),
            [MixpanelSettings::class]
        ));
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        Config::set('settings.migrations_paths', array_merge(
            Config::get('settings.migrations_paths', []),
            [__DIR__.'/../database/settings']
        ));

        $this->publishes([
            __DIR__.'/../database/settings' => database_path('settings'),
        ], 'mixpanel-settings-migrations');
    }
}
