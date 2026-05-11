<?php
/**
 * Sublimeplus_Customizer
 *
 * @package SublimePulse\Core\Customize\Classes
 * @author   SublimePulse
 * @link     https://bitandbytelab.com/
 *
 */
final class Sublimeplus_Customizer
{
    /**
     * Supporting devices
     *
     * @var  array
     */
    const SUPPORT_DEVICES = ['desktop', 'mobile'];

    /**
    * Default control types
    *
    * @var  array
    */
    const SUPPORT_CONTROL_TYPES = [
        'default',
        'select',
        'font',
        'font_style',
        'text_align',
        'text_align_no_justify',
        'checkbox',
        'css_rule',
        'shadow',
        'icon',
        'slider',
        'color',
        'textarea',
        'radio',
        'media',
        'image',
        'video',
        'hidden',
        'heading',
        'typography',
        'modal',
        'styling',
        'hr',
        'repeater'
    ];

    /**
     * Panels
     *
     * @var  array
     */
    private $panels;

    /**
     * Sections
     *
     * @var  array
     */
    private $sections;

    /**
     * Settings
     *
     * @var  array
     */
    private $settings;

    /**
     * WP_Customize_Manager
     *
     * @var  object
     */
    protected $wp_customize;

    private $selective_settings = [];

    /**
     * Nope constructor
     */
    private function __construct()
    {
        $this->panels = apply_filters('Sublimeplus_default_customize_panels', [
            'header_settings' => [
                'title'    => esc_html__('Site Header', 'sublimeplus'),
                'priority' => -99
            ],
            'layout_panel' => [
                'title'    => esc_html__('Layouts', 'sublimeplus'),
                'priority' => 0
            ],
            'footer_settings' => [
                'title'    => esc_html__('Site Footer', 'sublimeplus'),
                'priority' => 99
            ]
        ]);

        $this->sections = apply_filters('Sublimeplus_default_customize_sections', [
            'header_builder_panel' => [
                'title' => esc_html__('Header Builder', 'sublimeplus'),
                'panel' => 'header_settings',
            ],
            'global_layout_section' => [
                'title' => esc_html__('Global', 'sublimeplus'),
                'panel' => 'layout_panel',
            ],
            'sidebar_layout_section' => [
                'panel' => 'layout_panel',
                'title' => esc_html__('Sidebars', 'sublimeplus')
            ],
            'footer_general' => [
                'title'    => esc_html__('General Settings', 'sublimeplus'),
                'panel'    => 'footer_settings',
                'priority' => 0,
            ],
        ]);

        $this->settings = apply_filters('Sublimeplus_default_customize_settings', [

        ]);

        add_action('customize_register', [$this, '_register']);
        add_action('customize_preview_init', [$this, '_load_preview_assets']);
        add_action('wp_ajax_Sublimeplus__reset_section', [$this, '_ajax_reset_section'], 10, 0);
        add_action('customize_controls_enqueue_scripts', [$this, '_load_controls_assets'], 10, 0);
        add_action('wp_ajax_Sublimeplus_customize_load_fonts', [$this, '_ajax_load_fonts'], 10, 0);
        add_action('wp_ajax_Sublimeplus_customize__load_font_icons', [$this, '_ajax_load_font_icons'], 10, 0);
    }

