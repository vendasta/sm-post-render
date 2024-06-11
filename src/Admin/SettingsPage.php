<?php

namespace SMPostRender\Admin;

class SettingsPage
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'addAdminMenu']);
        add_action('admin_init', [$this, 'settingsInit']);
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
            null,
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

    public function agIdFieldRender()
    {
        $agId = get_option('ag_id');
        ?>
        <input type="text" name="ag_id" class="regular-text" value="<?php echo isset($agId) ? esc_attr($agId) : ''; ?>" />
        <?php
    }

    public function feedIdFieldRender()
    {
        $feedId = get_option('feed_id');
        ?>
        <input type="text" name="feed_id" class="regular-text" value="<?php echo isset($feedId) ? esc_attr($feedId) : ''; ?>" />
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
                <li><strong>per_page</strong>: The number of posts to display per page (default: 5).</li>
            </ul>
            <p><strong>Example Usage:</strong></p>
            <pre><code>[sm-post per_page="5"]</code></pre>
        </div>
        <?php
    }
}
