<?php

use Illuminate\Support\Facades\Vite;
use JeffersonGoncalves\Mixpanel\Settings\MixpanelSettings;

it('stamps the CSP nonce on every script tag', function () {
    Vite::useCspNonce('test-nonce');
    $settings = app(MixpanelSettings::class);
    $settings->project_token = 'TESTTOKEN123';
    $settings->save();
    $html = (string) view('mixpanel::script')->render();

    preg_match_all('/<script\b[^>]*>/', $html, $tags);

    expect($tags[0])->not->toBeEmpty()->each->toContain('nonce="test-nonce"');
});

it('renders no nonce attribute when the app uses none', function () {
    $settings = app(MixpanelSettings::class);
    $settings->project_token = 'TESTTOKEN123';
    $settings->save();
    $html = (string) view('mixpanel::script')->render();

    expect($html)->toContain('<script')->not->toContain('nonce=');
});
