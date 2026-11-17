<?php

use JeffersonGoncalves\Mixpanel\Settings\MixpanelSettings;

// Stand-in for the helper of jeffersongoncalves/laravel-cookie-consent, which this package
// calls only when it is installed.
if (! function_exists('cookie_consent_script_attributes')) {
    function cookie_consent_script_attributes(string $id): string
    {
        return $GLOBALS['cookie_consent_attributes'][$id] ?? '';
    }
}

afterEach(fn () => $GLOBALS['cookie_consent_attributes'] = []);

it('holds every script while laravel-cookie-consent blocks its category', function () {
    $GLOBALS['cookie_consent_attributes']['mixpanel'] = ' type="text/plain" data-category="analytics"';
    $settings = app(MixpanelSettings::class);
    $settings->project_token = 'TESTTOKEN123';
    $settings->save();
    $html = (string) view('mixpanel::script')->render();

    preg_match_all('/<script\b[^>]*>/', $html, $tags);

    expect($tags[0])->not->toBeEmpty()
        ->each(fn ($tag) => $tag->toContain('type="text/plain" data-category="analytics"')->not->toContain('text/javascript'))
        ->and($html)->not->toContain('<noscript');
});

it('renders its scripts as before when nothing is held', function () {
    $settings = app(MixpanelSettings::class);
    $settings->project_token = 'TESTTOKEN123';
    $settings->save();
    $html = (string) view('mixpanel::script')->render();

    expect($html)->toContain('<script')->not->toContain('text/plain');
});
