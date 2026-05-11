<?php
/**
 * Sublimeplus_Settings_Page
 *
 * @package SublimePulse\Core\Admin\Classes
 * @author   SublimePulse
 * @link     https://bitandbytelab.com/
 *
 */
require_once SUBLIMEPLUS_DIR . 'core/admin/freamwork/tabs.php'; // If SublimeBaseTab is in the same directory


final class Sublimeplus_Settings_Page
{
    const SLUG = 'sublimeplus-theme-settings';
    const GROUP = 'sublimeplus_settings_group';

    public $hook_suffix;
    protected $settings;
    private $tabs = [];
    private $active_tab = '';

    private function __construct() {
        $this->theme = Sublimeplus_get_parent_theme_object();
        $this->settings = (array)get_option(Sublimeplus_SETTINGS_KEY) ?: [];
        $this->initTabs();
        $this->active_tab = $this->getCurrentTab();
    }

    static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new self();
            add_action('admin_menu', [$instance, '_add'], 11);
            add_action('admin_init', [$instance, '_register'], 10)  ;
            add_action('admin_notices', [$instance, '_notify'], 10, 0);
        }
        return $instance;
    }

    private function initTabs() {
        $settings = get_option(Sublimeplus_SETTINGS_KEY) ?: [];
        $this->tabs['general-settings'] = new SublimeGeneralTab($settings);
        $this->tabs['header-settings'] = new SublimeHeaderTab($settings);
        $this->tabs['homepage-banner-settings'] = new SublimeHomePageBannerTab($settings);
        // Add more tabs as needed
    }

    private function getCurrentTab() {
        if (isset($_GET['tab']) && array_key_exists($_GET['tab'], $this->tabs)) {
            return sanitize_text_field($_GET['tab']);
        }
        return 'general-settings'; // Default tab
    }

    public function _add() {
        if (!function_exists('Sublimeplus_base69_encode')) {
            return;
        }
        $this->hook_suffix = Sublimeplus_add_submenu_page(
            Sublimeplus_Welcome_Page::SLUG,
            esc_html__('Theme Settings', 'sublimeplus'),
            esc_html__('Theme Settings', 'sublimeplus'),
            'manage_options',
            self::SLUG,
            [$this, '_render']
        );
    }

    function _register()
    {
        register_setting(self::GROUP, Sublimeplus_SETTINGS_KEY, array($this, '_sanitize'));
    }


    

    public function _render() {
        ?> <form class="form-table m-0 p-0" action="options.php" method="post">
    <?php settings_fields(self::GROUP); ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="sublime-option-header row">
                    <div class="col-lg-10">
                        <h2 class="t-white t-captilize">
                            <strong><?php echo esc_html($this->theme->name) . " Options" ;  ?></strong>
                            <span>
                                <?php echo "v " . esc_html($this->theme->version) ?>
                            </span>
                        </h2>
                    </div>
                    <div class="col-lg-2">
                        <div class="theme-logo">
                            <img src="<?php echo esc_url(SUBLIMEPLUS_LOGO) ?>" alt="<?php bloginfo('name'); ?>"
                                width="100" height="auto">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <?php do_settings_sections(self::GROUP);  $this->sublime_submit_button(); ?>
            <div class="col-lg-12">
                <div class="container sublime-option-outer">
                    <div class="sublimeplus-theme-settings row" id="Sublime-options">
                        <div class="col-3 p-0">
                            <div class="nav-bar">


                                <ul role="tablist" aria-owns="nav-tab1 nav-tab2 nav-tab3 nav-tab4"
                                    class="nav nav-tabs flex-column" id="nav-tab-with-nested-tabs">

                                    <?php foreach ($this->tabs as $tab_id => $tab_obj):
                                    
                                    ?>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link <?php echo $tab_id === $this->active_tab ? 'active' : ''; ?>"
                                            href="#<?php echo esc_attr($tab_id); ?>" aria-current="page"
                                            id="<?php echo esc_attr($tab_id); ?>_" data-bs-toggle="tab"
                                            data-bs-target="#<?php echo esc_attr($tab_id); ?>" role="tab"
                                            aria-controls="tab1-content" aria-selected="true">
                                            <?php echo esc_html($tab_obj->getTitle()); ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-9 m-0 p-0">


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="tab-content" id="nav-tabs-content">
                                        <?php foreach ($this->tabs as $tab_id => $tab_obj): ?>
                                        <?php $tab_obj->render(); ?>
                                        <?php do_settings_fields(self::GROUP, $tab_id) ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>
<?php
    }
    public function sublime_submit_button()
    {
        echo '<div class="row m-0 p-0">
        <div class="col-lg-12 " style="background-color: #ddd;">
            <span class="sublime-submit alignright" style="padding: 10px;"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></span>                                </div>
    </div>';
    }
    public function _sanitize($settings) {
        if (!empty($settings['import_settings']) && function_exists('Sublimeplus_base69_decode')) {
            $_settings = unserialize(Sublimeplus_base69_decode($settings['import_settings']));
            if (is_array($_settings)) {
                $this->importSettings($_settings);
            }
        }

        unset($settings['import_settings']);

        $settings['mobile_breakpoint_width'] = isset($settings['mobile_breakpoint_width']) ? intval($settings['mobile_breakpoint_width']) : '';
         $settings['enable_dev_mode'] = isset($settings['enable_dev_mode']) ? intval($settings['enable_dev_mode']) : 0;
         $settings['enable_builtin_mega_menu'] = isset($settings['enable_builtin_mega_menu']) ? intval($settings['enable_builtin_mega_menu']) : 0;

        return $settings;
    }



    /**
     * Do notification
     */
    function _notify()
    {
        if ($GLOBALS['page_hook'] !== $this->hook_suffix) {
            return;
        }

        if (isset($_REQUEST['settings-updated']) && 'true' === $_REQUEST['settings-updated']) {
            echo '<div class="updated notice is-dismissible"><p><strong>' . esc_html__('Settings have been saved successfully!', 'sublimeplus') . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">' . esc_html__('Dismiss this notice.', 'sublimeplus') . '</span></div>';
        }

        if (isset($_REQUEST['error']) && 'true' === $_REQUEST['error']) {
            echo '<div class="updated error is-dismissible"><p><strong>' . esc_html__('Failed to save settings. Please try again!', 'sublimeplus') . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">' . esc_html__('Dismiss this notice.', 'sublimeplus') . '</span></div>';
        }
    }
}
Sublimeplus_Settings_Page::getInstance();