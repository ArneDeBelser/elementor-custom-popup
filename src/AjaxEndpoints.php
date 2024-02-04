<?php

namespace Debelserarne\ElementorCustomPopup;

class AjaxEndpoints
{
    public function __construct()
    {
        // Add AJAX action for non-logged in users to fetch popup timing triggers
        add_action('wp_ajax_nopriv_fetch_popup_timing_triggers', [$this, 'fetchPopupTimingTriggers']);
        // Add AJAX action for logged-in users to fetch popup timing triggers
        add_action('wp_ajax_fetch_popup_timing_triggers', [$this, 'fetchPopupTimingTriggers']);
    }

    public function fetchPopupTimingTriggers()
    {
        // Get the meta data for the specified post ID
        $meta = get_post_meta($_POST['postid'], '_elementor_popup_display_settings', false);

        // Send JSON response with current language and the last element of the meta data array
        wp_send_json([
            'current_lang' => pll_current_language(),
            'meta' => end($meta)
        ]);

        // Terminate execution and return a JSON response
        wp_die();
    }
}
