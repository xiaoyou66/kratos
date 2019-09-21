/*!
 ---
 name: Enlighter Settings Page
 description: ThemeCustomizer setup
 authors:
 - Andi Dittrich

 requires:
 - jQuery
 ...
 */
(function (themeData) {
    // fetch console object
    var c = window.console || {};

    // initialize
    jQuery(document).ready(function () {
        // show developer message
        if (c.info) {
            c.info('You like to look under the hood? Enlighter is OpenSource, you are welcome to contribute! https://github.com/EnlighterJS/Plugin.WordPress');
        }

        // initialize tooltipps
        // jQuery(document).tooltip();

        // hide update message
        // --------------------------------------------------------
        var msg = jQuery('#setting-error-settings_updated');
        if (msg) {
            msg.delay(1500).fadeOut(500);
        }

        // Tabs/Sections
        // --------------------------------------------------------
        // try to restore last tab
        var lastActiveTab = jQuery.cookie('enlighter-tab');

        // container actions
        var currentTab = (lastActiveTab ? jQuery("#EnlighterTabNav a[data-tab='" + lastActiveTab + "']") : jQuery('#EnlighterTabNav a:first-child'));
        jQuery('#EnlighterTabNav a').each(function () {
            // get current element
            var el = jQuery(this);

            // hide content container
            jQuery('#' + el.attr('data-tab')).hide();

            // click event
            el.click(function () {
                // remove highlight
                currentTab.removeClass('nav-tab-active');

                // hide container
                jQuery('#' + currentTab.attr('data-tab')).hide();

                // store current active tab
                currentTab = el;
                currentTab.addClass('nav-tab-active');

                // show container
                jQuery('#' + currentTab.attr('data-tab')).show();

                // store current tab as cookie - 1 day lifetime
                jQuery.cookie('enlighter-tab', currentTab.attr('data-tab'), {expires: 1});
            });
        });

        // show first container
        currentTab.click();

        // show navbar
        jQuery('#EnlighterTabNav').show();

        // Shortcode Filters
        // --------------------------------------------------------
        jQuery('#enlighter-shortcodeMode').change(function(){
            // get current element
            var el = jQuery(this);

            // get container
            var container = jQuery('#EnlighterShortcodeFilters');

            if (el.val() == 'modern'){
                container.show();
            }else{
                container.hide();
            }
        }).change();

        // Live Preview Mode
        // --------------------------------------------------------
        var previewWindow = null;
        jQuery('#enlighter_themePreviewMode').click(function () {
            // window active ?
            if (previewWindow && !previewWindow.closed) {
                previewWindow.focus();

                // create new window
            } else {
                // get url
                var u = jQuery(this).attr('data-url');

                // create a new window
                previewWindow = window.open(u, null, "width=800, height=800");
            }
        });

        // live preview update
        window.setInterval(function () {
            // window available and loaded?
            if (!previewWindow || previewWindow.closed || !previewWindow.window.ThemePreview) {
                return;
            }

            // fetch data
            var rawData = jQuery('#EnlighterSettings input, #EnlighterSettings select').serializeArray();
            var data = {};

            // convert to object
            jQuery.each(rawData, function (i, el) {
                // enlighetr settings ?
                var n = (el.name.substring(0, 10) == 'enlighter-') ? el.name.substring(10) : el.name;

                data[n] = el.value;
            });

            // push settings to preview engine
            previewWindow.window.ThemePreview.update(data);

        }, 800);

        // Color Selection
        // --------------------------------------------------------
        // colorpicker
        jQuery('.EnlighterJSColorChooser').ColorPicker({
            onSubmit: function (hsb, hex, rgb, el) {
                jQuery(el).val('#' + hex);
                jQuery(el).css('background-color', '#' + hex);
                jQuery(el).ColorPickerHide();

                // foreground color based on background (best contrast)
                if (hsb.b > 50) {
                    jQuery(el).css('color', '#000000');
                } else {
                    jQuery(el).css('color', '#f0f0f0');
                }
            },
            onBeforeShow: function () {
                jQuery(this).ColorPickerSetColor(this.value);
            }
        });
        // initialize colors
        jQuery('.EnlighterJSColorChooser').each(function () {
            // get element color value
            var color = jQuery(this).val();

            // color available ?
            if (color.length > 0) {
                jQuery(this).css('background-color', color);

                // get color as HSV
                var hsv = jQuery.Color(color);

                // foreground color based on background (best contrast)
                if (hsv.lightness() > 0.5) {
                    jQuery(this).css('color', '#000000');
                } else {
                    jQuery(this).css('color', '#f0f0f0');
                }
            }
        });

        // advanced color settings
        jQuery('#enlighter-defaultTheme').change(function () {
            var value = jQuery('#enlighter-defaultTheme').val();

            // display section only in custom mode !
            if (value == 'wpcustom') {
                jQuery('#EnlighterTabhandleThemeCustomizer').show();
            } else {
                jQuery('#EnlighterTabhandleThemeCustomizer').hide();
            }
        }).change();

        /**
         * Editor Customization
         */
        jQuery('#enlighter_editorstylesDefault').click(function () {
            // set font styles
            jQuery('#enlighter-editorFontFamily').val('"Source Code Pro", "Liberation Mono", "Courier New", Courier, monospace');
            jQuery('#enlighter-editorFontSize').val('0.7em');
            jQuery('#enlighter-editorLineHeight').val('1.4em');
            setElementColor('#enlighter-editorFontColor', '#565b60');
            setElementColor('#enlighter-editorBackgroundColor', '#f7f7f7');
        });

        /**
         * THEME CUSTOMIZER
         */

        jQuery('#enlighter_loadBasicTheme').click(function () {
            // get selected theme
            var theme = jQuery('#enlighter-customThemeBase').val().trim().toLowerCase();

            // theme data avialable ?
            if (!themeData[theme]) {
                return;
            }

            // set font styles
            jQuery('#enlighter-customFontFamily').val(themeData[theme].basestyle['font-family']);
            jQuery('#enlighter-customFontSize').val(themeData[theme].basestyle['font-size']);
            jQuery('#enlighter-customLineHeight').val(themeData[theme].linestyle['line-height']);
            setElementColor('#enlighter-customFontColor', themeData[theme].basestyle['color']);

            // set line-number styles
            jQuery('#enlighter-customLinenumberFontFamily').val(themeData[theme].linestyle['font-family']);
            jQuery('#enlighter-customLinenumberFontSize').val(themeData[theme].linestyle['font-size']);
            setElementColor('#enlighter-customLinenumberFontColor', themeData[theme].linestyle['color']);

            // set raw font styles
            jQuery('#enlighter-customRawFontFamily').val(themeData[theme].rawstyle['font-family']);
            jQuery('#enlighter-customRawFontSize').val(themeData[theme].rawstyle['font-size']);
            jQuery('#enlighter-customRawLineHeight').val(themeData[theme].rawstyle['line-height']);
            setElementColor('#enlighter-customRawFontColor', themeData[theme].rawstyle['color']);
            setElementColor('#enlighter-customRawBackgroundColor', themeData[theme].rawstyle['background-color']);

            // set special styles
            jQuery('#enlighter-customLineHighlightColor').val(themeData[theme].special.highlightColor);
            setElementColor('#enlighter-customLineHighlightColor', themeData[theme].special.highlightColor);
            jQuery('#enlighter-customLineHoverColor').val(themeData[theme].special.hoverColor);
            setElementColor('#enlighter-customLineHoverColor', themeData[theme].special.hoverColor);

            // set token styles
            // format: foreground color, background color, text-decoration, font-weight, font-style
            jQuery.each(themeData[theme].tokens, function (key, value) {
                // foreground color
                setElementColor('#enlighter-custom-color-' + key, value[0]);

                // background color
                setElementColor('#enlighter-custom-bgcolor-' + key, value[1]);

                // text decoration
                jQuery('#enlighter-custom-decoration-' + key).val((value[2] ? value[2] : 'normal'));

                // change dropdown selection if value is set
                if (value[3] && value[4]) {
                    jQuery('#enlighter-custom-fontstyle-' + key).val('bolditalic');
                } else if (value[3]) {
                    jQuery('#enlighter-custom-fontstyle-' + key).val('bold');
                } else if (value[4]) {
                    jQuery('#enlighter-custom-fontstyle-' + key).val('italic');
                } else {
                    jQuery('#enlighter-custom-fontstyle-' + key).val('normal');
                }
            });
        });
    });

    // set element color
    var setElementColor = (function (id, value) {
        // value available ?
        if (value) {
            jQuery(id).val(value);
            jQuery(id).css('background-color', value);
        } else {
            jQuery(id).val('');
            jQuery(id).css('background-color', 'transparent');
        }
    });
})(Enlighter_ThemeStyles);
