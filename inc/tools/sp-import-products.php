<?php
/**
 * One-click product importer.
 * Tools → Import Products → click the button.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('admin_menu', function () {
    add_management_page('Import Products', 'Import Products', 'manage_options', 'sp-import-products', 'sp_importer_render');
});

function sp_importer_render() {
    if (!current_user_can('manage_options')) wp_die('Forbidden');

    $log  = [];
    $done = false;

    if (isset($_POST['sp_do_import']) && check_admin_referer('sp_import_run')) {
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $log  = sp_importer_run();
        $done = true;
    }
    ?>
    <div class="wrap" style="max-width:720px">
        <h1>📦 Import Products</h1>
        <p style="color:#64748b">Imports 6 precast products with specs, descriptions, categories, and images — directly into <strong>sp_product</strong> posts.</p>

        <?php if ($done) : ?>
            <div class="notice notice-success inline" style="margin:12px 0"><p>✅ Import complete — <a href="<?php echo esc_url(admin_url('edit.php?post_type=sp_product')); ?>">view products</a></p></div>
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:14px 18px;font-family:monospace;font-size:12px;line-height:1.9;max-height:460px;overflow-y:auto">
                <?php foreach ($log as $line) :
                    $color = str_starts_with($line, 'ERR') ? '#dc2626'
                           : (str_starts_with($line, 'SKIP') ? '#94a3b8'
                           : (str_starts_with($line, '  ✗') ? '#f97316'
                           : (str_starts_with($line, '  ✓') ? '#16a34a' : '#1e293b')));
                ?>
                <div style="color:<?php echo $color; ?>"><?php echo esc_html($line); ?></div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="notice notice-info inline" style="margin:12px 0"><p>Safe to run multiple times — existing posts are skipped, already-downloaded images are reused.</p></div>
            <form method="post" style="margin-top:16px">
                <?php wp_nonce_field('sp_import_run'); ?>
                <input type="hidden" name="sp_do_import" value="1">
                <button type="submit" class="button button-primary" style="height:44px;padding:0 28px;font-size:15px;font-weight:700">
                    🚀 Import All Products
                </button>
            </form>
        <?php endif; ?>
    </div>
    <?php
}

// ─── Product data ─────────────────────────────────────────────────────────────

function sp_importer_data(): array {
    $B  = 'https://precastuae.ae';
    $TI = 'https://cdn.jsdelivr.net/npm/@tabler/icons@3.28.1/icons/outline/';

    return [

        [
            'slug'     => 'jersey-barrier',
            'title'    => 'RTA Jersey Barriers (1m, 2m & 3m)',
            'excerpt'  => 'Factory-cast concrete road barriers with K-rail profile, interlocking joints, and rapid UAE delivery.',
            'content'  => '<p>Our RTA-approved Jersey Barriers are manufactured to the K-rail profile standard and comply with all UAE road authority specifications. Available in 1000 mm, 2000 mm, and 3000 mm lengths, they feature precision interlocking joints for continuous barrier lines with no gaps.</p><p>Each barrier is cast from C30 grade concrete with as-cast finish. Forklift and crane lifting pockets are cast-in on all units. Stock is maintained in Sharjah for same-week delivery across the UAE.</p><h3>Applications</h3><ul><li>Highway central reservation and lane separation</li><li>Construction zone traffic management</li><li>Temporary and permanent road diversions</li><li>Bridge parapet protection</li></ul>',
            'cats'     => ['Road Safety'],
            'certs'    => 'RTA Approved, ICV Certified',
            'material' => 'C30 Grade Concrete',
            'finish'   => 'As-cast concrete finish',
            'icon'     => $B . '/icons/icon_barrier.svg',
            'images'   => [
                $B . '/images/barrier_stockpile_hu_c2f8772c5563f12.webp',
                $B . '/images/barrier_slide_2_hu_d6aa501998fc4774.webp',
                $B . '/images/barrier_slide_3_hu_d25108439516b5fb.webp',
            ],
            'specs' => [
                ['Barrier Type',   'Jersey / K-Rail',           $TI . 'road-sign.svg'],
                ['Length Options', '1000mm / 2000mm / 3000mm',  $TI . 'ruler-2.svg'],
                ['Height',         '810mm',                      $TI . 'arrows-vertical.svg'],
                ['Base Width',     '610mm',                      $TI . 'arrows-horizontal.svg'],
                ['Weight (1m)',    '1,600 kg',                   $TI . 'weight.svg'],
                ['Weight (2m)',    '2,400 kg',                   $TI . 'weight.svg'],
                ['Concrete Grade', 'C30',                        $TI . 'cube.svg'],
            ],
        ],

        [
            'slug'     => 'precast-bunker',
            'title'    => 'Precast Bunker, Shelter & Box Culvert Systems',
            'excerpt'  => 'Factory-cast bunker shells, box culverts, C-Channels, T-Walls, and U-Channels for underground shelter, utility, and protective construction.',
            'content'  => '<p>Our precast bunker and shelter system delivers turnkey underground and above-ground protective structures. Each component is manufactured to project drawings and dispatched with installation guide markings.</p><p>Standard concrete is C40/50 with UHPC available on request for blast-resistant requirements. All units can be supplied with pre-cast lifting inserts and cast-in conduit runs.</p><h3>Available Components</h3><ul><li>Bunker Shell (single or double skin)</li><li>Box Culvert (various openings)</li><li>C-Channel and U-Channel drainage</li><li>T-Wall retaining system</li><li>Roof slabs and cover slabs</li></ul>',
            'cats'     => ['Structural Systems'],
            'certs'    => 'ISO 9001:2015, ICV Certified',
            'material' => 'C40/50 Grade Concrete (UHPC on request)',
            'finish'   => 'As-cast concrete finish',
            'icon'     => $B . '/icons/icon_bunker.svg',
            'images'   => [
                $B . '/images/bunker_2026_main_hu_c6a5923a44238431.webp',
                $B . '/images/bunker_2026_alt_hu_aedd13837f30d6b3.webp',
                $B . '/images/bunker_slide_3_hu_6cfe3ad7ac1e377d.webp',
            ],
            'specs' => [
                ['System',                'Bunker Shell / C-Channel / T-Wall / U-Channel', $TI . 'building-fortress.svg'],
                ['Concrete Grade',        'C40/50 / UHPC on request',                      $TI . 'cube.svg'],
                ['Dimensions',            'Custom to project drawings',                     $TI . 'ruler-2.svg'],
                ['Wall / Slab Thickness', '150mm to 250mm typical',                        $TI . 'layers-intersect.svg'],
                ['Reinforcement',         'BS4449 Grade 460B rebar',                       $TI . 'grid-dots.svg'],
            ],
        ],

        [
            'slug'     => 'wheel-stopper',
            'title'    => 'Heavy-Duty Parking Wheel Stoppers',
            'excerpt'  => '120mm profile concrete wheel stops designed to safeguard property and organise parking bays.',
            'content'  => '<p>Our precast concrete wheel stoppers are manufactured to a proven 120mm profile that safely halts vehicle tyres before they reach kerbs, walls, or pedestrian areas. Each unit is cast from high-density concrete with a non-slip aggregate surface finish.</p><p>Standard lengths of 1.8m and 2.0m suit most parking bay widths. Each unit is pre-drilled for two rebar spike or bolt-down fixings. Yellow paint marking is available on request.</p><h3>Applications</h3><ul><li>Commercial and residential car parks</li><li>Loading bays and warehouses</li><li>Petrol stations and drive-throughs</li><li>Villa compounds and hospitality</li></ul>',
            'cats'     => ['Parking Solutions'],
            'certs'    => 'DM Approved',
            'material' => 'C25 Grade Concrete',
            'finish'   => 'Exposed aggregate, yellow marking optional',
            'icon'     => $B . '/icons/icon_stopper.svg',
            'images'   => [
                $B . '/images/stopper_installed_hu_1c46aea27f526b01.webp',
                $B . '/images/stopper_slide_2_hu_32e6427ee1ddc03b.webp',
                $B . '/images/stopper_slide_3_hu_ab7fc3a19363dbf3.webp',
            ],
            'specs' => [
                ['Common Name',     'Car Stop / Curb / Wheel Chock', $TI . 'car.svg'],
                ['Standard Lengths','1.8m / 2.0m',                   $TI . 'ruler-2.svg'],
                ['Height',          '100mm / 120mm',                  $TI . 'arrows-vertical.svg'],
                ['Width',           '200mm',                          $TI . 'arrows-horizontal.svg'],
                ['Fixing Method',   '2x Rebar Spike / Bolt-Down',    $TI . 'tool.svg'],
                ['Concrete Grade',  'C25',                            $TI . 'cube.svg'],
            ],
        ],

        [
            'slug'     => 'masonry-block',
            'title'    => 'High-Strength Concrete Masonry Blocks',
            'excerpt'  => 'Load-bearing solid and hollow concrete blocks for structural wall construction.',
            'content'  => '<p>Our concrete masonry blocks are produced on automated hydraulic block machines to tight dimensional tolerances. Available in solid and hollow configurations for load-bearing walls, partition walls, retaining structures, and boundary walls.</p><p>Standard 400×200×200mm format with 100mm, 150mm, and 200mm widths available. Compressive strength grades 7.5N, 15N, and 20N cover light residential to heavy commercial applications.</p><h3>Block Types</h3><ul><li>Solid dense block — boundary and retaining walls</li><li>Hollow two-core block — load-bearing partitions</li><li>Hollow three-core block — insulated cavity walls</li><li>Half blocks and specials for corners and openings</li></ul>',
            'cats'     => ['Building Materials'],
            'certs'    => 'ESMA Certified, ICV Certified',
            'material' => 'Dense Aggregate Concrete',
            'finish'   => 'Machine-pressed smooth face',
            'icon'     => $B . '/icons/icon_block.svg',
            'images'   => [
                $B . '/images/block_pallets_hu_42ef7d7a61cd9245.webp',
                $B . '/images/block_slide_2_hu_227a9ff28e6bcca.webp',
                $B . '/images/block_slide_3_hu_6a72150325c7020a.webp',
            ],
            'specs' => [
                ['Standard Size',    '400 × 200 × 200 mm',    $TI . 'cube.svg'],
                ['Available Widths', '100mm / 150mm / 200mm', $TI . 'arrows-horizontal.svg'],
                ['Types',            'Hollow / Solid',         $TI . 'layout-grid.svg'],
                ['Strength Grades',  '7.5N / 15N / 20N',      $TI . 'hammer.svg'],
                ['Density',          'Normal / Lightweight',   $TI . 'scale.svg'],
                ['Pallet Quantity',  '72 – 120 blocks',        $TI . 'package.svg'],
            ],
        ],

        [
            'slug'     => 'hoarding-block',
            'title'    => 'DM-Compliant Hoarding Blocks',
            'excerpt'  => 'High-stability concrete counterweights for site perimeter fencing and wind-load protection.',
            'content'  => '<p>Our hoarding base blocks are cast to Dubai Municipality (DM) specifications and provide the ballast mass required for free-standing hoarding panels in UAE wind conditions. The blocks accept standard 48mm and 60mm hoarding poles through precision-cast holes.</p><p>Standard weight options of 600kg and 1000kg match the wind-load requirements for different panel heights and exposure categories. Painted yellow for high-visibility on active construction sites.</p><h3>Applications</h3><ul><li>Construction site perimeter hoardings</li><li>Temporary event enclosures</li><li>Security fencing counterweights</li><li>Plant and equipment yard boundaries</li></ul>',
            'cats'     => ['Site Safety'],
            'certs'    => 'DM Compliant, RTA Approved',
            'material' => 'C25 Grade Concrete',
            'finish'   => 'Yellow painted',
            'icon'     => $B . '/icons/icon_hoarding.svg',
            'images'   => [
                $B . '/images/hoarding_slide_1_hu_5cadc1f4e76901c6.webp',
                $B . '/images/hoarding_slide_2_hu_4e633d0611b3f983.webp',
                $B . '/images/hoarding_slide_3_hu_f02ed68089276a31.webp',
            ],
            'specs' => [
                ['Market Name',    'Fence Footing / Hoarding Base', $TI . 'fence.svg'],
                ['Standard Weight','600 kg / 1000 kg',              $TI . 'weight.svg'],
                ['Dimensions',     '1000 × 500 × 500 mm',          $TI . 'dimensions.svg'],
                ['Pole Hole Size', 'Dia 48mm / 60mm',               $TI . 'circle-dashed.svg'],
                ['Concrete Grade', 'C25',                            $TI . 'cube.svg'],
            ],
        ],

        [
            'slug'     => 'plastic-barrier',
            'title'    => 'RTA-Approved Water-Filled Plastic Barriers',
            'excerpt'  => 'UV-stabilised HDPE barriers for agile traffic diversion and crowd control.',
            'content'  => '<p>Our water-filled plastic road barriers are manufactured from UV-stabilised HDPE and are approved by the Roads and Transport Authority (RTA). Filled with water on-site, they achieve up to 500kg ballast mass per unit. Units interlock end-to-end via integrated connectors, creating a continuous barrier line.</p><p>Available in red/white and full orange for RTA-specified lane configurations. Forklift pockets are moulded-in for rapid deployment.</p><h3>Applications</h3><ul><li>Highway lane separation and contra-flow</li><li>Work zone protection</li><li>Event crowd management</li><li>Temporary pedestrian channelling</li></ul>',
            'cats'     => ['Traffic Management', 'Road Safety'],
            'certs'    => 'RTA Approved',
            'material' => 'UV-Stabilised HDPE Plastic',
            'finish'   => 'Red/White or Orange (RTA standard)',
            'icon'     => $B . '/icons/icon_plastic.svg',
            'images'   => [
                $B . '/images/plastic_slide_1_hu_553a2f6db1b5e2e0.webp',
                $B . '/images/plastic_slide_2_hu_daa1b5b84b25546c.webp',
                $B . '/images/plastic_slide_3_hu_e3f11e8759cbb496.webp',
            ],
            'specs' => [
                ['Type',            'Interlocking Road Separator', $TI . 'barrier-block.svg'],
                ['Dimensions',      '2000L × 800H × 400W mm',     $TI . 'dimensions.svg'],
                ['Weight (Empty)',  '18 kg – 22 kg',               $TI . 'feather.svg'],
                ['Weight (Filled)', 'Up to 500 kg',                $TI . 'weight.svg'],
                ['Material',        'UV-Stabilised HDPE',          $TI . 'box.svg'],
            ],
        ],
    ];
}

// ─── Run import ───────────────────────────────────────────────────────────────

function sp_importer_run(): array {
    $log      = [];
    $products = sp_importer_data();

    // Ensure categories
    $cat_ids = [];
    $all_cats = array_unique(array_merge(...array_column($products, 'cats')));
    foreach ($all_cats as $name) {
        $slug = sanitize_title($name);
        $term = term_exists($slug, 'sp_product_cat') ?: wp_insert_term($name, 'sp_product_cat', ['slug' => $slug]);
        if (!is_wp_error($term)) {
            $cat_ids[$name] = (int)($term['term_id'] ?? $term);
            $log[] = 'Category: ' . $name;
        }
    }

    foreach ($products as $p) {
        // Skip duplicates
        if (get_page_by_path($p['slug'], OBJECT, 'sp_product')) {
            $log[] = 'SKIP (exists): ' . $p['title'];
            continue;
        }

        $post_id = wp_insert_post([
            'post_type'    => 'sp_product',
            'post_status'  => 'publish',
            'post_title'   => $p['title'],
            'post_name'    => $p['slug'],
            'post_excerpt' => $p['excerpt'],
            'post_content' => $p['content'],
            'menu_order'   => 0,
        ], true);

        if (is_wp_error($post_id)) {
            $log[] = 'ERROR: ' . $p['title'] . ' — ' . $post_id->get_error_message();
            continue;
        }
        $log[] = '── ' . $p['title'];

        // Categories
        $tids = array_filter(array_map(fn($c) => $cat_ids[$c] ?? 0, $p['cats']));
        if ($tids) wp_set_object_terms($post_id, array_values($tids), 'sp_product_cat');

        // Text meta
        update_post_meta($post_id, '_sp_product_certifications', $p['certs']);
        update_post_meta($post_id, '_sp_product_material',       $p['material']);
        update_post_meta($post_id, '_sp_product_finish',         $p['finish']);
        update_post_meta($post_id, '_sp_product_specs',          wp_json_encode($p['specs']));

        // Icon
        $icon_id = sp_dl($p['icon'], $post_id, 'icon');
        if ($icon_id) {
            update_post_meta($post_id, '_sp_product_icon', $icon_id);
            $log[] = '  ✓ Icon';
        } else {
            $log[] = '  ✗ Icon (blocked — upload manually)';
        }

        // Gallery + featured image
        $gids = [];
        foreach ($p['images'] as $i => $url) {
            $id = sp_dl($url, $post_id, 'image ' . ($i + 1));
            if ($id) {
                $gids[] = $id;
                if ($i === 0) set_post_thumbnail($post_id, $id);
                $log[] = '  ✓ Image ' . ($i + 1);
            } else {
                $log[] = '  ✗ Image ' . ($i + 1) . ' (blocked — upload manually)';
            }
        }
        if ($gids) update_post_meta($post_id, '_sp_product_gallery', implode(',', $gids));
    }

    return $log;
}

// ─── Sideload helper ──────────────────────────────────────────────────────────

function sp_dl(string $url, int $post_id, string $label): int {
    if (!$url) return 0;

    // Return existing if already downloaded
    $existing = get_posts([
        'post_type' => 'attachment', 'posts_per_page' => 1, 'fields' => 'ids',
        'meta_key'  => '_sp_src', 'meta_value' => $url,
    ]);
    if ($existing) return (int)$existing[0];

    // Download with browser-like headers to bypass basic bot blocks
    add_filter('http_request_args', 'sp_dl_headers', 10, 2);
    $tmp = download_url($url, 40);
    remove_filter('http_request_args', 'sp_dl_headers', 10);

    if (is_wp_error($tmp)) return 0;

    $id = media_handle_sideload(
        ['name' => basename(parse_url($url, PHP_URL_PATH)), 'tmp_name' => $tmp],
        $post_id, $label
    );
    @unlink($tmp);

    if (is_wp_error($id)) return 0;
    update_post_meta((int)$id, '_sp_src', $url);
    return (int)$id;
}

function sp_dl_headers(array $args): array {
    $args['user-agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36';
    $args['headers']['Referer'] = 'https://precastuae.ae/';
    $args['headers']['Accept']  = 'image/webp,image/avif,image/*,*/*;q=0.8';
    return $args;
}
