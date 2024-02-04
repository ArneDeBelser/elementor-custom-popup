// Listen for Elementor popup show event
jQuery(document).on('elementor/popup/show', (event, id, instance) => {
    console.log(instance);

    // This prevents the popup from being removed in edit mode.
    if (instance.isEdit === true) return;

    // Hide the popup modal with the specified ID
    jQuery('#elementor-popup-modal-' + id).hide();

    // Send an AJAX request to fetch popup timing triggers
    jQuery.ajax({
        url: "/wp-admin/admin-ajax.php",
        type: "POST",

        // Data to be sent in the AJAX request
        data: {
            'action': 'fetch_popup_timing_triggers',
            'postid': id
        },

        // Callback function when the AJAX request is successful
        success(response) {
            // Log the response to the console for debugging
            console.log(response);

            // Check if the current language is in the active languages of the popup timing
            if ('active_languages' in response.meta.timing && response.meta.timing.active_languages.includes(response.current_lang)) {
                // Show the popup modal with the specified ID
                jQuery('#elementor-popup-modal-' + id).show();
            }
        }
    });
});
