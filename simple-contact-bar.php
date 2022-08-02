<?php
if (!defined('ABSPATH')) exit;
/*
Plugin Name: Simple Contact Bar
Plugin URI: https://wordpress.org/plugins/simple-contact-bar/
Description: A simple plugin that adds a contact bar for Click To Call Now Button and Whatsapp Chat Button which fixed to the bottom of your site. Display phone number, whatsapp number as text and click to call link, whatsapp chat link by shortcodes supports.
Tags: click to call, call now, beni ara düğmesi, call now button, click to call bar, call button, telefonla arama, whatsapp button, text from whatsapp
Requires at least: Wordpress 4.0.0
Tested up to: Wordpress 6.0.1
Version: 1.0
Author: Tuncay TEKE
Author URI: https://tuncayteke.com.tr
Text Domain: simple-contact-bar
License: GPL2+ or later
License URI: https://www.gnu.org/licenses/gpl-2.0.txt
*/

// Add Admin Stuff

add_action('admin_menu', 'simple_contact_bar_add_admin_menu');
add_action('admin_init', 'simple_contact_bar_settings_init');
add_action('admin_enqueue_scripts', 'simple_contact_bar_add_color_picker');

//Add Click To Call Bar to Footer

add_action('wp_footer', 'simple_contact_bar_button_code');

// Load Color Picker

function simple_contact_bar_add_color_picker($hook)
{

    if (is_admin()) {

        // Add Color Picker CSS
        wp_enqueue_style('wp-color-picker');

        // Include Color Picker JS
        wp_enqueue_script('custom-script-handle', plugins_url('js/simple-contact-bar.js', __FILE__), array('wp-color-picker'), false, true);
    }
}

// Add to Menu > Tools

function simple_contact_bar_add_admin_menu()
{

    add_submenu_page('options-general.php', 'Simple Contact Bar', 'Simple Contact Bar', 'manage_options', 'simple_contact_bar_button', 'simple_contact_bar_options_page');
}

// Adding Settings

function simple_contact_bar_settings_init()
{

    register_setting('simple_contact_bar_page', 'simple_contact_bar_settings');

    add_settings_section(
        'simple_contact_bar_page_section',
        __('A simple plugin that adds a click to call now button and whatsapp contact link button to the bottom of your site and Also supports shortcodes.', 'simple-contact-bar'),
        'simple_contact_bar_settings_section_callback',
        'simple_contact_bar_page'
    );

    add_settings_field(
        'simple_contact_bar_enable',
        __('Enable Simple Contact Bar and Buttons', 'simple-contact-bar'),
        'simple_contact_bar_settings_enable_render',
        'simple_contact_bar_page',
        'simple_contact_bar_page_section'
    );

    add_settings_field(
        'simple_contact_bar_phone_title',
        __('Your Click to Call Button Title Message', 'simple-contact-bar'),
        'simple_contact_bar_phone_title_render',
        'simple_contact_bar_page',
        'simple_contact_bar_page_section'
    );

    add_settings_field(
        'simple_contact_bar_phone_number',
        __('Your Phone Number', 'simple-contact-bar'),
        'simple_contact_bar_phone_number_render',
        'simple_contact_bar_page',
        'simple_contact_bar_page_section'
    );

    add_settings_field(
        'simple_contact_bar_whatsapp_title',
        __('Your Whatsapp Button Title Message', 'simple-contact-bar'),
        'simple_contact_bar_whatsapp_title_render',
        'simple_contact_bar_page',
        'simple_contact_bar_page_section'
    );

    add_settings_field(
        'simple_contact_bar_whatsapp_number',
        __('Your Whatsapp Number', 'simple-contact-bar'),
        'simple_contact_bar_whatsapp_number_render',
        'simple_contact_bar_page',
        'simple_contact_bar_page_section'
    );

    add_settings_field(
        'simple_contact_bar_phone_text_color',
        __('Your Phone Number Title Text Color', 'simple-contact-bar'),
        'simple_contact_bar_phone_text_color_render',
        'simple_contact_bar_page',
        'simple_contact_bar_page_section'
    );
    add_settings_field(
        'simple_contact_bar_phone_bg_color',
        __('Click to Call Button Background Color', 'simple-contact-bar'),
        'simple_contact_bar_phone_bg_color_render',
        'simple_contact_bar_page',
        'simple_contact_bar_page_section'
    );
    add_settings_field(
        'simple_contact_bar_whatsapp_text_color',
        __('Your Whatsapp Title Text Color', 'simple-contact-bar'),
        'simple_contact_bar_whatsapp_text_color_render',
        'simple_contact_bar_page',
        'simple_contact_bar_page_section'
    );


    add_settings_field(
        'simple_contact_bar_whatsapp_bg_color',
        __('Your Whatsapp Button Background Color', 'simple-contact-bar'),
        'simple_contact_bar_whatsapp_bg_color_render',
        'simple_contact_bar_page',
        'simple_contact_bar_page_section'
    );
}

