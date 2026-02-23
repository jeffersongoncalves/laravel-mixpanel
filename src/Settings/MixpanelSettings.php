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

    public function toJsConfig(): array
    {
        $config = [];

        if ($this->api_host) {
            $config['api_host'] = $this->api_host;
        }

        $config['debug'] = $this->debug;
        $config['autocapture'] = $this->autocapture;

        if (in_array($this->track_pageview, ['true', 'false'], true)) {
            $config['track_pageview'] = $this->track_pageview === 'true';
        } else {
            $config['track_pageview'] = $this->track_pageview;
        }

        $config['persistence'] = $this->persistence;
        $config['cookie_expiration'] = $this->cookie_expiration;
        $config['secure_cookie'] = $this->secure_cookie;
        $config['cross_subdomain_cookie'] = $this->cross_subdomain_cookie;
        $config['ip'] = $this->ip;

        if ($this->property_blacklist) {
            $config['property_blacklist'] = array_map('trim', explode(',', $this->property_blacklist));
        }

        $config['opt_out_tracking_by_default'] = $this->opt_out_tracking_by_default;
        $config['stop_utm_persistence'] = $this->stop_utm_persistence;
        $config['record_sessions_percent'] = $this->record_sessions_percent;
        $config['record_heatmap_data'] = $this->record_heatmap_data;

        return $config;
    }
}