    /**
     * Add field
     *
     * A shortcut for Sublimeplus_Customizer::add_setting() and Sublimeplus_Customizer::add_control()
     *
     * @param  array  $args
     */
    public function add_field(array $args)
    {
        $args = array_merge([
            'priority'             => null,
            'title'                => null,
            'label'                => null,
            'name'                 => null,
            'type'                 => null,
            'description'          => null,
            'capability'           => null,
            'settings'             => null,
            'active_callback'      => null,
            'sanitize_callback'    => 'Sublimeplus_Customizer::sanitize',
            'sanitize_js_callback' => null,
            'theme_supports'       => null,
            'default'              => null,
            'selector'             => null,
            'render_callback'      => null,
            'css_format'           => null,
            'device'               => null,
            'device_settings'      => null,
            'field_class'          => null,
            'setting'              => null,
            'input_attrs'          => null,
            'choices'              => null
        ], $args);

        if (null === $args['device_settings']) {
            $args['device_settings'] = false;
        }

        switch ($args['type']) {
            case 'panel':
                $name = $args['name'];
                if (!$args['title']) {
                    $args['title'] = $args['label'];
                }
                $args['type'] = 'Sublimeplus_panel';
                foreach ($args as $key => $value) {
                    if (!in_array($key, ['type', 'title', 'priority', 'capability', 'description', 'theme_supports', 'active_callback'])) {
                        unset($args[$key]);
                    }
                }
                $this->wp_customize->add_panel(new WP_Customize_Panel($this->wp_customize, $name, $args));
            break;
            case 'section':
                $name = $args['name'];
                if (!$args['title']) {
                    $args['title'] = $args['label'];
                }
                $args['type'] = 'Sublimeplus_section';
                foreach ($args as $key => $value) {
                    if (!in_array($key, ['type', 'title', 'panel', 'priority', 'capability', 'description', 'theme_supports', 'active_callback', 'description_hidden'])) {
                        unset($args[$key]);
                    }
                }
                $this->wp_customize->add_section(new WP_Customize_Section($this->wp_customize, $name, $args));
                break;
            default:
                switch ($args['type']) {
                    case 'image_select':
                        $args['setting_type'] = 'radio';
                        $args['field_class'] = 'custom-control-image_select' . ($args['field_class'] ? ' ' . $args['field_class'] : '');
                        break;
                    case 'radio_group':
                        $args['setting_type'] = 'radio';
                        $args['field_class'] = 'custom-control-radio_group' . ($args['field_class'] ? ' ' . $args['field_class'] : '');
                        break;
                    default:
                        $args['setting_type'] = $args['type'];
                }
                $args['defaultValue'] = $args['default'];
                $settings_args = array(
                    'sanitize_callback'    => $args['sanitize_callback'],
                    'sanitize_js_callback' => $args['sanitize_js_callback'],
                    'theme_supports'       => $args['theme_supports'],
                    'type'                 => 'theme_mod',
                );
                $settings_args['default'] = $args['default'];
                $settings_args['transport'] = !empty($args['transport']) ? $args['transport'] : 'refresh';

                if (!$settings_args['sanitize_callback']) {
                    $settings_args['sanitize_callback'] = 'Sublimeplus_Customizer::sanitize';
                }

                foreach ($settings_args as $k => $v) {
                    unset($args[$k]);
                }

                $name = $args['name'];
                unset($args['name']);

                unset($args['type']);
                if (!$args['label']) {
                    $args['label'] = $args['title'];
                }

                $selective_refresh = null;
                if ($args['selector'] && ($args['render_callback'] || $args['css_format'])) {
                    $selective_refresh = array(
                        'selector'        => $args['selector'],
                        'render_callback' => $args['render_callback'],
                    );

                    if ($args['css_format']) {
                        $settings_args['transport'] = 'postMessage';
                        $selective_refresh = null;
                    } else {
                        $settings_args['transport'] = 'postMessage';
                    }
                }
                unset($args['default']);
                $this->wp_customize->add_setting($name, array_merge(
                    ['sanitize_callback' => 'Sublimeplus_Customizer::sanitize'
                ],
                    $settings_args
                ));

                $control_class_name = 'Sublimeplus_Customize_Control_';
                $tpl_type = str_replace('_', ' ', $args['setting_type']);
                $tpl_type = str_replace(' ', '_', ucfirst($tpl_type));
                $control_class_name .= $tpl_type;

                if (in_array($args['setting_type'], ['custom_html', 'text'])) {
                    $control_class_name = 'Sublimeplus_Customize_Control_Default';
                }

                    if (class_exists($control_class_name)) {
                        $this->wp_customize->add_control(new $control_class_name($this->wp_customize, $name, $args));
                    } elseif (in_array($args['setting_type'], ['text', 'custom_html', 'js_raw'])) {
                        $this->wp_customize->add_control(new Sublimeplus_Customize_Control_Default($this->wp_customize, $name, $args));
                    } else {
                        $this->wp_customize->add_control($name, [
                            'settings'        => $args['settings'],
                            'setting'         => $args['setting'],
                            'capability'      => $args['capability'],
                            'priority'        => $args['priority'],
                            'section'         => $args['section'],
                            'label'           => $args['label'],
                            'description'     => $args['description'],
                            'choices'         => $args['choices'],
                            'type'            => $args['setting_type'],
                            'active_callback' => $args['active_callback'],
                            'input_attrs'     => $args['input_attrs']
                        ]);
                    }
                if ($selective_refresh) {
                    $s_id = $selective_refresh['render_callback'];
                    if (is_array($s_id)) {
                        $__id = get_class($s_id[0]) . '__' . $s_id[1];
                    } else {
                        $__id = $s_id;
                    }
                    if (!isset($this->selective_settings[$__id])) {
                        $this->selective_settings[$__id] = array(
                            'settings'            => [],
                            'selector'            => $selective_refresh['selector'],
                            'container_inclusive' => (strpos($__id, 'Sublimeplus_Customize_Live_CSS') === false) ? true : false,
                            'render_callback'     => $s_id,
                        );
                    }

                    $this->selective_settings[$__id]['settings'][] = $name;
                }

                break;
        }
    }

