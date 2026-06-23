<?php

use JeffersonGoncalves\Mixpanel\Settings\MixpanelSettings;

it('can resolve MixpanelSettings from the container', function () {
    expect(app(MixpanelSettings::class))->toBeInstanceOf(MixpanelSettings::class);
});

it('belongs to the mixpanel group', function () {
    expect(MixpanelSettings::group())->toBe('mixpanel');
});

it('has correct default values', function () {
    $settings = app(MixpanelSettings::class);

    expect($settings->project_token)->toBeNull()
        ->and($settings->api_host)->toBeNull()
        ->and($settings->custom_lib_url)->toBeNull()
        ->and($settings->debug)->toBeFalse()
        ->and($settings->autocapture)->toBeTrue()
        ->and($settings->track_pageview)->toBe('true')
        ->and($settings->persistence)->toBe('cookie')
        ->and($settings->cookie_expiration)->toBe(365)
        ->and($settings->property_blacklist)->toBeNull()
        ->and($settings->record_sessions_percent)->toBe(0);
});

it('omits api_host from config when null', function () {
    $config = app(MixpanelSettings::class)->toJsConfig();

    expect($config)->not->toHaveKey('api_host');
});

it('includes api_host in config when set', function () {
    $settings = app(MixpanelSettings::class);
    $settings->api_host = 'https://api-eu.mixpanel.com';
    $settings->save();

    $config = $settings->toJsConfig();

    expect($config)->toHaveKey('api_host')
        ->and($config['api_host'])->toBe('https://api-eu.mixpanel.com');
});

it('coerces track_pageview "true" to a boolean', function () {
    $settings = app(MixpanelSettings::class);
    $settings->track_pageview = 'true';
    $settings->save();

    expect($settings->toJsConfig()['track_pageview'])->toBeTrue();
});

it('coerces track_pageview "false" to a boolean', function () {
    $settings = app(MixpanelSettings::class);
    $settings->track_pageview = 'false';
    $settings->save();

    expect($settings->toJsConfig()['track_pageview'])->toBeFalse();
});

it('keeps track_pageview string values that are not true/false', function () {
    $settings = app(MixpanelSettings::class);
    $settings->track_pageview = 'full-url';
    $settings->save();

    expect($settings->toJsConfig()['track_pageview'])->toBe('full-url');
});

it('omits property_blacklist from config when null', function () {
    $config = app(MixpanelSettings::class)->toJsConfig();

    expect($config)->not->toHaveKey('property_blacklist');
});

it('splits and trims property_blacklist into an array', function () {
    $settings = app(MixpanelSettings::class);
    $settings->property_blacklist = '$current_url, $initial_referrer ,$referrer';
    $settings->save();

    expect($settings->toJsConfig()['property_blacklist'])
        ->toBe(['$current_url', '$initial_referrer', '$referrer']);
});

it('clamps record_sessions_percent above 100 to 100', function () {
    $settings = app(MixpanelSettings::class);
    $settings->record_sessions_percent = 150;
    $settings->save();

    expect($settings->toJsConfig()['record_sessions_percent'])->toBe(100);
});

it('clamps negative record_sessions_percent to 0', function () {
    $settings = app(MixpanelSettings::class);
    $settings->record_sessions_percent = -10;
    $settings->save();

    expect($settings->toJsConfig()['record_sessions_percent'])->toBe(0);
});

it('does not render the script when project_token is empty', function () {
    $view = view('mixpanel::script')->render();

    expect($view)->not->toContain('mixpanel.init');
});

it('renders the script when project_token is set', function () {
    $settings = app(MixpanelSettings::class);
    $settings->project_token = 'TESTTOKEN123';
    $settings->save();

    $view = view('mixpanel::script')->render();

    expect($view)
        ->toContain('mixpanel.init')
        ->toContain('TESTTOKEN123');
});

it('escapes a malicious project_token in the rendered script', function () {
    $settings = app(MixpanelSettings::class);
    $settings->project_token = '</script><script>alert(1)</script>';
    $settings->save();

    $view = view('mixpanel::script')->render();

    expect($view)->not->toContain('<script>alert(1)</script>');
});
