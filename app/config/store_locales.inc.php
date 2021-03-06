<?php

use Cache\Cache;

// Locales working on Firefox for iOS (from stores_l10n app)
$cache_id = 'ios_locales';
if (! $ios_locales = Cache::getKey($cache_id, 60 * 60)) {
    $ios_locales = $json_object
        ->setURI(STORES_L10N . 'fx_ios/supportedlocales/release')
        ->fetchContent();
    $ios_locales = array_intersect($ios_locales, $mozilla);
    Cache::setKey($cache_id, $ios_locales);
}

// Locales working on Focus for iOS (from stores_l10n app)
$cache_id = 'focus_ios_locales';
if (! $focus_ios_locales = Cache::getKey($cache_id, 60 * 60)) {
    $focus_ios_locales = $json_object
        ->setURI(STORES_L10N . 'focus_ios/supportedlocales/release')
        ->fetchContent();
    $focus_ios_locales = array_intersect($focus_ios_locales, $mozilla);
    Cache::setKey($cache_id, $focus_ios_locales);
}

// Locales supported by Apple App Store (from stores_l10n app)
$cache_id = 'apple_store_locales';
if (! $apple_store_locales = Cache::getKey($cache_id, 60 * 60 * 24)) {
    $apple_store_locales = $json_object
        ->setURI(STORES_L10N . 'apple/localesmapping/?reverse')
        ->fetchContent();
    Cache::setKey($cache_id, array_keys($apple_store_locales));
}

// Locales that we do support and that Apple Store supports too
$fx_ios_store = array_intersect($ios_locales, $apple_store_locales);
$focus_ios_store = array_intersect($focus_ios_locales, $apple_store_locales);
$apple_store = array_unique(array_merge($fx_ios_store, $focus_ios_store));

// Locales working on Focus for Android (from stores_l10n app)
$cache_id = 'focus_android_locales';
if (! $focus_android_locales = Cache::getKey($cache_id, 60 * 60)) {
    $focus_android_locales = $json_object
        ->setURI(STORES_L10N . 'focus_android/supportedlocales/release')
        ->fetchContent();
    $focus_android_locales = array_intersect($focus_android_locales, $mozilla);
    Cache::setKey($cache_id, $focus_android_locales);
}

// Locales working on Firefox for Android central(from stores_l10n app)
$cache_id = 'fx_android_locales';
if (! $fx_android_locales = Cache::getKey($cache_id, 60 * 60)) {
    $fx_android_locales = $json_object
        ->setURI(STORES_L10N . 'fx_android/supportedlocales/central')
        ->fetchContent();
    $fx_android_locales = array_intersect($fx_android_locales, $mozilla);
    Cache::setKey($cache_id, $fx_android_locales);
}

// Locales supported by Google Play Store (from stores_l10n app)
$cache_id = 'google_play_locales';
if (! $google_play_locales = Cache::getKey($cache_id, 60 * 60 * 24)) {
    $google_play_locales = $json_object
        ->setURI(STORES_L10N . 'google/localesmapping/?reverse')
        ->fetchContent();
    Cache::setKey($cache_id, array_keys($google_play_locales));
}

// Locales that we support and that Google Play supports too
$focus_android_store = array_intersect($focus_android_locales, $google_play_locales, $mozilla);
$fx_android_store = array_intersect($fx_android_locales, $google_play_locales, $mozilla);
$google_play = array_unique(array_merge($focus_android_store, $fx_android_store));
