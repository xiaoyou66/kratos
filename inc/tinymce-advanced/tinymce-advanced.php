<?php
/*
Plugin Name: TinyMCE Advanced
Plugin URI: http://www.laptoptips.ca/projects/tinymce-advanced/
Description: Enables advanced features and plugins in TinyMCE, the visual editor in WordPress.
Version: 5.2.1
Author: Andrew Ozz
Author URI: http://www.laptoptips.ca/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: tinymce-advanced


TinyMCE Advanced is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

TinyMCE Advanced is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with TinyMCE Advanced or WordPress. If not, see https://www.gnu.org/licenses/gpl-2.0.html.

Copyright (c) 2007-2019 Andrew Ozz. All rights reserved.
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists('Tinymce_Advanced') ) :

    class Tinymce_Advanced {

        private $required_wp_version = '5.2';
        private $plugin_version = 5210;

        private $user_settings;
        private $admin_settings;
        private $admin_options;
        private $editor_id;
        private $disabled_for_editor = false;

        private $plugins;
        private $options;
        private $toolbar_1;
        private $toolbar_2;
        private $toolbar_3;
        private $toolbar_4;
        private $used_buttons = array();
        private $all_buttons = array();
        private $buttons_filter = array();
        private $fontsize_formats = '8px 10px 12px 14px 16px 20px 24px 28px 32px 36px 48px 60px 72px 96px';
        private $required_menubar_plugins = array(
            'anchor',
            'code',
            'insertdatetime',
            'nonbreaking',
            'print',
            'searchreplace',
            'table',
            'visualblocks',
            'visualchars'
        );

        private function get_default_user_settings() {
            return array(
                'options'	=> 'menubar,advlist,menubar_block,merge_toolbars',
                'plugins'   => 'anchor,code,insertdatetime,nonbreaking,print,searchreplace,table,visualblocks,visualchars,advlist,wptadv',
                'toolbar_1' => 'formatselect,bold,italic,blockquote,bullist,numlist,alignleft,aligncenter,alignright,link,unlink,undo,redo',
                'toolbar_2' => 'fontselect,fontsizeselect,outdent,indent,pastetext,removeformat,charmap,wp_more,forecolor,table,wp_help',
                'toolbar_3' => '',
                'toolbar_4' => '',

                'toolbar_classic_block' => 'formatselect,bold,italic,blockquote,bullist,numlist,alignleft,aligncenter,alignright,link,forecolor,backcolor,table,wp_help',
                'toolbar_block' => 'core/image',
                'toolbar_block_side' => 'tadv/sup,tadv/sub,core/strikethrough,core/code,tadv/mark,tadv/removeformat',
                'panels_block' => 'tadv/color-panel,tadv/background-color-panel',
            );
        }

        private function get_default_admin_settings() {
            return array(
                'options' => 'classic_paragraph_block,table_resize_bars,table_grid,table_tab_navigation,table_advtab',
            );
        }

        private function get_all_plugins() {
            return array(
                'advlist',
                'anchor',
                'code',
                'contextmenu',
                'emoticons',
                'importcss',
                'insertdatetime',
                'link',
                'nonbreaking',
                'print',
                'searchreplace',
                'table',
                'visualblocks',
                'visualchars',
                'wptadv',
            );
        }

        private function get_all_user_options() {
            return array(
                'advlist',
                'advlink',
                'contextmenu',
                'menubar',
                'menubar_block',
                'fontsize_formats',
                'merge_toolbars',
            );
        }

        private function get_all_admin_options() {
            return array(
                'importcss',
                'no_autop',
                'hybrid_mode',
                'classic_paragraph_block',
                'replace_block_editor',
                'table_resize_bars',
                'table_default_attributes',
                'table_grid',
                'table_tab_navigation',
                'table_advtab',
            );
        }

        private function get_editor_locations() {
            return array(
                'edit_post_screen',
                'rest_of_wpadmin',
                'on_front_end',
            );
        }

        private function get_all_block_buttons() {
            $inline_img_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false">' .
                '<path d="M4 16h10c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v9c0 1.1.9 2 2 2zM4 5h10v9H4V5zm14 9v2h4v-2h-4zM2 20h20v-2H2v2zm6.4-8.8L7 9.4 5 12h8l-2.6-3.4-2 2.6z"></path>' .
                '</svg>';

            $block_buttons = array(
                //		'core/bold'   => array( 'name' => 'Bold', 'icon' => '<span class="dashicons dashicons-editor-bold"></span>' ),
                //		'core/italic' => array( 'name' => 'Italic', 'icon' => '<span class="dashicons dashicons-editor-italic"></span>' ),
                //		'core/link'   => array( 'name' => 'Insert/edit link', 'icon' => '<span class="dashicons dashicons-admin-links"></span>' ),
                'core/strikethrough' => array( 'name' => 'Strikethrough', 'icon' => '<span class="dashicons dashicons-editor-strikethrough"></span>' ),
                'core/code'   => array( 'name' => 'Code', 'icon' => '<span class="dashicons dashicons-editor-code"></span>' ),

                'core/image'  => array( 'name' => 'Inline Image', 'icon' => '<span class="dashicons">' . $inline_img_icon . '</span>' ),

                'tadv/mark'   => array( 'name' => 'Mark', 'icon' => '<span class="dashicons dashicons-editor-textcolor"></span>' ),
                'tadv/removeformat' => array( 'name' => 'Clear formatting', 'icon' => '<span class="dashicons dashicons-editor-removeformatting"></span>' ),
                'tadv/sup'    => array( 'name' => 'Superscript', 'icon' => '<span class="mce-ico mce-i-superscript"></span>' ),
                'tadv/sub'    => array( 'name' => 'Subscript', 'icon' => '<span class="mce-ico mce-i-subscript"></span>' ),
                'core/underline' => array( 'name' => 'Underline', 'icon' => '<span class="dashicons dashicons-editor-underline"></span>' ),
            );

            $this->all_block_buttons = $block_buttons;
            $this->block_buttons_filter = array_keys( $block_buttons );

            return $block_buttons;
        }

        private function get_all_block_panels() {
            return array(
                'tadv/color-panel',
                'tadv/background-color-panel',
            );
        }

        public function __construct() {
            register_activation_hook( __FILE__, array( $this, 'update_settings' ) );

            if ( is_admin() ) {
                add_action( 'admin_menu', array( $this, 'add_menu' ) );
                add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
                add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
                add_filter( 'plugin_action_links', array( $this, 'add_settings_link' ), 10, 2 );
                add_action( 'before_wp_tiny_mce', array( $this, 'show_version_warning' ) );

                add_action( 'admin_init', array( $this, 'import_export_settings_file' ) );
                add_action( 'plugins_loaded', array( $this, 'update_settings' ) );
            }

            add_filter( 'wp_editor_settings', array( $this, 'disable_for_editor' ), 10, 2 );

            add_filter( 'mce_buttons', array( $this, 'mce_buttons_1' ), 999, 2 );
            add_filter( 'mce_buttons_2', array( $this, 'mce_buttons_2' ), 999, 2 );
            add_filter( 'mce_buttons_3', array( $this, 'mce_buttons_3' ), 999, 2 );
            add_filter( 'mce_buttons_4', array( $this, 'mce_buttons_4' ), 999, 2 );

            add_filter( 'tiny_mce_before_init', array( $this, 'mce_options' ), 10, 2 );
            add_filter( 'mce_external_plugins', array( $this, 'mce_external_plugins' ), 999 );
            add_filter( 'tiny_mce_plugins', array( $this, 'tiny_mce_plugins' ), 999 );

            add_action( 'enqueue_block_editor_assets', array( $this, 'block_editor_assets' ), 20 );
            add_action( 'init', array( $this, 'block_editor_init' ) );
            add_filter( 'wp_insert_post_data', array( $this, 'filter_post_content' ), 1 );

            add_filter( 'excerpt_allowed_blocks', array( $this, 'excerpt_add_allowed_blocks' ) );
        }

        public function disable_for_editor( $settings, $editor_id ) {
            static $editor_style_added = false;

            if ( empty( $this->admin_settings ) ) {
                $this->load_settings();
            }

            $this->disabled_for_editor = false;
            $this->editor_id = $editor_id;

            if ( ! empty( $this->admin_settings['disabled_editors'] ) ) {
                $disabled_editors = explode( ',', $this->admin_settings['disabled_editors'] );
                $current_screen = isset( $GLOBALS['current_screen'] ) ? $GLOBALS['current_screen'] : new stdClass;

                if ( is_admin() ) {
                    if ( $editor_id === 'content' && ( $current_screen->id === 'post' || $current_screen->id === 'page' ) ) {
                        if ( in_array( 'edit_post_screen', $disabled_editors, true ) ) {
                            $this->disabled_for_editor = true;
                        }
                    } elseif ( in_array( 'rest_of_wpadmin', $disabled_editors, true ) ) {
                        $this->disabled_for_editor = true;
                    }
                } elseif ( in_array( 'on_front_end', $disabled_editors, true ) ) {
                    $this->disabled_for_editor = true;
                }
            }

            if ( ! $this->disabled_for_editor && ! $editor_style_added ) {
                if ( $this->check_admin_setting( 'importcss' ) && $this->has_editor_style() === false ) {
                    add_editor_style();
                }

                $editor_style_added = true;
            }

            return $settings;
        }

        private function is_disabled() {
            return $this->disabled_for_editor;
        }

        private function has_editor_style() {
            if ( ! current_theme_supports( 'editor-style' ) ) {
                return false;
            }

            $editor_stylesheets = get_editor_stylesheets();

            if ( is_array( $editor_stylesheets ) ) {
                foreach ( $editor_stylesheets as $url ) {
                    if ( strpos( $url, 'editor-style.css' ) !== false ) {
                        return $url;
                    }
                }
            }

            return '';
        }

        public function load_textdomain() {
            load_plugin_textdomain( 'tinymce-advanced', false, 'tinymce-advanced/langs' );
        }

        public function enqueue_scripts( $page ) {
            if ( 'settings_page_tinymce-advanced' === $page ) {
                $plugin_url =get_template_directory_uri().'/inc/tinymce-advanced/plugin-assets';
                wp_enqueue_style( 'tadv-css', $plugin_url . '/tadv.css', array( 'editor-buttons' ), $this->plugin_version );
                wp_enqueue_script( 'tadv-js', $plugin_url . '/tadv.js', array( 'jquery-ui-sortable' ), $this->plugin_version, true );
                wp_enqueue_style( 'tadv-mce-skin', includes_url( 'js/tinymce/skins/lightgray/skin.min.css' ), array(), $this->plugin_version );

                add_action( 'admin_footer', array( $this, 'load_mce_translation' ) );
            }
        }

        public function load_mce_translation() {
            if ( ! class_exists( '_WP_Editors' ) ) {
                require( ABSPATH . WPINC . '/class-wp-editor.php' );
            }

            ?>
            <script>var tadvTranslation = <?php echo _WP_Editors::wp_mce_translation( '', true ); ?>;</script>
            <?php
        }

        public function load_settings() {
            if ( empty( $this->admin_settings ) ) {
                $this->admin_settings = get_option( 'tadv_admin_settings', false );
            }

            if ( empty( $this->user_settings ) ) {
                $this->user_settings = get_option( 'tadv_settings', false );
            }

            // load defaults if the options don't exist...
            if ( $this->admin_settings === false ) {
                $this->admin_settings = $this->get_default_admin_settings();
            }

            $this->admin_options = ! empty( $this->admin_settings['options'] ) ? explode( ',', $this->admin_settings['options'] ) : array();

            $default_user_settings = $this->get_default_user_settings();

            if ( $this->user_settings === false ) {
                $this->user_settings = $default_user_settings;
            }

            if ( empty( $this->user_settings['toolbar_1'] ) ) {
                $this->user_settings['toolbar_1'] = $default_user_settings['toolbar_1'];
            }

            if ( empty( $this->user_settings['toolbar_classic_block'] ) ) {
                $this->user_settings['toolbar_classic_block'] = $default_user_settings['toolbar_classic_block'];
            }

            if ( empty( $this->user_settings['toolbar_block'] ) ) {
                $this->user_settings['toolbar_block'] = $default_user_settings['toolbar_block'];
            }

            $this->options   = ! empty( $this->user_settings['options'] )   ? explode( ',', $this->user_settings['options'] )   : array();
            $this->plugins   = ! empty( $this->user_settings['plugins'] )   ? explode( ',', $this->user_settings['plugins'] )   : array();
            $this->toolbar_1 = ! empty( $this->user_settings['toolbar_1'] ) ? explode( ',', $this->user_settings['toolbar_1'] ) : array();
            $this->toolbar_2 = ! empty( $this->user_settings['toolbar_2'] ) ? explode( ',', $this->user_settings['toolbar_2'] ) : array();
            $this->toolbar_3 = ! empty( $this->user_settings['toolbar_3'] ) ? explode( ',', $this->user_settings['toolbar_3'] ) : array();
            $this->toolbar_4 = ! empty( $this->user_settings['toolbar_4'] ) ? explode( ',', $this->user_settings['toolbar_4'] ) : array();
            $this->toolbar_classic_block = ! empty( $this->user_settings['toolbar_classic_block'] ) ? explode( ',', $this->user_settings['toolbar_classic_block'] ) : array();

            $this->toolbar_block =      ! empty( $this->user_settings['toolbar_block'] )      ? explode( ',', $this->user_settings['toolbar_block'] )      : array();
            $this->toolbar_block_side = ! empty( $this->user_settings['toolbar_block_side'] ) ? explode( ',', $this->user_settings['toolbar_block_side'] ) : array();
            $this->panels_block =       ! empty( $this->user_settings['panels_block'] )       ? explode( ',', $this->user_settings['panels_block'] )       : array();

            $this->used_buttons = array_merge( $this->toolbar_1, $this->toolbar_2, $this->toolbar_3, $this->toolbar_4, $this->toolbar_classic_block );
            $this->used_block_buttons = array_merge( $this->toolbar_block, $this->toolbar_block_side );
            $this->get_all_buttons();

            // Force refresh after activation.
            if ( ! empty( $GLOBALS['tinymce_version'] ) && strpos( $GLOBALS['tinymce_version'], '-tadv-' ) === false ) {
                $GLOBALS['tinymce_version'] .= '-tadv-' . $this->plugin_version;
            }
        }

        public function show_version_warning() {
            if ( is_admin() && current_user_can( 'update_plugins' ) && get_current_screen()->base === 'post' ) {
                $this->warn_if_unsupported();
            }
        }

        public function warn_if_unsupported() {
            if ( ! $this->check_minimum_supported_version() ) {
                $wp_version = ! empty( $GLOBALS['wp_version'] ) ? $GLOBALS['wp_version'] : '(undefined)';

                ?>
                <div class="error notice is-dismissible"><p>
                        <?php

                        printf(
                            __( 'TinyMCE Advanced requires WordPress version %1$s or newer. It appears that you are running %2$s. This can make the editor unstable.', 'tinymce-advanced' ),
                            $this->required_wp_version,
                            esc_html( $wp_version )
                        );

                        echo '<br>';

                        printf(
                            __( 'Please upgrade your WordPress installation or download an <a href="%s">older version of the plugin</a>.', 'tinymce-advanced' ),
                            'https://wordpress.org/plugins/tinymce-advanced/advanced/#download-previous-link'
                        );

                        ?>
                    </p></div>
                <?php
            }
        }

        // Min version
        private function check_minimum_supported_version() {
            include( ABSPATH . WPINC . '/version.php' ); // get an unmodified $wp_version
            $wp_version = str_replace( '-src', '', $wp_version );

            return ( version_compare( $wp_version, $this->required_wp_version, '>=' ) );
        }

        public function update_settings() {
            $version = (int) get_option( 'tadv_version', 0 );

            if ( $version >= $this->plugin_version ) {
                return;
            }

            if ( ! $version || $version < 4000 ) {
                // First install or upgrade to TinyMCE 4.0
                $this->user_settings = $this->get_default_user_settings();
                $this->admin_settings = $this->get_default_admin_settings();

                update_option( 'tadv_settings', $this->user_settings );
                update_option( 'tadv_admin_settings', $this->admin_settings );

                // Clean out old options
                delete_option('tadv_options');
                delete_option('tadv_toolbars');
                delete_option('tadv_plugins');
                delete_option('tadv_btns1');
                delete_option('tadv_btns2');
                delete_option('tadv_btns3');
                delete_option('tadv_btns4');
                delete_option('tadv_allbtns');
            } else {
                $admin_settings = get_option( 'tadv_admin_settings', false );
                $user_settings = get_option( 'tadv_settings', false );
                $user_defaults = $this->get_default_user_settings();

                if ( $version < 5000 ) {
                    // Update for WP 5.0
                    $admin_5000 = ! empty( $admin_settings['options'] ) ? $admin_settings['options'] : '';
                    $user_5000 = ! empty( $user_settings['options'] ) ? $user_settings['options'] : '';

                    if ( empty( $admin_5000 ) ) {
                        $admin_5000 = 'hybrid_mode,classic_paragraph_block';
                    } elseif ( strpos( $admin_5000, 'no_hybrid_mode' ) !== false ) {
                        $admin_5000 = str_replace( 'no_hybrid_mode', 'classic_paragraph_block', $admin_5000 );
                    } else {
                        $admin_5000 .= ',hybrid_mode,classic_paragraph_block';
                    }

                    if ( empty( $user_5000 ) ) {
                        $user_5000 = 'menubar_block,merge_toolbars';
                    } elseif ( strpos( $user_5000, 'no_merge_toolbars' ) !== false ) {
                        $user_5000 = str_replace( 'no_merge_toolbars', 'menubar_block', $user_5000 );
                    } else {
                        $user_5000 .= ',menubar_block,merge_toolbars';
                    }

                    if ( empty( $user_settings['toolbar_block'] ) ) {
                        $user_settings['toolbar_block'] = $user_defaults['toolbar_block'];
                        $user_settings['toolbar_block_side'] = $user_defaults['toolbar_block_side'];
                        $user_settings['panels_block'] = $user_defaults['panels_block'];
                    }

                    $admin_settings['options'] = $admin_5000;
                    $user_settings['options'] = $user_5000;
                }

                if ( $version < 5200 ) {
                    // Update for 5.2, table options
                    if ( empty( $admin_settings ) || ! is_array( $admin_settings ) ) {
                        $admin_settings = array(
                            'options' => 'table_resize_bars,table_grid,table_tab_navigation,table_advtab',
                        );
                    } elseif ( empty( $admin_settings['options'] ) || ! is_string( $admin_settings['options'] ) ) {
                        $admin_settings['options'] = 'table_resize_bars,table_grid,table_tab_navigation,table_advtab';
                    } else {
                        $admin_settings['options'] .= ',table_resize_bars,table_grid,table_tab_navigation,table_advtab';
                    }

                    if ( ! empty( $user_settings['toolbar_block'] ) ) {
                        // Remove previously manageable buttons...
                        $toolbar_block_5200 = str_replace( array( 'core/bold', 'core/italic', 'core/link' ), '', $user_settings['toolbar_block'] );
                        $user_settings['toolbar_block'] = trim( $toolbar_block_5200, ' ,' );
                    }

                    if ( empty( $user_settings['toolbar_block'] ) ) {
                        $user_settings['toolbar_block'] = 'core/image';
                    } else {
                        $user_settings['toolbar_block'] = $user_settings['toolbar_block'] . ',core/image';
                    }
                }

                update_option( 'tadv_admin_settings', $admin_settings );
                update_option( 'tadv_settings', $user_settings );
            }

            // Current version
            update_option( 'tadv_version', $this->plugin_version );
        }

        public function get_all_buttons() {
            if ( ! empty( $this->all_buttons ) ) {
                return $this->all_buttons;
            }

            $buttons = array(
                // Core
                'bold' => 'Bold',
                'italic' => 'Italic',
                'underline' => 'Underline',
                'strikethrough' => 'Strikethrough',
                'alignleft' => 'Align left',
                'aligncenter' => 'Align center',
                'alignright' => 'Align right',
                'alignjustify' => 'Justify',
                'styleselect' => 'Formats',
                'formatselect' => 'Paragraph',
                'fontselect' => 'Font Family',
                'fontsizeselect' => 'Font Sizes',
                'cut' => 'Cut',
                'copy' => 'Copy',
                'paste' => 'Paste',
                'bullist' => 'Bulleted list',
                'numlist' => 'Numbered list',
                'outdent' => 'Decrease indent',
                'indent' => 'Increase indent',
                'blockquote' => 'Blockquote',
                'undo' => 'Undo',
                'redo' => 'Redo',
                'removeformat' => 'Clear formatting',
                'subscript' => 'Subscript',
                'superscript' => 'Superscript',

                // From plugins
                'hr' => 'Horizontal line',
                'link' => 'Insert/edit link',
                'unlink' => 'Remove link',
                'image' => 'Insert/edit image',
                'charmap' => 'Special character',
                'pastetext' => 'Paste as text',
                'print' => 'Print',
                'anchor' => 'Anchor',
                'searchreplace' => 'Find and replace',
                'visualblocks' => 'Show blocks',
                'visualchars' => 'Show invisible characters',
                'code' => 'Source code',
                'wp_code' => 'Code',
                'fullscreen' => 'Fullscreen',
                'insertdatetime' => 'Insert date/time',
                'media' => 'Insert/edit video',
                'nonbreaking' => 'Nonbreaking space',
                'table' => 'Table',
                'ltr' => 'Left to right',
                'rtl' => 'Right to left',
                'emoticons' => 'Emoticons',
                'forecolor' => 'Text color',
                'backcolor' => 'Background color',

                // WP
                'wp_adv'		=> 'Toolbar Toggle',
                'wp_help'		=> 'Keyboard Shortcuts',
                'wp_more'		=> 'Read more...',
                'wp_page'		=> 'Page break',

                'tadv_mark'     => 'Mark',
            );

            // add/remove allowed buttons
            $buttons = apply_filters( 'tadv_allowed_buttons', $buttons );

            $this->all_buttons = $buttons;
            $this->buttons_filter = array_keys( $buttons );
            return $buttons;
        }

        public function get_plugins( $plugins = array() ) {

            if ( ! is_array( $this->used_buttons ) ) {
                $this->load_settings();
            }

            if ( in_array( 'anchor', $this->used_buttons, true ) )
                $plugins[] = 'anchor';

            if ( in_array( 'visualchars', $this->used_buttons, true ) )
                $plugins[] = 'visualchars';

            if ( in_array( 'visualblocks', $this->used_buttons, true ) )
                $plugins[] = 'visualblocks';

            if ( in_array( 'nonbreaking', $this->used_buttons, true ) )
                $plugins[] = 'nonbreaking';

            if ( in_array( 'emoticons', $this->used_buttons, true ) )
                $plugins[] = 'emoticons';

            if ( in_array( 'insertdatetime', $this->used_buttons, true ) )
                $plugins[] = 'insertdatetime';

            if ( in_array( 'table', $this->used_buttons, true ) )
                $plugins[] = 'table';

            if ( in_array( 'print', $this->used_buttons, true ) )
                $plugins[] = 'print';

            if ( in_array( 'searchreplace', $this->used_buttons, true ) )
                $plugins[] = 'searchreplace';

            if ( in_array( 'code', $this->used_buttons, true ) )
                $plugins[] = 'code';

            // From options
            if ( $this->check_user_setting( 'advlist' ) )
                $plugins[] = 'advlist';

            if ( $this->check_user_setting( 'advlink' ) )
                $plugins[] = 'link';

            if ( $this->check_admin_setting( 'importcss' ) )
                $plugins[] = 'importcss';

            if ( $this->check_user_setting( 'contextmenu' ) )
                $plugins[] = 'contextmenu';

            // add/remove used plugins
            $plugins = apply_filters( 'tadv_used_plugins', $plugins, $this->used_buttons );

            return array_unique( $plugins );
        }

        private function check_user_setting( $setting ) {
            if ( ! is_array( $this->options ) ) {
                $this->load_settings();
            }

            // Back-compat for 'fontsize_formats'
            if ( $setting === 'fontsize_formats' && $this->check_admin_setting( 'fontsize_formats' ) ) {
                return true;
            }

            if ( $setting === 'selected_text_color' ) {
                return in_array( 'tadv/color-panel', $this->panels_block, true );
            }

            if ( $setting === 'selected_text_background_color' ) {
                return in_array( 'tadv/background-color-panel', $this->panels_block, true );
            }

            return in_array( $setting, $this->options, true );
        }

        private function check_admin_setting( $setting ) {
            if ( ! is_array( $this->admin_options ) ) {
                $this->load_settings();
            }

            if ( strpos( $setting, 'enable_' ) === 0 ) {
                $disabled_editors = ! empty( $this->admin_settings['disabled_editors'] ) ? explode( ',', $this->admin_settings['disabled_editors'] ) : array();
                return ! in_array( str_replace( 'enable_', '', $setting ), $disabled_editors );
            }

            return in_array( $setting, $this->admin_options, true );
        }

        public function mce_buttons_1( $original, $editor_id ) {
            if ( $this->is_disabled() ) {
                return $original;
            }

            if ( ! is_array( $this->options ) ) {
                $this->load_settings();
            }

            if ( $editor_id === 'classic-block' ) {
                $buttons_1 = $this->toolbar_classic_block;
            } else {
                $buttons_1 = $this->toolbar_1;
            }

            if ( is_array( $original ) && ! empty( $original ) ) {
                $original = array_diff( $original, $this->buttons_filter );
                $buttons_1 = array_merge( $buttons_1, $original );
            }

            return $buttons_1;
        }

        public function mce_buttons_2( $original, $editor_id ) {
            if ( $this->is_disabled() ) {
                return $original;
            }

            if ( ! is_array( $this->options ) ) {
                $this->load_settings();
            }

            if ( $editor_id === 'classic-block' ) {
                $buttons_2 = array();
            } else {
                $buttons_2 = $this->toolbar_2;
            }

            if ( is_array( $original ) && ! empty( $original ) ) {
                $original = array_diff( $original, $this->buttons_filter );
                $buttons_2 = array_merge( $buttons_2, $original );
            }

            return $buttons_2;
        }

        public function mce_buttons_3( $original, $editor_id ) {
            if ( $this->is_disabled() ) {
                return $original;
            }

            if ( ! is_array( $this->options ) ) {
                $this->load_settings();
            }

            if ( $editor_id === 'classic-block' ) {
                $buttons_3 = array();
            } else {
                $buttons_3 = $this->toolbar_3;
            }

            if ( is_array( $original ) && ! empty( $original ) ) {
                $original = array_diff( $original, $this->buttons_filter );
                $buttons_3 = array_merge( $buttons_3, $original );
            }

            return $buttons_3;
        }

        public function mce_buttons_4( $original, $editor_id ) {
            if ( $this->is_disabled() ) {
                return $original;
            }

            if ( ! is_array( $this->options ) ) {
                $this->load_settings();
            }

            if ( $editor_id === 'classic-block' ) {
                $buttons_4 = array();
            } else {
                $buttons_4 = $this->toolbar_4;
            }

            if ( is_array( $original ) && ! empty( $original ) ) {
                $original = array_diff( $original, $this->buttons_filter );
                $buttons_4 = array_merge( $buttons_4, $original );
            }

            return $buttons_4;
        }

        public function mce_options( $init, $editor_id = '' ) {
            if ( $this->is_disabled() ) {
                return $init;
            }

            $init['image_advtab'] = true;
            $init['rel_list'] = '[{text: "None", value: ""}, {text: "Nofollow", value: "nofollow noreferrer"}]';
            // Prevent user errors.
            $init['removed_menuitems'] = 'newdocument';

            if ( $this->check_admin_setting( 'no_autop' ) ) {
                $init['wpautop'] = false;
                $init['indent'] = true;
                $init['tadv_noautop'] = true;
            }

            if ( $editor_id === 'classic-block' ) {
                if ( $this->check_user_setting( 'menubar_block' ) ) {
                    $init['menubar'] = true;
                }

                if (
                    $this->check_user_setting( 'merge_toolbars' ) &&
                    ! empty( $init['toolbar1'] ) &&
                    is_string( $init['toolbar1'] )
                ) {
                    if ( ! empty( $init['toolbar2'] ) && is_string( $init['toolbar2'] ) ) {
                        $init['toolbar1'] = $init['toolbar1'] . ',' . $init['toolbar2'];
                        $init['toolbar2'] = '';
                    }
                    if ( ! empty( $init['toolbar3'] ) && is_string( $init['toolbar3'] ) ) {
                        $init['toolbar1'] = $init['toolbar1'] . ',' . $init['toolbar3'];
                        $init['toolbar3'] = '';
                    }
                    if ( ! empty( $init['toolbar4'] ) && is_string( $init['toolbar4'] ) ) {
                        $init['toolbar1'] = $init['toolbar1'] . ',' . $init['toolbar4'];
                        $init['toolbar4'] = '';
                    }
                }
            } else {
                if ( $this->check_user_setting( 'menubar' ) ) {
                    $init['menubar'] = true;
                }
            }

            if ( ! in_array( 'wp_adv', $this->toolbar_1, true ) ) {
                $init['wordpress_adv_hidden'] = false;
            }

            if ( $this->check_admin_setting( 'importcss' ) ) {
                $init['importcss_file_filter'] = 'editor-style.css';
            }

            if ( $this->check_user_setting( 'fontsize_formats' ) ) {
                $init['fontsize_formats'] =  $this->fontsize_formats;
            }

            if ( in_array( 'table', $this->plugins, true ) ) {
                $init['table_toolbar'] = false;

                // Prefer percentage values
                $init['table_responsive_width'] = true;

                if ( ! $this->check_admin_setting( 'table_resize_bars' ) ) {
                    $init['table_resize_bars'] = false;
                    $init['object_resizing'] = 'img';
                }

                if ( ! $this->check_admin_setting( 'table_default_attributes' ) ) {
                    $init['table_default_attributes'] = '{}';
                }

                if ( ! $this->check_admin_setting( 'table_grid' ) ) {
                    $init['table_grid'] = false;
                }

                if ( ! $this->check_admin_setting( 'table_tab_navigation' ) ) {
                    $init['table_tab_navigation'] = false;
                }

                if ( ! $this->check_admin_setting( 'table_advtab' ) ) {
                    $init['table_advtab'] = false;
                    $init['table_cell_advtab'] = false;
                    $init['table_row_advtab'] = false;
                    $init['table_appearance_options'] = false;
                }
            }

            return $init;
        }

        public function block_editor_assets() {
            $plugin_url = get_template_directory_uri().'/inc/tinymce-advanced/block-editor';


            if ( ! is_array( $this->admin_options ) ) {
                $this->load_settings();
            }

            if ( $this->check_admin_setting( 'hybrid_mode' ) || $this->check_admin_setting( 'classic_paragraph_block' ) ) {
                $strings = array();
                $dependencies = array( 'wp-element', 'wp-components', 'wp-i18n', 'wp-keycodes', 'wp-blocks', 'wp-edit-post', 'wp-hooks', 'lodash' );
                wp_enqueue_script( 'tadv-classic-paragraph', $plugin_url . '/classic-paragraph.js', $dependencies, $this->plugin_version );

                if ( $this->check_admin_setting( 'classic_paragraph_block' ) ) {
                    $strings = array(
                        'classicParagraphTitle' => __( 'Classic Paragraph', 'tinymce-advanced' ),
                        'classicParagraph' => 'yes',
                        'description' => __( 'For use instead of the Paragraph Block. Supports transforming to and from multiple Paragraph blocks, Image, Table, List, Quote, Custom HTML, and most other blocks.', 'tinymce-advanced' ),
                    );

                    wp_enqueue_style( 'tadv-classic-paragraph-styles', $plugin_url . '/classic-paragraph.css', array(), $this->plugin_version );
                }

                if ( $this->check_admin_setting( 'hybrid_mode' ) ) {
                    $strings['hybridMode'] = 'yes';
                }

                wp_localize_script( 'tadv-classic-paragraph', 'tadvBlockRegister', $strings );
            }

            // Block editor toolbars
            if ( ! empty( $this->toolbar_block ) || ! empty( $this->toolbar_block_side ) || ! empty( $this->panels_block ) ) {
                $dependencies = array( 'wp-element', 'wp-components', 'wp-i18n', 'wp-editor', 'wp-rich-text' );
                wp_enqueue_script( 'tadv-block-buttons', $plugin_url . '/richtext-buttons.js', $dependencies, $this->plugin_version );

                $all_block_buttons = $this->get_all_block_buttons();
                $all_block_buttons = array_keys( $all_block_buttons );
                $unusedButtons = array_diff( $all_block_buttons, $this->toolbar_block, $this->toolbar_block_side );

                $strings = array(
                    'buttons' => implode( ',', $this->toolbar_block ),
                    'panelButtons' => implode( ',', $this->toolbar_block_side ),
                    'unusedButtons' => implode( ',', $unusedButtons ),
                    'colorPanel' => implode( ',', $this->panels_block ),

                    // Strings
                    'strFormatting' => __( 'Formatting', 'tinymce-advanced' ),
                    'strRemoveFormatting' => __( 'Clear formatting', 'tinymce-advanced' ),
                    'strSuperscript' => __( 'Superscript', 'tinymce-advanced' ),
                    'strSubscript' => __( 'Subscript', 'tinymce-advanced' ),
                    'strMark' => __( 'Mark', 'tinymce-advanced' ),
                    'strUnderline' => __( 'Underline', 'tinymce-advanced' ),

                    'strTextColor' => __( 'Text Color', 'tinymce-advanced' ),
                    'strTextColorLabel' => __( 'Selected text color', 'tinymce-advanced' ),
                    'strBackgroundColor' => __( 'Text Background Color', 'tinymce-advanced' ),
                    'strBackgroundColorLabel' => __( 'Selected text background color', 'tinymce-advanced' ),
                );

                wp_localize_script( 'tadv-block-buttons', 'tadvBlockButtons', $strings );

                wp_enqueue_style( 'tadv-block-buttons-styles', $plugin_url . '/richtext-buttons.css', array(), $this->plugin_version );
            }

            wp_enqueue_style( 'tadv-block-editor-styles', $plugin_url . '/tma-block-editor.css', array(), $this->plugin_version );
        }

        public function block_editor_init() {
            if ( $this->check_admin_setting( 'replace_block_editor' ) && ! class_exists( 'Classic_Editor' ) ) {
                add_filter( 'use_block_editor_for_post_type', '__return_false', 1000 );
            }
        }

        public function filter_post_content( $data ) {
            $content = $data['post_content'];
            // Fix for the fix to keep <p> tags inside the classic block :-(
            // $data is slashed...
            if ( strpos( $content, '<p data-tadv-p=\"keep\">' ) !== false ) {
                $content = str_replace( '<p data-tadv-p=\"keep\">', '<p>', $content );
            }

            $data['post_content'] = $content;
            return $data;
        }

        // Excerpts can be generated from classic paragraph blocks
        public function excerpt_add_allowed_blocks( $allowed_blocks ) {
            // Make sure a plugin doesn't pass the wrong type here...
            $allowed_blocks = (array) $allowed_blocks;
            $allowed_blocks[] = 'tadv/classic-paragraph';
            return $allowed_blocks;
        }

        public function mce_external_plugins( $mce_plugins ) {
            if ( ! is_array( $this->options ) ) {
                $this->load_settings();
            }

            if ( $this->is_disabled() ) {
                return $mce_plugins;
            }

            if ( ! is_array( $this->plugins ) ) {
                $this->plugins = array();
            }

            $this->plugins[] = 'wptadv';

            if ( $this->check_user_setting( 'menubar' ) || $this->check_user_setting( 'menubar_block' ) ) {
                $this->plugins = array_merge( $this->plugins, $this->required_menubar_plugins );
            }

            $this->plugins = array_intersect( $this->plugins, $this->get_all_plugins() );

            $plugin_url =get_template_directory_uri().'/inc/tinymce-advanced/mce/';
            $mce_plugins = (array) $mce_plugins;
            $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

            foreach ( $this->plugins as $plugin ) {
                $mce_plugins["$plugin"] = $plugin_url . $plugin . "/plugin{$suffix}.js";
            }

            return $mce_plugins;
        }

        public function tiny_mce_plugins( $plugins ) {
            if ( $this->is_disabled() ) {
                return $plugins;
            }

            if ( in_array( 'image', $this->used_buttons, true ) && ! in_array( 'image', $plugins, true ) ) {
                $plugins[] = 'image';
            }

            if ( ( in_array( 'rtl', $this->used_buttons, true ) || in_array( 'ltr', $this->used_buttons, true ) ) &&
                ! in_array( 'directionality', (array) $plugins, true ) ) {

                $plugins[] = 'directionality';
            }

            return $plugins;
        }

        private function parse_buttons( $toolbar_id = false, $buttons = false ) {
            if ( $toolbar_id && ! $buttons && ! empty( $_POST[$toolbar_id] ) )
                $buttons = $_POST[$toolbar_id];

            if ( is_array( $buttons ) ) {
                $_buttons = array_map( array( @$this, 'filter_name' ), $buttons );
                return implode( ',', array_filter( $_buttons ) );
            }

            return '';
        }

        private function filter_name( $str ) {
            if ( empty( $str ) || ! is_string( $str ) )
                return '';
            // Button names
            return preg_replace( '/[^a-z0-9_]/i', '', $str );
        }

        private function sanitize_settings( $settings ) {
            $_settings = array();

            if ( ! is_array( $settings ) ) {
                return $_settings;
            }

            foreach( $settings as $name => $value ) {
                $name = preg_replace( '/[^a-z0-9_]+/', '', $name );

                if ( strpos( $name, 'toolbar_' ) === 0 ) {
                    $_settings[$name] = $this->parse_buttons( false, explode( ',', $value ) );
                } else if ( 'options' === $name || 'plugins' === $name || 'disabled_plugins' === $name ) {
                    $_settings[$name] = preg_replace( '/[^a-z0-9_,]+/', '', $value );
                }
            }

            return $_settings;
        }

        /**
         * Validare array of settings against a whitelist.
         *
         * @param array $settings The settings.
         * @param array $checklist The whitelist.
         * @return string The validated settings CSV.
         */
        private function validate_settings( $settings, $checklist ) {
            if ( empty( $settings ) ) {
                return '';
            } elseif ( is_string( $settings ) ) {
                $settings = explode( ',', $settings );
            } elseif ( ! is_array( $settings ) ) {
                return '';
            }

            $_settings = array();

            foreach ( $settings as $value ) {
                if ( in_array( $value, $checklist, true ) ) {
                    $_settings[] = $value;
                }
            }

            return implode( ',', $_settings );
        }

        private function save_settings( $all_settings = null ) {
            $settings = $user_settings = array();
            $default_settings = $this->get_default_user_settings();

            if ( empty( $this->buttons_filter ) ) {
                $this->get_all_buttons();
            }

            if ( ! empty( $all_settings['settings'] ) ) {
                $user_settings = $all_settings['settings'];
            }

            for ( $i = 1; $i < 6; $i++ ) {
                $toolbar_name = ( $i < 5 ) ? 'toolbar_' . $i : 'toolbar_classic_block';

                if ( ! empty( $user_settings[ $toolbar_name ] ) ) {
                    $toolbar = explode( ',', $user_settings[ $toolbar_name ] );
                } elseif ( ! empty( $_POST[ $toolbar_name ] ) && is_array( $_POST[ $toolbar_name ] ) ) {
                    $toolbar = $_POST[ $toolbar_name ];
                } else {
                    $toolbar = array();
                }

                if ( $i > 1 && in_array( 'wp_adv', $toolbar, true ) ) {
                    $toolbar = array_diff( $toolbar, array( 'wp_adv' ) );
                }

                $settings[ $toolbar_name ] = $this->validate_settings( $toolbar, $this->buttons_filter );
            }

            // Block editor toolbar
            if ( empty( $this->block_buttons_filter ) ) {
                $this->get_all_block_buttons();
            }

            if ( ! empty( $user_settings[ 'toolbar_block' ] ) ) {
                $settings[ 'toolbar_block' ] = $this->validate_settings( $user_settings[ 'toolbar_block' ], $this->block_buttons_filter );
            } elseif ( ! empty( $_POST[ 'toolbar_block' ] ) && is_array( $_POST[ 'toolbar_block' ] ) ) {
                $settings[ 'toolbar_block' ] = $this->validate_settings( $_POST[ 'toolbar_block' ], $this->block_buttons_filter );
            } else {
                $settings[ 'toolbar_block' ] = array();
            }

            if ( ! empty( $user_settings[ 'toolbar_block_side' ] ) ) {
                $settings[ 'toolbar_block_side' ] = $this->validate_settings( $user_settings[ 'toolbar_block_side' ], $this->block_buttons_filter );
            } elseif ( ! empty( $_POST[ 'toolbar_block_side' ] ) && is_array( $_POST[ 'toolbar_block_side' ] ) ) {
                $settings[ 'toolbar_block_side' ] = $this->validate_settings( $_POST[ 'toolbar_block_side' ], $this->block_buttons_filter );
            } else {
                $settings[ 'toolbar_block_side' ] = array();
            }

            if ( ! empty( $user_settings[ 'panels_block' ] ) ) {
                $panels_block = $this->validate_settings( explode( ',', $user_settings[ 'panels_block' ] ), $this->get_all_block_panels() );
            } else {
                $panels_block = array();

                if ( ! empty( $_POST[ 'selected_text_color' ] ) && $_POST[ 'selected_text_color' ] === 'yes' ) {
                    $panels_block[] = 'tadv/color-panel';
                }

                if ( ! empty( $_POST[ 'selected_text_background_color' ] ) && $_POST[ 'selected_text_background_color' ] === 'yes' ) {
                    $panels_block[] = 'tadv/background-color-panel';
                }

                $panels_block = implode( ',', $panels_block );
            }

            $settings[ 'panels_block' ] = $panels_block;

            if ( ! empty( $user_settings['options'] ) ) {
                $options = explode( ',', $user_settings['options'] );
            } elseif ( ! empty( $_POST['options'] ) && is_array( $_POST['options'] ) ) {
                $options = $_POST['options'];
            } else {
                $options = array();
            }

            $settings['options'] = $this->validate_settings( $options, $this->get_all_user_options() );


            if ( ! empty( $user_settings['plugins'] ) ) {
                $plugins = explode( ',', $user_settings['plugins'] );
            } else {
                $plugins = array();
            }

            if ( ! empty( $settings['options']['menubar'] ) || ! empty( $settings['options']['menubar_block'] ) ) {
                $plugins = array_merge( $plugins, $this->required_menubar_plugins );
            }

            // Merge the submitted plugins with plugins needed for the buttons.
            $this->user_settings = $settings;
            $this->load_settings();
            $plugins = $this->get_plugins( $plugins );

            $settings['plugins'] = $this->validate_settings( $plugins, $this->get_all_plugins() );

            $this->user_settings = $settings;
            $this->load_settings();

            // Save the new settings.
            update_option( 'tadv_settings', $settings );

            if ( ! is_multisite() || current_user_can( 'manage_sites' ) ) {
                $this->save_admin_settings( $all_settings );
            }
        }

        private function save_admin_settings( $all_settings = null ) {
            $admin_settings = $save_admin_settings = array();

            if ( ! empty( $all_settings['admin_settings'] ) ) {
                $admin_settings = $all_settings['admin_settings'];
            }

            if ( ! empty( $admin_settings ) ) {
                if ( ! empty( $admin_settings['options'] ) ) {
                    $save_admin_settings['options'] = $this->validate_settings( $admin_settings['options'], $this->get_all_admin_options() );
                } else {
                    $save_admin_settings['options'] = '';
                }

                $disabled_editors = array_intersect( $this->get_editor_locations(), explode( ',', $admin_settings['disabled_editors'] ) );
            } elseif ( isset( $_POST['tadv-save'] ) ) {
                if ( ! empty( $_POST['admin_options'] ) && is_array( $_POST['admin_options'] ) ) {
                    $save_admin_settings['options'] = $this->validate_settings( $_POST['admin_options'], $this->get_all_admin_options() );
                }

                if ( ! empty( $_POST['tadv_enable_at'] ) && is_array( $_POST['tadv_enable_at'] ) ) {
                    $tadv_enable_at = $_POST['tadv_enable_at'];
                } else {
                    $tadv_enable_at = array();
                }

                $disabled_editors = array_diff( $this->get_editor_locations(), $tadv_enable_at );
            } else {
                return;
            }

            $save_admin_settings['disabled_editors'] = implode( ',', $disabled_editors );

            $this->admin_settings = $save_admin_settings;
            update_option( 'tadv_admin_settings', $save_admin_settings );
        }

        private function import_from_file() {
            if ( empty( $_FILES['tadv-import']['name'] ) ) {
                return 1;
            }

            $file_type = wp_check_filetype( $_FILES['tadv-import']['name'], array( 'json' => 'application/json' ) );

            if ( $file_type['ext'] !== 'json' ) {
                return 1;
            }

            $settings = @file_get_contents( $_FILES['tadv-import']['tmp_name'] );

            if ( empty( $settings ) ) {
                return 2;
            }

            $settings = json_decode( $settings, true );

            if ( ! is_array( $settings ) ) {
                return 3;
            }

            $this->save_settings( $settings );
            return 0;
        }

        public function import_export_settings_file() {
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if (
                isset( $_POST['tadv-import-file'] ) &&
                isset( $_POST['tadv-import-settings-nonce'] ) &&
                wp_verify_nonce( $_POST['tadv-import-settings-nonce'], 'tadv-import-settings' )
            ) {
                $err = $this->import_from_file();
                $url = admin_url( 'options-general.php?page=tinymce-advanced' );
                $url = add_query_arg( 'tadv-import-file-complete', $err, $url );

                wp_safe_redirect( $url );
                exit;
            } elseif (
                isset( $_POST['tadv-export-settings'] ) &&
                isset( $_POST['tadv-export-settings-nonce'] ) &&
                wp_verify_nonce( $_POST['tadv-export-settings-nonce'], 'tadv-export-settings' )
            ) {
                $this->load_settings();
                $output = array( 'settings' => $this->user_settings );

                // TODO: only admin || SA
                $output['admin_settings'] = $this->admin_settings;

                $sitename = get_bloginfo( 'name' );

                if ( mb_strlen( $sitename ) > 100 ) {
                    $sitename = mb_substr( $sitename, 0, 100 );
                }

                $sitename = preg_replace( '/[ \.-]+/', '-', $sitename );

                $date = date( 'Y-m-d' );
                $filename = sanitize_file_name( $sitename . '-TMA-settings-' . $date . '.json' );

                nocache_headers();
                header( 'Content-Type: application/json; charset=utf-8' );
                header( "Content-Disposition: attachment; filename=$filename" );

                echo wp_json_encode( $output );
                exit;
            }
        }

        public function settings_page() {
            if ( ! defined( 'TADV_ADMIN_PAGE' ) ) {
                define( 'TADV_ADMIN_PAGE', true );
            }

            include_once( dirname(__FILE__). '/tadv_admin.php' );
        }

        public function add_menu() {
            add_options_page( 'TinyMCE Advanced', 'TinyMCE Advanced', 'manage_options', 'tinymce-advanced', array( $this, 'settings_page' ) );
        }

        /**
         * Add a link to the settings page
         */
        public function add_settings_link( $links, $file ) {
            if (
                strpos( $file, '/tinymce-advanced.php' ) !== false &&
                dirname(dirname(__FILE__)) === $file &&
                current_user_can( 'manage_options' )
            ) {
                $settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php?page=tinymce-advanced' ), __( 'Settings', 'tinymce-advanced' ) );
                $links = (array) $links;
                $links['tma_settings_link'] = $settings_link;
            }

            return $links;
        }
    }

    new Tinymce_Advanced;
endif;
