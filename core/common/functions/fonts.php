<?php
/**
 * Fonts functionality
 *
 * @package  SublimePulse
 * @author   SublimePulse
 * @link     https://bitandbytelab.com/
 *
 */

/**
 * Get websafe fonts
 *
 * @return  array
 */
function Sublimeplus_get_websafe_fonts()
{
    return apply_filters('Sublimeplus_default_web_safe_fonts', [
        'Times' => [
            'family' => 'Times',
            'category' => 'serif'
        ],
        'Georgia' => [
            'family' => 'Georgia',
            'category' => 'serif'
        ],
        'Palatino' => [
            'family' => 'Palatino',
            'category' => 'serif'
        ],
        'Tahoma' => [
            'family' => 'Tahoma',
            'category' => 'serif'
        ],
        'Verdana' => [
            'family' => 'Tahoma',
            'category' => 'serif'
        ],
        'Impact' => [
            'family' => 'Impact',
            'category' => 'serif'
        ],
        'Arial' => [
            'family' => 'Arial',
            'category' => 'sans-serif'
        ],
        'Helvetica' => [
            'family' => 'Helvetica',
            'category' => 'sans-serif'
        ],
        'Monaco' => [
            'family' => 'Monaco',
            'category' => 'sans-serif'
        ],
        'Courier' => [
            'family' => 'Arial',
            'category' => 'sans-serif'
        ]
    ]);
}

/**
 * Get supported Google fonts
 *
 * @return  array
 */
function Sublimeplus_get_google_fonts()
{
    global $wp_filesystem;

    static $fonts = null;

    if (null === $fonts) {
        $file_path = SUBLIMEPLUS_DIR . 'core/assets/fonts/google-fonts.json';
        if (is_object($wp_filesystem) && method_exists($wp_filesystem, 'get_contents')) {
            $file = $wp_filesystem->get_contents($file_path);
        } else {
            $file = file_exists($file_path) ? file_get_contents($file_path) : false;
        }

        $fonts = $file ? json_decode($file, true) : [];
    }

    $fonts = is_array($fonts) ? $fonts : [];

    return apply_filters('Sublimeplus_google_fonts', $fonts);
}

/**
 * Get fonts' URL
 *
 * @return  string
 */
function Sublimeplus_get_google_fonts_url(array $fonts, array $variants = [], array $subsets = [])
{
    if (!$fonts) return '';

    $s = '';
    $url = 'https://fonts.googleapis.com/css?family=';

    foreach ($fonts as $font) {
        if ($s) {
            $s .= '|';
        }
        $s .= str_replace(' ', '+', $font);
        $v = [];
        if (isset($variants[$font])) {
            foreach ($variants[$font] as $variant) {
                if ($variant != 'regular') {
                    switch ($variant) {
                        case 'italic':
                            $v[$variant] = '400i';
                            break;
                        default:
                            $v[$variant] = str_replace('italic', 'i', $variant);
                    }
                } else {
                    $v[$variant] = '400';
                }
            }
        }
        if (!empty($v)) {
            $s .= ':' . join(',', $v);
        }
    }

    $url .= $s;

    if (!empty($subsets)) {
        $url .= '&subset=' . join(',', $subsets);
    }

    $url .= '&display=swap';

    return $url;
}