// Render Admin Input

function simple_contact_bar_settings_enable_render()
{

    $options = get_option('simple_contact_bar_settings');
?>
    <input name="simple_contact_bar_settings[simple_contact_bar_enable]" type="hidden" value="0" />
    <input name="simple_contact_bar_settings[simple_contact_bar_enable]" type="checkbox" value="1" <?php checked('1', sanitize_text_field($options['simple_contact_bar_enable'])); ?> />

<?php

}


function simple_contact_bar_phone_title_render()
{

    $options = get_option('simple_contact_bar_settings');
?>
    <input type="text" placeholder="ex. Call Now!" name="simple_contact_bar_settings[simple_contact_bar_phone_title]" value="<?php echo sanitize_text_field($options['simple_contact_bar_phone_title']); ?>">
<?php

}

function simple_contact_bar_whatsapp_title_render()
{

    $options = get_option('simple_contact_bar_settings');
?>
    <input type="text" placeholder="ex. Whatsapp Now!" name="simple_contact_bar_settings[simple_contact_bar_whatsapp_title]" value="<?php echo sanitize_text_field($options['simple_contact_bar_whatsapp_title']); ?>">
<?php

}

function simple_contact_bar_phone_number_render()
{

    $options = get_option('simple_contact_bar_settings');
?>
    <input type="text" placeholder="ex. 5555555555" name="simple_contact_bar_settings[simple_contact_bar_phone_number]" value="<?php echo sanitize_text_field($options['simple_contact_bar_phone_number']); ?>">
<?php

}
function simple_contact_bar_whatsapp_number_render()
{

    $options = get_option('simple_contact_bar_settings');
?>
    <input type="text" placeholder="ex. 5555555555" name="simple_contact_bar_settings[simple_contact_bar_whatsapp_number]" value="<?php echo sanitize_text_field($options['simple_contact_bar_whatsapp_number']); ?>">
<?php

}

function simple_contact_bar_phone_text_color_render()
{

    $options = get_option('simple_contact_bar_settings');
?>
    <input type="text" class="color-field" name="simple_contact_bar_settings[simple_contact_bar_phone_text_color]" value="<?php echo sanitize_hex_color($options['simple_contact_bar_phone_text_color']); ?>">
<?php

}

function simple_contact_bar_whatsapp_text_color_render()
{

    $options = get_option('simple_contact_bar_settings');
?>
    <input type="text" class="color-field" name="simple_contact_bar_settings[simple_contact_bar_whatsapp_text_color]" value="<?php echo sanitize_hex_color($options['simple_contact_bar_whatsapp_text_color']); ?>">
<?php

}

function simple_contact_bar_phone_bg_color_render()
{

    $options = get_option('simple_contact_bar_settings');
?>
    <input type="text" class="color-field" name="simple_contact_bar_settings[simple_contact_bar_phone_bg_color]" value="<?php echo sanitize_hex_color($options['simple_contact_bar_phone_bg_color']); ?>">
<?php

}

function simple_contact_bar_whatsapp_bg_color_render()
{

    $options = get_option('simple_contact_bar_settings');
?>
    <input type="text" class="color-field" name="simple_contact_bar_settings[simple_contact_bar_whatsapp_bg_color]" value="<?php echo sanitize_hex_color($options['simple_contact_bar_whatsapp_bg_color']); ?>">
<?php

}

function simple_contact_bar_settings_section_callback()
{
    echo __('Enter your information in the fields below. If you don\'t enter anything into the message area a phone icon will still show.', 'simple-contact-bar');
}

// Output Code If Enabled

function simple_contact_bar_button_code()
{

    $options = get_option('simple_contact_bar_settings');

    // Check If Plugin Enabled
    if (sanitize_text_field($options['simple_contact_bar_enable']) == '1') {

        echo '<div class="call_now_row">
		<div class="call_now_coll"><a class="call_now_coll_btn" href="tel:' . sanitize_text_field($options['simple_contact_bar_phone_number']) . '" style="color:' . sanitize_hex_color($options['simple_contact_bar_phone_text_color']) . ' !important; background-color:' . sanitize_hex_color($options['simple_contact_bar_phone_bg_color']) . ';"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-outbound" viewBox="0 0 16 16">
<path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zM11 .5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-4.146 4.147a.5.5 0 0 1-.708-.708L14.293 1H11.5a.5.5 0 0 1-.5-.5z"></path>
</svg> ' . sanitize_text_field($options['simple_contact_bar_phone_title']) . '</a></div>
<div class="call_now_coll"><a rel="external" class="call_now_coll_btn" href="https://api.whatsapp.com/send/?phone=' . sanitize_text_field($options['simple_contact_bar_whatsapp_number']) . '" style="color:' . sanitize_hex_color($options['simple_contact_bar_whatsapp_text_color']) . ' !important; background-color:' . sanitize_hex_color($options['simple_contact_bar_whatsapp_bg_color']) . ';" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
<path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"></path>
</svg> ' . sanitize_text_field($options['simple_contact_bar_whatsapp_title']) . '</a></div>
</div>';

        wp_enqueue_style('simple_contact_bar-styles', plugin_dir_url(__FILE__) . 'css/style.css');
    }
}

