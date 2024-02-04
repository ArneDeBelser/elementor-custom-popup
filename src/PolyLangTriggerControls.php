<?php

namespace Debelserarne\ElementorCustomPopup;

use Elementor\Controls_Manager;

class PolyLangTriggerControls
{
    public function __construct()
    {
        add_action('elementor/element/popup_timing/timing/after_section_end', [$this, 'addControls'], 10, 2);
    }

    public function addControls($element, $args)
    {
        // Make sure we are in edit mode, Elementor is activated, and Polylang is activated
        if (!\Elementor\Plugin::$instance->editor->is_edit_mode() || !is_plugin_active('elementor/elementor.php') || !function_exists('pll_languages_list')) {
            return;
        }

        // Tell Elementor where to start the injection
        $element->start_injection([
            'at' => 'after',
            'of' => 'browsers',
        ]);

        // Add heading
        $element->add_control('polylang_heading', [
            'type' => Controls_Manager::HEADING,
            'label' => esc_html__('Show in languages', 'elementor-pro'),
        ]);

        // Retrieve default languages
        $default_languages = pll_languages_list();
        // Get the current popup display settings
        $popup_display_settings = end(get_post_meta(get_the_ID(), '_elementor_popup_display_settings'));
        // Create empty array to store chosen languages
        $chosen_languages = [];

        // Check if there are timing settings for the popup
        if (
            $popup_display_settings['timing'] !== null
        ) {
            !array_key_exists('active_languages', $popup_display_settings['timing']) ? $chosen_languages = $popup_display_settings['timing']['active_languages'] : null;
        }

        // If chosen languages are empty, use default languages
        empty($chosenLanguages) ? $chosen_languages = $default_languages : null;

        $languageOptions = [];
        foreach ($default_languages as $key => $lang) {
            $languageOptions[$lang] = $lang;
        }

        // Add control for selecting active languages
        $element->add_control(
            'active_languages',
            [
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => array_values($chosen_languages),
                'options' => $languageOptions,
            ]
        );

        // Add control for Polylang switcher
        $element->add_control(
            'polylang',
            [
                'type' => Controls_Manager::SWITCHER,
                'classes' => 'elementor-popup__display-settings__group-toggle',
                'frontend_available' => true,
            ]
        );

        // Tell Elementor where to end the injection
        $element->end_injection();
    }
}
