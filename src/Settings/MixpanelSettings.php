<?php

namespace JeffersonGoncalves\Mixpanel\Settings;

use Spatie\LaravelSettings\Settings;

class MixpanelSettings extends Settings
{
    public ?string $project_token;

    public ?string $api_host;

    public ?string $custom_lib_url;

    public bool $debug;

    public bool $autocapture;

    public string $track_pageview;

    public string $persistence;

    public int $cookie_expiration;

    public bool $secure_cookie;

    public bool $cross_subdomain_cookie;

    public bool $ip;

    public ?string $property_blacklist;

    public bool $opt_out_tracking_by_default;

    public bool $stop_utm_persistence;

    public int $record_sessions_percent;

    public bool $record_heatmap_data;

    public static function group(): string
    {
        return 'mixpanel';
    }
}
