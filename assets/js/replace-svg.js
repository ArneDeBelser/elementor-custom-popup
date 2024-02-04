jQuery(document).ready(function ($) {
    // Function to replace image source
    function replaceImageSource() {
        var targetImage = $('img[src*="timing/polylang.svg"]');
        var svgPath = pluginData.pluginDirectory + 'svg/lang.svg';

        console.log(targetImage);
        console.log(svgPath);

        // Replace the source attribute with the path to your SVG file
        targetImage.attr('src', svgPath);
    }

    // Listen for Elementor popup show event
    jQuery(document).on('click', '#elementor-editor-wrapper-v2', function () {
        console.log($('.dialog-widget').css('display') == 'none');
        // Check if an element with class "dialog-widget" has display: none
        if ($('.dialog-widget').css('display') == 'none') {
            replaceImageSource();
        }
    });
});