// SIMPLE CONTACT BAR SHORTCODES

// Display Phone Number ShortCode
function simple_contact_bar_show_phone_number_display()
{

    $options = get_option('simple_contact_bar_settings');

    // Check If Plugin Enabled
    if (sanitize_text_field($options['simple_contact_bar_enable'] == '1')) {

        // Sanitize Options
        $simple_contact_bar_phone_number = sanitize_text_field($options['simple_contact_bar_phone_number']);
    } else {
        $simple_contact_bar_phone_number = "";
    }
    return $simple_contact_bar_phone_number;
}
add_shortcode('simple_contact_bar_phone_number', 'simple_contact_bar_show_phone_number_display');


// Display Phone Link ShortCode
function simple_contact_bar_show_phone_number_link_display()
{

    $options = get_option('simple_contact_bar_settings');

    // Check If Plugin Enabled
    if (sanitize_text_field($options['simple_contact_bar_enable'] == '1')) {

        // Sanitize Options
        $simple_contact_bar_phone_number_link = '<a href="tel:' . sanitize_text_field($options['simple_contact_bar_phone_number']) . '">' . sanitize_text_field($options['simple_contact_bar_phone_title']) . '</a>';
    } else {
        $simple_contact_bar_phone_number_link = "";
    }
    return $simple_contact_bar_phone_number_link;
}
add_shortcode('simple_contact_bar_phone_link', 'simple_contact_bar_show_phone_number_link_display');


// Display Whatsapp Number ShortCode
function simple_contact_bar_show_whatsapp_number_display()
{

    $options = get_option('simple_contact_bar_settings');

    // Check If Plugin Enabled
    if (sanitize_text_field($options['simple_contact_bar_enable']) == '1') {

        // Sanitize Options
        $simple_contact_bar_whatsapp_number = sanitize_text_field($options['simple_contact_bar_whatsapp_number']);
    } else {
        $simple_contact_bar_whatsapp_number = "";
    }
    return $simple_contact_bar_whatsapp_number;
}
add_shortcode('simple_contact_bar_whatsapp_number', 'simple_contact_bar_show_whatsapp_number_display');

// Display Whatsapp Link ShortCode
function simple_contact_bar_show_whatsapp_link_display()
{

    $options = get_option('simple_contact_bar_settings');

    // Check If Plugin Enabled
    if (sanitize_text_field($options['simple_contact_bar_enable']) == '1') {

        // Sanitize Options
        $simple_contact_bar_whatsapp_number_link = '<a rel="external" href="https://api.whatsapp.com/send/?phone=' . sanitize_text_field($options['simple_contact_bar_whatsapp_number']) . '" target="_blank">' . sanitize_text_field($options['simple_contact_bar_whatsapp_title']) . '</a>';
    } else {
        $simple_contact_bar_whatsapp_number_link = "";
    }
    return $simple_contact_bar_whatsapp_number_link;
}
add_shortcode('simple_contact_bar_whatsapp_link', 'simple_contact_bar_show_whatsapp_link_display');

// Display Admin Form

function simple_contact_bar_options_page()
{

?>
    <form action="options.php" method="post">

        <h1><?php echo __('Simple Contact Bar for Click to call and Whatsapp chat buttons.', 'simple-contact-bar'); ?></h1>
        <?php
        settings_fields('simple_contact_bar_page');
        do_settings_sections('simple_contact_bar_page');
        submit_button();
        ?>
    </form>
    <h3>::. <?php echo __('Shortcode Supports', 'simple-contact-bar'); ?> .::</h3>
    <p><strong><?php echo __('Shortcode for displaying phone number as text', 'simple-contact-bar'); ?>:</strong> [simple_contact_bar_phone_number]</p>
    <p><strong><?php echo __('Shortcode for displaying clickable phone link with title', 'simple-contact-bar'); ?>:</strong> [simple_contact_bar_phone_link]</p>
    <p><strong><?php echo __('Shortcode for displaying whatsapp number as text', 'simple-contact-bar'); ?>:</strong> [simple_contact_bar_whatsapp_number]</p>
    <p><strong><?php echo __('Shortcode for displaying clickable whatsapp link with title', 'simple-contact-bar'); ?>:</strong> [simple_contact_bar_whatsapp_link]</p>
    <p><br></p>
    <p><?php echo __('Thanks for using Simple Contact Bar. Coded with love by ', 'simple-contact-bar'); ?><a href="https://tuncayteke.com.tr">Tuncay TEKE</a></p>
<?php

}

?>
