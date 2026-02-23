# Changelog

All notable changes to this project will be documented in this file.

## v1.0.0 - 2026-02-22

### Initial Release

- Mixpanel JavaScript SDK integration for Laravel Blade templates
- Database-driven configuration via `spatie/laravel-settings`
- Full support for Mixpanel JS SDK initialization options
- CDN snippet with proxy/custom library URL support
- Autocapture, session recording, and heatmap configuration
- Data residency support (US, EU, India) via `api_host`
- Privacy controls: opt-out by default, property blacklist, cookie settings
- Blade view includable via `@include('mixpanel::script')`
