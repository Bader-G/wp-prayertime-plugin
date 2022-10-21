<?php

/* ----------------theme customization-------------------------------- */

add_action('customize_register', 'mytheme_customizer_options');
if ( ! function_exists( 'mytheme_customizer_options' ) ) {
    function mytheme_customizer_options($wp_customize) {
        $wp_customize->add_section('wfc_theme_customizer', array(
            'title'    => __('Prayer Bar Settings', 'wfc'),
            'priority' => 30
        ));
        /* Topbar background colour */
        $wp_customize->add_setting(
            'wfc_topbar_color', //give it an ID
            array(
                'default' => '#000', // Give it a default
            )
        );
        $wp_customize->add_control(

            new WP_Customize_Color_Control(
                $wp_customize,
                'wfc_topbar_color', //give it an ID
                array(
                    'label'      => __('Topbar Background Colour', 'mythemename'), //set the label to appear in the Customizer
                    'section'    => 'wfc_theme_customizer', //select the section for it to appear under  
                    'settings'   => 'wfc_topbar_color' //pick the setting it applies to
                )
            )
        );
        /* Text colour */
        $wp_customize->add_setting(
            'wfc_text_color', //give it an ID
            array(
                'default' => '#fff', // Give it a default
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'wfc_text_color', //give it an ID
                array(
                    'label'      => __('Topbar Text Colour', 'mythemename'), //set the label to appear in the Customizer
                    'section'    => 'wfc_theme_customizer', //select the section for it to appear under  
                    'settings'   => 'wfc_text_color' //pick the setting it applies to
                )
            )
        );
    }
}
add_action('wp_head', 'mytheme_customize_css');
if ( ! function_exists( 'mytheme_customize_css' ) ) {
function mytheme_customize_css() {
        ?>
            <style type="text/css">
                #wfc-prayer-bar {
                    background-color: <?php echo esc_html(get_theme_mod('wfc_topbar_color', '#000')); ?> !important;
                }

                #wfc-prayer-bar span {
                    color: <?php echo esc_html(get_theme_mod('wfc_text_color', '#fff')); ?> !important;
                }
            </style>
        <?php
    }
}