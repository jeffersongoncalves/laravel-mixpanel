<?php

namespace JeffersonGoncalves\Mixpanel\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use JeffersonGoncalves\Mixpanel\MixpanelServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;
use Spatie\LaravelSettings\Migrations\SettingsMigrator;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
        $this->seedSettings();
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelSettingsServiceProvider::class,
            MixpanelServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUpDatabase(): void
    {
        Schema::create('settings', function (Blueprint $table): void {
            $table->id();
            $table->string('group');
            $table->string('name');
            $table->boolean('locked')->default(false);
            $table->json('payload');
            $table->timestamps();
            $table->unique(['group', 'name']);
        });
    }

    protected function seedSettings(): void
    {
        $migrator = app(SettingsMigrator::class);

        $migrator->add('mixpanel.project_token', null);
        $migrator->add('mixpanel.api_host', null);
        $migrator->add('mixpanel.custom_lib_url', null);
        $migrator->add('mixpanel.debug', false);
        $migrator->add('mixpanel.autocapture', true);
        $migrator->add('mixpanel.track_pageview', 'true');
        $migrator->add('mixpanel.persistence', 'cookie');
        $migrator->add('mixpanel.cookie_expiration', 365);
        $migrator->add('mixpanel.secure_cookie', false);
        $migrator->add('mixpanel.cross_subdomain_cookie', true);
        $migrator->add('mixpanel.ip', true);
        $migrator->add('mixpanel.property_blacklist', null);
        $migrator->add('mixpanel.opt_out_tracking_by_default', false);
        $migrator->add('mixpanel.stop_utm_persistence', false);
        $migrator->add('mixpanel.record_sessions_percent', 0);
        $migrator->add('mixpanel.record_heatmap_data', false);
    }
}
