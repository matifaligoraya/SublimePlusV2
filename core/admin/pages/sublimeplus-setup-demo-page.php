<?php
/**
 * Sublimeplus_Setup_Demo_Page
 *
 * @package SublimePulse\Core\Admin\Classes
 * @author   SublimePulse
 * @link     https://bitandbytelab.com/
 *
 */
final class Sublimeplus_Setup_Demo_Page
{
    /**
     * Slug
     */
    const SLUG = 'sublimeplus-theme-setup-demo';

    /**
     * Hook suffix
     */
    public $hook_suffix;

    /**
     * Settings
     *
     * @var  array
     */
    protected $settings;

    /**
     * Theme
     */
    protected $theme;

    /**
     * @var bool
     */
    protected $isMulti = true;

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->theme = Sublimeplus_get_parent_theme_object();
        $this->settings = (array)get_option(Sublimeplus_SETTINGS_KEY) ? : [];

        if (is_readable(SUBLIMEPLUS_DIR . 'inc/sample-data/base')) {
            $this->isMulti = false;
        }
    }

    /**
     * Singleton
     */
    static function getInstance()
    {
        static $self = null;

        if (null === $self) {
            $self = new self;
            add_action('admin_menu', [$self, '_add'], 13);
            add_action('wp_ajax_Sublimeplus_setup_demo_content', [$self, '_setUpDemo'], 10, 0);
            add_action('wp_ajax_Sublimeplus_uninstall_demo_content', [$self, '_uninstallDemo'], 10, 0);
        }
    }

    /**
     * Add to admin menu
     */
    function _add($context = '')
    {
        $this->hook_suffix = Sublimeplus_add_submenu_page(
            Sublimeplus_Welcome_Page::SLUG,
            esc_html__('Setup Demo Data', 'sublimeplus'),
            esc_html__('Setup Demo Data', 'sublimeplus'),
            'manage_options',
            self::SLUG,
            array($this, '_render')
        );
    }

    /**
     * Render
     */
    function _render()
    {
        $parser = new Sublimeplus_WXR_Parser();
		$demos  = new DirectoryIterator(SUBLIMEPLUS_DIR . 'inc/sample-data');
		$demo   = get_theme_mod('theme_setup_site_demo', 'default');

        ?><div class="sublimeplus-theme-setup-site-demo">
			<h2 class="screen-reader-text"><?php esc_html_e('Setup site demo', 'sublimeplus') ?></h2>
            <div class="theme-presets">
                <ul class="demo-list"><?php
                    foreach ($demos as $folder) :
						if ($folder->isDot() || !$folder->isDir() || !$folder->isReadable()) {
							continue;
						}
                        $style = $folder->getFilename();
						$homef = $this->isMulti ? $style . '/home.xml' : $style . '/content.xml';
						if ('base' === $style || !is_readable(SUBLIMEPLUS_DIR . 'inc/sample-data/'.$homef)) continue;
                        $home_data = $parser->parse(SUBLIMEPLUS_DIR . 'inc/sample-data/' . $homef);
                        if (is_wp_error($home_data)) continue;
	                    ?><li class="demo-item <?php echo esc_attr($style === $demo ? 'current ' : ''); ?>">
                            <div class="demo-content">
                                <img class="demo-thumbnail" src="<?php echo SUBLIMEPLUS_URI . 'inc/sample-data/'.$style.'/screen.jpg' ?>">
                                <?php if ($style === $demo) : ?>
                                    <span class="demo-label"><?php esc_html_e('Installed', 'sublimeplus') ?></span>
                                <?php endif ?>
                            </div>
                            <div class="demo-footer">
                                <span class="demo-title"><?php echo esc_html($home_data['posts'][0]['post_title']) ?></span>
                                <span class="demo-actions">
                                    <img class="demo-spinner" src="<?php echo admin_url('images/spinner.gif') ?>" alt="<?php esc_attr_e('Installing', 'sublimeplus') ?>">
                                    <a class="demo-preview" href="<?php echo esc_url($home_data['posts'][0]['_link']) ?>" target="_blank"><?php esc_html_e('Preview', 'sublimeplus') ?></a>
                                    <span class="sep">|</span>
                                    <?php
                                        if ($style === $demo) {
                                            $button_name = esc_html__('Uninstall', 'sublimeplus');
                                            $action = $button_class = 'uninstall';
                                        } else {
                                            $button_name = esc_html__('Install', 'sublimeplus');
                                            $action = $button_class = 'install';
                                        }
                                        printf('<a type="button" data-style="%s" data-action="%s" class="demo-import %s">%s</a>', esc_attr($style), esc_attr($action), esc_attr($button_class), esc_attr($button_name));
                                    ?>
                                </span>
                            </div>
                        </li><?php
					endforeach;
				?></ul>
            </div>
        </div><?php
    }

    /**
     * Setup demo
     */
    function _setUpDemo()
    {
        if (!current_user_can('manage_options')) {
            exit(json_encode([
                'success' => false,
                'message' => esc_html__('Cheating, huh!', 'sublimeplus')
            ]));
        }

        if (empty($_POST['Sublimeplus_demo_slug'])) {
            exit(json_encode([
                'success' => false,
                'message' => esc_html__('Invalid demo ID.', 'sublimeplus')
            ]));
        }

        $demo_slug = sanitize_title($_POST['Sublimeplus_demo_slug']);
        $demo_path = SUBLIMEPLUS_DIR . 'inc/sample-data/' . $demo_slug . '/';
        $demo_importer = new Sublimeplus_Demo_Importer();

        if (!$this->isMulti) {
            $this->installBaseData($demo_importer);
        } else {
            $this->removeOldDemo();
            $this->installDemoData($demo_importer, $demo_path);
        }

        if (is_readable($demo_path . 'slider.zip')) {
            $demo_importer->importRevSliders($demo_path . 'slider.zip');
        }

        if (is_readable($demo_path . 'widgets.wie')) {
            $demo_importer->importWidgets($demo_path . 'widgets.wie');
        }

        if (is_readable($demo_path . 'customizer.dat')) {
            $demo_importer->importThemeOptions($demo_path . 'customizer.dat');
        }

        if (is_dir($demo_path . 'settings')) {
            $demo_importer->importThemeSettings($demo_path . 'settings/');
        }

        if ($this->isMulti) {
            $homef = 'home.xml';
        } else {
            $homef = 'content.xml';
        }

        if (!is_readable($demo_path . $homef)) {
            exit(json_encode([
                'success' => false,
                'message' => esc_html__('Demo content file not found.', 'sublimeplus')
            ]));
        }

		$xml_parser = new Sublimeplus_WXR_Parser();
		$content = $xml_parser->parse($demo_path . $homef);
		$home_id = $content['posts'][0]['post_id'];
        $imported_content = get_transient('_wxr_imported_content') ? : [];

		if (isset($imported_content['posts'][$home_id])) {
			update_option('show_on_front', 'page');
			update_option('page_on_front', $imported_content['posts'][$home_id]);
		} else {
			$ok = $demo_importer->importContent($demo_path . $homef);
            if (true !== $ok) {
                exit(json_encode([
                    'success' => false,
                    'message' => esc_html__('Failed to import demo content.', 'sublimeplus') . ' ' . $ok->getMessage()
                ]));
            }
			update_option('show_on_front', 'page');
			update_option('page_on_front', $imported_content['posts'][$home_id]);
		}

        set_theme_mod('theme_setup_site_demo', $demo_slug);

        exit(json_encode([
            'success' => true,
            'message' => esc_html__('Demo data installed successfully!', 'sublimeplus')
        ]));
    }

    /**
     * Cleanup old demo data
     */
    protected function removeOldDemo()
    {
        $imported_content = get_transient('_wxr_imported_content');

        foreach ($imported_content as $key => $values) {
            if (empty($values)) {
                continue;
            } else {
                switch ($key) {
                    case 'authors':
                        foreach ($values as $old => $new) {
                            wp_delete_user($new);
                        }
                    break;
                    case 'posts':
                        foreach ($values as $old => $new) {
                            wp_delete_post($new, true);
                        }
                    break;
                    case 'menu_items':
                        foreach ($values as $old => $new) {
                            wp_delete_post($new, true);
                        }
                    break;
                }
            }
        }

        remove_theme_mods();
        delete_option('sidebars_widgets');
        delete_option($this->theme->template.'_base_content_installed');
    }

    /**
     * Install base data
     */
    protected function installBaseData(Sublimeplus_Demo_Importer $importer)
    {
        $is_base_content_installed = get_option($this->theme->template.'_base_content_installed');

        if (!$is_base_content_installed) {
            if (!is_readable(SUBLIMEPLUS_DIR . 'inc/sample-data/base/content.xml')) {
                exit(json_encode([
                    'success' => false,
                    'message' => esc_html__('Base content file not found.', 'sublimeplus')
                ]));
            }
            $ok = $importer->importContent(SUBLIMEPLUS_DIR . 'inc/sample-data/base/content.xml');
            if ($ok !== true) {
                exit(json_encode([
                    'success' => false,
                    'message' => esc_html__('Failed to import base content.', 'sublimeplus') . ' ' . $ok->getMessage()
                ]));
            }
            if (is_readable(SUBLIMEPLUS_DIR . 'inc/sample-data/base/slider.zip')) {
                $importer->importRevSliders(SUBLIMEPLUS_DIR . 'inc/sample-data/base/slider.zip');
            }
            if (is_readable(SUBLIMEPLUS_DIR . 'inc/sample-data/base/widgets.wie')) {
                $importer->importWidgets(SUBLIMEPLUS_DIR . 'inc/sample-data/base/widgets.wie');
            }
            if (is_readable(SUBLIMEPLUS_DIR . 'inc/sample-data/base/customizer.dat')) {
                $importer->importThemeOptions(SUBLIMEPLUS_DIR . 'inc/sample-data/base/customizer.dat');
            }
            if (is_dir(SUBLIMEPLUS_DIR . 'inc/sample-data/base/settings')) {
                $importer->importThemeSettings(SUBLIMEPLUS_DIR . 'inc/sample-data/base/settings/');
            }
            update_option($this->theme->template.'_base_content_installed', time());
        }
    }

    /**
     * Install demo data
     */
    protected function installDemoData(Sublimeplus_Demo_Importer $importer, $demo)
    {
        if (!is_readable($demo . 'content.xml')) {
            exit(json_encode([
                'success' => false,
                'message' => esc_html__('Demo content file not found.', 'sublimeplus')
            ]));
        }

        $ok = $importer->importContent($demo . 'content.xml');

        if ($ok !== true) {
            exit(json_encode([
                'success' => false,
                'message' => esc_html__('Failed to import site content.', 'sublimeplus') . ' ' . $ok->getMessage()
            ]));
        }
    }

    /**
     * Uninstall demo page
     */
    function _uninstallDemo()
    {
        if (!current_user_can('manage_options')) {
            exit(json_encode([
                'success' => false,
                'message' => esc_html__('Cheating, huh!', 'sublimeplus')
            ]));
        }

        if (empty($_POST['Sublimeplus_demo_slug'])) {
            exit(json_encode([
                'success' => false,
                'message' => esc_html__('Invalid demo ID.', 'sublimeplus')
            ]));
        }

        $uninstalled = false;

        $this->removeOldDemo();


		    update_option('show_on_front', '');
            update_option('page_on_front', '');

            set_theme_mod('theme_setup_site_demo', '');
            exit(json_encode([
                'success' => true,
                'message' => esc_html__('Demo has been uninstalled successfully.', 'sublimeplus')
            ]));

    }
}
Sublimeplus_Setup_Demo_Page::getInstance();
