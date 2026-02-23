<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('mixpanel.project_token', null);
        $this->migrator->add('mixpanel.api_host', null);
        $this->migrator->add('mixpanel.custom_lib_url', null);
        $this->migrator->add('mixpanel.debug', false);
        $this->migrator->add('mixpanel.autocapture', true);
        $this->migrator->add('mixpanel.track_pageview', 'true');
        $this->migrator->add('mixpanel.persistence', 'cookie');
        $this->migrator->add('mixpanel.cookie_expiration', 365);
        $this->migrator->add('mixpanel.secure_cookie', false);
        $this->migrator->add('mixpanel.cross_subdomain_cookie', true);
        $this->migrator->add('mixpanel.ip', true);
        $this->migrator->add('mixpanel.property_blacklist', null);
        $this->migrator->add('mixpanel.opt_out_tracking_by_default', false);
        $this->migrator->add('mixpanel.stop_utm_persistence', false);
        $this->migrator->add('mixpanel.record_sessions_percent', 0);
        $this->migrator->add('mixpanel.record_heatmap_data', false);
    }
};