    /**
     * Singleton
     */
    public static function get_instance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new self;
        }

        return $instance;
    }

    /**
     * AJAX reset a section
     *
     * @internal  Used as a callback.
     */
    public function _ajax_reset_section()
    {
        if (!current_user_can('customize')) {
            wp_send_json_error();
        }

        $settings = isset($_POST['settings']) ? wp_unslash($_POST['settings']) : [];

        foreach ($settings as $k) {
            $k = sanitize_text_field($k);
            remove_theme_mod($k);
        }

        wp_send_json_success();
    }

    /**
     * Load fonts
     */
    public function _ajax_load_fonts()
    {
        $fonts = [
            'normal' => [
                'title' => esc_html__('Default Web Fonts', 'sublimeplus'),
                'fonts' => Sublimeplus_get_websafe_fonts()
            ],
            'google' => [
                'title' => esc_html__('Google Web Fonts', 'sublimeplus'),
                'fonts' => Sublimeplus_get_google_fonts()
            ]
        ];

        wp_send_json_success($fonts);
    }

    /**
     * AJAX get fonts
     *
     * @internal  Used as a callback.
     */
    public function _ajax_load_font_icons()
    {
        if (!current_user_can('customize')) {
            wp_send_json_error();
        }

        $fonts = [
            'sublimeplus-icon' => [
                'name'  => esc_html__('Theme Icon', 'sublimeplus'),
                'icons' => Sublimeplus_get_font_icons('sublimeplus-icon'),
                'url'   => SUBLIMEPLUS_URI . 'assets/css/icons/icons.css',
                'class_config' => '__icon_name__'
            ]
        ];

        if (current_theme_supports('cs-font')) {
            $fonts['cs-font'] = [
                'name'  => esc_html__('Clever Font', 'sublimeplus'),
                'icons' => Sublimeplus_get_font_icons('cs-font'),
                'url'   => SUBLIMEPLUS_URI . 'assets/vendor/cleverfont/style' . SUBLIMEPLUS_CSS_SUFFIX,
                'class_config' => 'cs-font __icon_name__'
            ];
        }

        wp_send_json_success($fonts);
    }

    /**
     * Load preview assets.
     *
     * @internal  Used as a callback.
     *
     * @hook  customize_preview_init
     */
    public function _load_preview_assets(WP_Customize_Manager $wp_customize)
    {
        wp_enqueue_script('sublimeplus-customize-preview', SUBLIMEPLUS_URI . 'core/assets/js/customize-preview.js', ['customize-selective-refresh'], SUBLIMEPLUS_VERSION, true);

        wp_localize_script('sublimeplus-customize-preview', 'ZooCustomizePreviewData', [
            'fields'          => Sublimeplus_customize_get_all_config($wp_customize),
            'devices'         => self::SUPPORT_DEVICES,
            'cssMediaQueries' => Sublimeplus_Customize_Live_CSS::get_instance()->media_queries,
            'typo_fields'     => $this->get_typo_fields(),
            'styling_config'  => $this->get_styling_config()
        ]);
    }

    /**
     * Load controls' assets
     *
     * @internal  Used as a callback
     *
     * @hook  customize_controls_enqueue_scripts
     */
    public function _load_controls_assets()
    {
        wp_enqueue_media();

        wp_enqueue_style('sublimeplus-customizer-control', SUBLIMEPLUS_URI . 'core/assets/css/customizer.min.css', ['wp-color-picker'], SUBLIMEPLUS_VERSION);

        wp_enqueue_script('DOMPurify', SUBLIMEPLUS_URI . 'core/assets/js/purify.min.js', [], SUBLIMEPLUS_VERSION);

        wp_enqueue_script('wp-color-picker', SUBLIMEPLUS_VERSION);

        wp_enqueue_script('sublimeplus-customize', SUBLIMEPLUS_URI . 'core/assets/js/customize-builder.js', [
            'jquery',
            'customize-base',
            'customize-controls',
            'jquery-ui-core',
            'jquery-ui-slider'
        ], SUBLIMEPLUS_VERSION, true);

        wp_localize_script('sublimeplus-customize', 'zooCustomizeConfig', [
            'home_url'         => esc_url(home_url('')),
            'ajax'             => admin_url('admin-ajax.php'),
            'theme_default'    => esc_html__('Theme Default', 'sublimeplus'),
            'reset'            => esc_html__('Reset this section settings', 'sublimeplus'),
            'untitled'         => esc_html__('Untitled', 'sublimeplus'),
            'confirm_reset'    => esc_html__('Do you want to reset this section settings?', 'sublimeplus'),
            'typo_fields'      => $this->get_typo_fields(),
            'styling_config'   => $this->get_styling_config(),
            'devices'          => self::SUPPORT_DEVICES,
            'list_font_weight' => [
                ''       => esc_html__('Default', 'sublimeplus'),
                'normal' => _x('Normal', 'sublimeplus-font-weight', 'sublimeplus'),
                'bold'   => _x('Bold', 'sublimeplus-font-weight', 'sublimeplus')
            ],
            'isRtl' => is_rtl()
        ]);
    }

    /**
     * Sanitize input data
     *
     * @internal  Used as a callback
     */
    public static function sanitize($data, $setting)
    {
        $data = wp_unslash($data);

        if (!is_array($data)) {
            $data = json_decode(urldecode_deep($data), true);
        }

        $sanitizer = new Sublimeplus_Customize_Sanitizer($setting->manager->get_control($setting->id), $setting);

        return $sanitizer->sanitize($data);
    }

    /**
     * Get typography fields
     *
     * @return array
     */
    public function get_typo_fields()
    {
        $typo_fields = array(
            array(
                'name'    => 'font',
                'type'    => 'select',
                'label'   => esc_html__('Font Family', 'sublimeplus'),
                'choices' => array()
            ),
            array(
                'name'    => 'font_weight',
                'type'    => 'select',
                'label'   => esc_html__('Font Weight', 'sublimeplus'),
                'choices' => array()
            ),
            array(
                'name'  => 'languages',
                'type'  => 'checkboxes',
                'label' => esc_html__('Font Languages', 'sublimeplus'),
            ),
            array(
                'name'            => 'font_size',
                'type'            => 'slider',
                'label'           => esc_html__('Font Size', 'sublimeplus'),
                'min'             => 9,
                'max'             => 80,
                'step'            => 1
            ),
            array(
                'name'            => 'line_height',
                'type'            => 'slider',
                'label'           => esc_html__('Line Height', 'sublimeplus'),
                'min'             => 9,
                'max'             => 80,
                'step'            => 1
            ),
            array(
                'name'  => 'letter_spacing',
                'type'  => 'slider',
                'label' => esc_html__('Letter Spacing', 'sublimeplus'),
                'min'   => -10,
                'max'   => 10,
                'step'  => 0.1
            ),
            array(
                'name'    => 'style',
                'type'    => 'select',
                'label'   => esc_html__('Font Style', 'sublimeplus'),
                'choices' => array(
                    ''        => esc_html__('Default', 'sublimeplus'),
                    'normal'  => esc_html__('Normal', 'sublimeplus'),
                    'italic'  => esc_html__('Italic', 'sublimeplus'),
                    'oblique' => esc_html__('Oblique', 'sublimeplus'),
                )
            ),
            array(
                'name'    => 'text_decoration',
                'type'    => 'select',
                'label'   => esc_html__('Text Decoration', 'sublimeplus'),
                'choices' => array(
                    ''             => esc_html__('Default', 'sublimeplus'),
                    'underline'    => esc_html__('Underline', 'sublimeplus'),
                    'overline'     => esc_html__('Overline', 'sublimeplus'),
                    'line-through' => esc_html__('Line through', 'sublimeplus'),
                    'none'         => esc_html__('None', 'sublimeplus'),
                )
            ),
            array(
                'name'    => 'text_transform',
                'type'    => 'select',
                'label'   => esc_html__('Text Transform', 'sublimeplus'),
                'choices' => array(
                    ''           => esc_html__('Default', 'sublimeplus'),
                    'uppercase'  => esc_html__('Uppercase', 'sublimeplus'),
                    'lowercase'  => esc_html__('Lowercase', 'sublimeplus'),
                    'capitalize' => esc_html__('Capitalize', 'sublimeplus'),
                    'none'       => esc_html__('None', 'sublimeplus'),
                )
            )
        );

        return $typo_fields;
    }

    /**
     * Get styling field
     *
     * @return array
     */
    public function get_styling_config()
    {
        $fields = array(
            'tabs'          => array(
                'normal' => esc_html__('Normal', 'sublimeplus'),  // null or false to disable
                'hover'  => esc_html__('Hover', 'sublimeplus'), // null or false to disable
            ),
            'normal_fields' => array(
                array(
                    'name'       => 'text_color',
                    'type'       => 'color',
                    'device_settings' => true,
                    'label'      => esc_html__('Color', 'sublimeplus'),
                    'css_format' => 'color: {{value}}; text-decoration-color: {{value}};'
                ),
                array(
                    'name'       => 'link_color',
                    'type'       => 'color',
                    'device_settings' => true,
                    'label'      => esc_html__('Link Color', 'sublimeplus'),
                    'css_format' => 'color: {{value}}; text-decoration-color: {{value}};'
                ),
                array(
                    'name'       => 'link_hover_color',
                    'type'       => 'color',
                    'device_settings' => true,
                    'label'      => esc_html__('Link Hover Color', 'sublimeplus'),
                    'css_format' => 'color: {{value}}; text-decoration-color: {{value}};'
                ),

                array(
                    'name'            => 'margin',
                    'type'            => 'css_rule',
                    'device_settings' => true,
                    'css_format'      => array(
                        'top'    => 'margin-top: {{value}};',
                        'right'  => 'margin-right: {{value}};',
                        'bottom' => 'margin-bottom: {{value}};',
                        'left'   => 'margin-left: {{value}};',
                    ),
                    'label'           => esc_html__('Margin', 'sublimeplus'),
                ),

                array(
                    'name'            => 'padding',
                    'type'            => 'css_rule',
                    'device_settings' => true,
                    'css_format'      => array(
                        'top'    => 'padding-top: {{value}};',
                        'right'  => 'padding-right: {{value}};',
                        'bottom' => 'padding-bottom: {{value}};',
                        'left'   => 'padding-left: {{value}};',
                    ),
                    'label'           => esc_html__('Padding', 'sublimeplus'),
                ),

                array(
                    'name'  => 'bg_heading',
                    'type'  => 'heading',
                    'label' => esc_html__('Background', 'sublimeplus'),
                ),

                array(
                    'name'       => 'bg_color',
                    'type'       => 'color',
                    'device_settings' => true,
                    'label'      => esc_html__('Background Color', 'sublimeplus'),
                    'css_format' => 'background-color: {{value}};'
                ),
                array(
                    'name'       => 'bg_image',
                    'type'       => 'image',
                    'device_settings' => true,
                    'label'      => esc_html__('Background Image', 'sublimeplus'),
                    'css_format' => 'background-image: url("{{value}}");'
                ),
                array(
                    'name'       => 'bg_cover',
                    'type'       => 'select',
                    'device_settings' => true,
                    'choices'    => array(
                        ''        => esc_html__('Default', 'sublimeplus'),
                        'auto'    => esc_html__('Auto', 'sublimeplus'),
                        'cover'   => esc_html__('Cover', 'sublimeplus'),
                        'contain' => esc_html__('Contain', 'sublimeplus'),
                    ),
                    'required'   => array('bg_image', 'not_empty', ''),
                    'label'      => esc_html__('Size', 'sublimeplus'),
                    'class'      => 'field-half-left',
                    'css_format' => '-webkit-background-size: {{value}}; -moz-background-size: {{value}}; -o-background-size: {{value}}; background-size: {{value}};'
                ),
                array(
                    'name'       => 'bg_position',
                    'type'       => 'select',
                    'device_settings' => true,
                    'label'      => esc_html__('Position', 'sublimeplus'),
                    'required'   => array('bg_image', 'not_empty', ''),
                    'class'      => 'field-half-right',
                    'choices'    => array(
                        ''              => esc_html__('Default', 'sublimeplus'),
                        'center'        => esc_html__('Center', 'sublimeplus'),
                        'top left'      => esc_html__('Top Left', 'sublimeplus'),
                        'top right'     => esc_html__('Top Right', 'sublimeplus'),
                        'top center'    => esc_html__('Top Center', 'sublimeplus'),
                        'bottom left'   => esc_html__('Bottom Left', 'sublimeplus'),
                        'bottom center' => esc_html__('Bottom Center', 'sublimeplus'),
                        'bottom right'  => esc_html__('Bottom Right', 'sublimeplus'),
                    ),
                    'css_format' => 'background-position: {{value}};'
                ),
                array(
                    'name'       => 'bg_repeat',
                    'type'       => 'select',
                    'device_settings' => true,
                    'label'      => esc_html__('Repeat', 'sublimeplus'),
                    'class'      => 'field-half-left',
                    'required'   => array(
                        array('bg_image', 'not_empty', ''),
                    ),
                    'choices'    => array(
                        'repeat'    => esc_html__('Default', 'sublimeplus'),
                        'no-repeat' => esc_html__('No repeat', 'sublimeplus'),
                        'repeat-x'  => esc_html__('Repeat horizontal', 'sublimeplus'),
                        'repeat-y'  => esc_html__('Repeat vertical', 'sublimeplus'),
                    ),
                    'css_format' => 'background-repeat: {{value}};'
                ),

                array(
                    'name'       => 'bg_attachment',
                    'type'       => 'select',
                    'device_settings' => true,
                    'label'      => esc_html__('Attachment', 'sublimeplus'),
                    'class'      => 'field-half-right',
                    'required'   => array(
                        array('bg_image', 'not_empty', '')
                    ),
                    'choices'    => array(
                        ''       => esc_html__('Default', 'sublimeplus'),
                        'scroll' => esc_html__('Scroll', 'sublimeplus'),
                        'fixed'  => esc_html__('Fixed', 'sublimeplus')
                    ),
                    'css_format' => 'background-attachment: {{value}};'
                ),

                array(
                    'name'  => 'border_heading',
                    'type'  => 'heading',
                    'label' => esc_html__('Border', 'sublimeplus'),
                ),

                array(
                    'name'       => 'border_style',
                    'type'       => 'select',
                    'device_settings' => true,
                    'class'      => 'clear',
                    'label'      => esc_html__('Border Style', 'sublimeplus'),
                    'default'    => '',
                    'choices'    => array(
                        ''       => esc_html__('Default', 'sublimeplus'),
                        'none'   => esc_html__('None', 'sublimeplus'),
                        'solid'  => esc_html__('Solid', 'sublimeplus'),
                        'dotted' => esc_html__('Dotted', 'sublimeplus'),
                        'dashed' => esc_html__('Dashed', 'sublimeplus'),
                        'double' => esc_html__('Double', 'sublimeplus'),
                        'ridge'  => esc_html__('Ridge', 'sublimeplus'),
                        'inset'  => esc_html__('Inset', 'sublimeplus'),
                        'outset' => esc_html__('Outset', 'sublimeplus'),
                    ),
                    'css_format' => 'border-style: {{value}};',
                ),

                array(
                    'name'       => 'border_width',
                    'type'       => 'css_rule',
                    'device_settings' => true,
                    'label'      => esc_html__('Border Width', 'sublimeplus'),
                    'required'   => array(
                        array( 'border_style', '!=', 'none' ),
                        array( 'border_style', '!=', '' )
                    ),
                    'css_format' => array(
                        'top'    => 'border-top-width: {{value}};',
                        'right'  => 'border-right-width: {{value}};',
                        'bottom' => 'border-bottom-width: {{value}};',
                        'left'   => 'border-left-width: {{value}};'
                    ),
                ),
                array(
                    'name'       => 'border_color',
                    'type'       => 'color',
                    'device_settings' => true,
                    'label'      => esc_html__('Border Color', 'sublimeplus'),
                    'required'   => array(
                        array( 'border_style', '!=', 'none' ),
                        array( 'border_style', '!=', '' )
                    ),
                    'css_format' => 'border-color: {{value}};',
                ),

                array(
                    'name'       => 'border_radius',
                    'type'       => 'css_rule',
                    'device_settings' => true,
                    'label'      => esc_html__('Border Radius', 'sublimeplus'),
                    'css_format' => array(
                        'top'    => 'border-top-left-radius: {{value}};',
                        'right'  => 'border-top-right-radius: {{value}};',
                        'bottom' => 'border-bottom-right-radius: {{value}};',
                        'left'   => 'border-bottom-left-radius: {{value}};'
                    ),
                ),

                array(
                    'name'       => 'box_shadow',
                    'type'       => 'shadow',
                    'device_settings' => true,
                    'label'      => esc_html__('Box Shadow', 'sublimeplus'),
                    'css_format' => 'box-shadow: {{value}};',
                ),

            ),

            'hover_fields' => array(
                array(
                    'name'       => 'text_color',
                    'type'       => 'color',
                    'device_settings' => true,
                    'label'      => esc_html__('Color', 'sublimeplus'),
                    'css_format' => 'color: {{value}}; text-decoration-color: {{value}};'
                ),
                array(
                    'name'       => 'link_color',
                    'type'       => 'color',
                    'device_settings' => true,
                    'label'      => esc_html__('Link Color', 'sublimeplus'),
                    'css_format' => 'color: {{value}}; text-decoration-color: {{value}};'
                ),
                array(
                    'name'  => 'bg_heading',
                    'type'  => 'heading',
                    'label' => esc_html__('Background', 'sublimeplus'),
                ),
                array(
                    'name'       => 'bg_color',
                    'type'       => 'color',
                    'device_settings' => true,
                    'label'      => esc_html__('Background Color', 'sublimeplus'),
                    'css_format' => 'background-color: {{value}};'
                ),
                array(
                    'name'  => 'border_heading',
                    'type'  => 'heading',
                    'label' => esc_html__('Border', 'sublimeplus'),
                ),
                array(
                    'name'       => 'border_style',
                    'type'       => 'select',
                    'device_settings' => true,
                    'label'      => esc_html__('Border Style', 'sublimeplus'),
                    'default'    => '',
                    'choices'    => array(
                        ''       => esc_html__('Default', 'sublimeplus'),
                        'none'   => esc_html__('None', 'sublimeplus'),
                        'solid'  => esc_html__('Solid', 'sublimeplus'),
                        'dotted' => esc_html__('Dotted', 'sublimeplus'),
                        'dashed' => esc_html__('Dashed', 'sublimeplus'),
                        'double' => esc_html__('Double', 'sublimeplus'),
                        'ridge'  => esc_html__('Ridge', 'sublimeplus'),
                        'inset'  => esc_html__('Inset', 'sublimeplus'),
                        'outset' => esc_html__('Outset', 'sublimeplus'),
                    ),
                    'css_format' => 'border-style: {{value}};',
                ),
                array(
                    'name'       => 'border_width',
                    'type'       => 'css_rule',
                    'device_settings' => true,
                    'label'      => esc_html__('Border Width', 'sublimeplus'),
                    'required'   => array('border_style', '!=', 'none'),
                    'css_format' => array(
                        'top'    => 'border-top-width: {{value}};',
                        'right'  => 'border-right-width: {{value}};',
                        'bottom' => 'border-bottom-width: {{value}};',
                        'left'   => 'border-left-width: {{value}};'
                    ),
                ),
                array(
                    'name'       => 'border_color',
                    'type'       => 'color',
                    'device_settings' => true,
                    'label'      => esc_html__('Border Color', 'sublimeplus'),
                    'required'   => array('border_style', '!=', 'none'),
                    'css_format' => 'border-color: {{value}};',
                ),
                array(
                    'name'       => 'border_radius',
                    'type'       => 'css_rule',
                    'device_settings' => true,
                    'label'      => esc_html__('Border Radius', 'sublimeplus'),
                    'css_format' => array(
                        'top'    => 'border-top-left-radius: {{value}};',
                        'right'  => 'border-top-right-radius: {{value}};',
                        'bottom' => 'border-bottom-right-radius: {{value}};',
                        'left'   => 'border-bottom-left-radius: {{value}};'
                    ),
                ),
                array(
                    'name'       => 'box_shadow',
                    'type'       => 'shadow',
                    'device_settings' => true,
                    'label'      => esc_html__('Box Shadow', 'sublimeplus'),
                    'css_format' => 'box-shadow: {{value}};',
                ),

            ),


        );

        return apply_filters('zoo/get_styling_config', $fields);
    }

    /**
     * Register customize options
     *
     * @internal  Used as a callback.
     *
     * @param  object  $wp_customize
     */
    public function _register(WP_Customize_Manager $wp_customize)
    {
        $this->wp_customize = $wp_customize;

        // Print controls' template.
        foreach (self::SUPPORT_CONTROL_TYPES as $ctrl) {
            if ($ctrl === 'radio_group' || $ctrl === 'image_select') {
                continue;
            }
            $fname = str_replace('_', '-', $ctrl);
            $type  = str_replace('_', ' ', $ctrl);
            $cname = 'Sublimeplus_Customize_Control_' . str_replace(' ', '_', ucfirst($type));
            require SUBLIMEPLUS_DIR . 'core/customize/controls/class-sublimeplus-customize-control-' . $fname . '.php';
            if (method_exists($cname, 'control_template')) {
                add_action('customize_controls_print_footer_scripts', [$cname, 'control_template']);
            }
        }

        do_action('Sublimeplus_customize_before_register', $this);

        // Register panels.
        foreach ($this->panels as $panel_id => $panel_args) {
            $wp_customize->add_panel(new WP_Customize_Panel($wp_customize, $panel_id, $panel_args));
        }

        // Register sections.
        foreach ($this->sections as $sections_id => $sections_args) {
            $wp_customize->add_section(new WP_Customize_Section($wp_customize, $sections_id, $sections_args));
        }

        $config = Sublimeplus_customize_get_all_config($wp_customize);

        foreach ($config as $args) {
            $this->add_field($args);
        }

        $wp_customize->get_section('title_tagline')->panel = 'header_settings';
        $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
        // add selective refresh
        $wp_customize->get_setting('custom_logo')->transport = 'postMessage';
        $wp_customize->get_setting('blogname')->transport = 'postMessage';
        $wp_customize->get_setting('blogdescription')->transport = 'postMessage';

        foreach ($this->selective_settings as $cb => $settings) {
            reset($settings['settings']);
            if ($cb == 'Sublimeplus_Builder_Item_Logo__render') {
                $settings['settings'][] = 'custom_logo';
                $settings['settings'][] = 'blogname';
                $settings['settings'][] = 'blogdescription';
            }
            $settings = apply_filters($cb, $settings);
            $wp_customize->selective_refresh->add_partial($cb, $settings);
        }

        // For live CSS
        $wp_customize->add_setting('Sublimeplus__css', [
            'default'           => '',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'Sublimeplus_sanitize_css_input',
        ]);

        do_action('Sublimeplus_customize_after_register', $this);
    }
}
Sublimeplus_Customizer::get_instance();
