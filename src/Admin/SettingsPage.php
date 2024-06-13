<?php

namespace SMPostRender\Admin;

class SettingsPage
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'addAdminMenu']);
        add_action('admin_init', [$this, 'settingsInit']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }

    public function addAdminMenu()
    {
        add_options_page(
            'SM Post Render Settings',
            'SM Post Render',
            'manage_options',
            'sm-post-render',
            [$this, 'render']
        );
    }

    public function settingsInit()
    {
        // Register the settings
        register_setting('sm_post_render_options_group', 'ag_id');
        register_setting('sm_post_render_options_group', 'feed_id');

        add_settings_section(
            'sm_post_render_main_section',
            'Main Settings',
            [$this, 'mainSectionCallback'],
            'sm-post-render'
        );

        add_settings_field(
            'ag_id_field',
            'Business ID',
            [$this, 'agIdFieldRender'],
            'sm-post-render',
            'sm_post_render_main_section'
        );

        add_settings_field(
            'feed_id_field',
            'Feed ID',
            [$this, 'feedIdFieldRender'],
            'sm-post-render',
            'sm_post_render_main_section'
        );
    }

    public function mainSectionCallback()
    {
        echo '<p>Configure the main settings for SM Post Render.</p>';
    }

    public function agIdFieldRender()
    {
        $agId = get_option('ag_id');
        ?>
        <input type="text" name="ag_id" class="regular-text" value="<?php echo isset($agId) ? esc_attr($agId) : ''; ?>" />
        <p class="description">Enter your Business ID here.</p>
        <?php
    }

    public function feedIdFieldRender()
    {
        $feedId = get_option('feed_id');
        ?>
        <input type="text" name="feed_id" class="regular-text" value="<?php echo isset($feedId) ? esc_attr($feedId) : ''; ?>" />
        <p class="description">Enter your Feed ID here.</p>
        <?php
    }

    public function render()
    {
        ?>
        <div class="wrap">
            <h1>SM Post Render Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('sm_post_render_options_group');
                do_settings_sections('sm-post-render');
                submit_button();
                ?>
            </form>
            <h2>Shortcode Usage</h2>
            <p>Use the <code>[sm-post]</code> shortcode to display social media posts on your website. Here are the available attributes:</p>
            <ul>
                <li><strong>per_page</strong>: The number of posts to display per page (default and restricted to: 5).</li>
            </ul>
            <p><strong>Example Usage:</strong></p>
            <pre style="display: inline;"><code id="shortcode-example">[sm-post per_page="5"]</code></pre>
            <i id="copy-shortcode-icon" class="fa fa-clone" aria-hidden="true" onclick="copyShortcode()" style="cursor: pointer; margin-left: 10px;"></i>
            <h2>Additional Information</h2>
            <p>To customize the appearance of the posts, you can add your own CSS rules in your theme's stylesheet or use the provided CSS file in the plugin.</p>
            <p>Ensure your API keys (Business ID and Feed ID) are correctly configured to fetch the posts successfully.</p>
        </div>
        <?php
    }

    public function enqueue_admin_scripts()
    {
        // Enqueue Font Awesome
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', [], '6.0.0-beta3');

        // Enqueue custom JavaScript
        wp_enqueue_script('sm-post-render-admin', plugin_dir_url(__FILE__) . '../../assets/js/admin.js', [], '1.0.0', true);
    }
}
