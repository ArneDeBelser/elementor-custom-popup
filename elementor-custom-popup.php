<?php

use Debelserarne\ElementorCustomPopup\AjaxEndpoints;
use Debelserarne\ElementorCustomPopup\PolyLangTriggerControls;

/**
 * Plugin Name: Elementor Custom Popup
 * Description: Customizations for Elementor Popup with Polylang support.
 * Version: 1.0
 * Author: De Belser Arne
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include the Composer autoload file for autoloading classes
require 'vendor/autoload.php';

class ElementorCustomPopup
{
    public function __construct()
    {
        // Add an action hook to enqueue popup display script
        add_action('wp_footer', [$this, 'enqueuePopupDisplay']);

        // Instantiate AjaxEndpoints class to handle AJAX actions
        new AjaxEndpoints();

        // Instantiate PolyLangTriggerControls class for Elementor controls customization
        new PolyLangTriggerControls();
    }

    public function enqueuePopupDisplay()
    {
        // Enqueue the script only if it's not in the Elementor editor
        if (!\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            // Enqueue the 'popup-display.js' script with dependencies and version
            wp_enqueue_script('popup-display', plugin_dir_url(__FILE__) . 'assets/js/popup-display.js', ['jquery'], '1.0', true);
            wp_enqueue_script('replace-svg', plugin_dir_url(__FILE__) . 'assets/js/replace-svg.js', ['jquery'], '1.0', true);

            // Assuming your JS file is also in the plugin directory
            // Use the wp_localize_script function to pass the plugin directory path to your JS
            wp_localize_script('your-js-handle', 'pluginData', [
                'pluginDirectory' => plugin_dir_url(__FILE__),
            ]);
        }
    }
}

// Initialize the plugin
new ElementorCustomPopup();
