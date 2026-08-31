<?php
/**
 * Plugin Name: HAPPY Staging Mail Guard
 * Description: Blocks outbound email until the staging form test is explicitly enabled.
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

add_filter('pre_wp_mail', function ($return, $atts) {
    if (defined('HAPPY_ALLOW_STAGING_MAIL') && HAPPY_ALLOW_STAGING_MAIL) {
        return $return;
    }

    if (function_exists('error_log')) {
        $recipients = isset($atts['to']) ? (array) $atts['to'] : array();
        error_log('[HAPPY staging] Blocked outbound email. Recipient count: ' . count($recipients));
    }

    return true;
}, PHP_INT_MAX, 2);
