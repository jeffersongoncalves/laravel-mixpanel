# Changelog

All notable changes to this project will be documented in this file.

## v1.0.2 - 2026-02-24

### What's Changed

- Add Laravel 13.x support in composer.json
- Add orchestra/testbench ^11.0 for Laravel 13 testing

## v1.0.1 - 2026-02-22

### Bug Fix

- **Fix Blade parse error**: Resolved `syntax error, unexpected token "endif"` that occurred when rendering the Mixpanel script view in Filament/Livewire layouts
- **Extract config logic to `MixpanelSettings::toJsConfig()`**: Moved JavaScript config array construction from Blade `@php` block to a dedicated method on `MixpanelSettings`, improving code organization and testability
- **Fix `@php` directive syntax**: Changed from inline `@php(expression)` to block `@php...@endphp` to prevent Blade compilation issues

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
