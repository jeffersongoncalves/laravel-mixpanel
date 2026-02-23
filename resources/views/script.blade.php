@php($settings = app(\JeffersonGoncalves\Mixpanel\Settings\MixpanelSettings::class))

@if(!empty($settings->project_token))
@if($settings->custom_lib_url)
<script type="text/javascript">
    var MIXPANEL_CUSTOM_LIB_URL = "{{ $settings->custom_lib_url }}";
</script>
@endif
<script type="text/javascript">
    (function(f,b){if(!b.__SV){var e,g,i,h;window.mixpanel=b;b._i=[];b.init=function(e,f,c){function g(a,d){var b=d.split(".");2==b.length&&(a=a[b[0]],d=b[1]);a[d]=function(){a.push([d].concat(Array.prototype.slice.call(arguments,0)))}}var a=b;"undefined"!==typeof c?a=b[c]=[]:c="mixpanel";a.people=a.people||[];a.toString=function(a){var d="mixpanel";"mixpanel"!==c&&(d+="."+c);a||(d+=" (stub)");return d};a.people.toString=function(){return a.toString(1)+".people (stub)"};i="disable time_event track track_pageview track_links track_forms track_with_groups add_group set_group remove_group register register_once alias unregister identify name_tag set_config reset opt_in_tracking opt_out_tracking has_opted_in_tracking has_opted_out_tracking clear_opt_in_out_tracking start_batch_senders people.set people.set_once people.unset people.increment people.append people.union people.track_charge people.clear_charges people.delete_user people.remove".split(" ");for(h=0;h<i.length;h++)g(a,i[h]);var j="set set_once union unset remove delete".split(" ");a.get_group=function(){function b(c){d[c]=function(){call2_args=arguments;call2=[c].concat(Array.prototype.slice.call(call2_args,0));a.push([e,call2])}}for(var d={},e=["get_group"].concat(Array.prototype.slice.call(arguments,0)),c=0;c<j.length;c++)b(j[c]);return d};b._i.push([e,f,c])};b.__SV=1.2;e=f.createElement("script");e.type="text/javascript";e.async=!0;e.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:"===f.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\///)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";g=f.getElementsByTagName("script")[0];g.parentNode.insertBefore(e,g)}})(document,window.mixpanel||[]);
</script>
@php
    $config = [];

    if ($settings->api_host) {
        $config['api_host'] = $settings->api_host;
    }

    $config['debug'] = $settings->debug;
    $config['autocapture'] = $settings->autocapture;

    if (in_array($settings->track_pageview, ['true', 'false'], true)) {
        $config['track_pageview'] = $settings->track_pageview === 'true';
    } else {
        $config['track_pageview'] = $settings->track_pageview;
    }

    $config['persistence'] = $settings->persistence;
    $config['cookie_expiration'] = $settings->cookie_expiration;
    $config['secure_cookie'] = $settings->secure_cookie;
    $config['cross_subdomain_cookie'] = $settings->cross_subdomain_cookie;
    $config['ip'] = $settings->ip;

    if ($settings->property_blacklist) {
        $config['property_blacklist'] = array_map('trim', explode(',', $settings->property_blacklist));
    }

    $config['opt_out_tracking_by_default'] = $settings->opt_out_tracking_by_default;
    $config['stop_utm_persistence'] = $settings->stop_utm_persistence;
    $config['record_sessions_percent'] = $settings->record_sessions_percent;
    $config['record_heatmap_data'] = $settings->record_heatmap_data;
@endphp
<script type="text/javascript">
    mixpanel.init("{{ $settings->project_token }}", {!! json_encode($config, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!});
</script>
@endif
