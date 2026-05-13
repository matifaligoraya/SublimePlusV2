<?php
/**
 * One-shot product importer — creates sp_product posts from precastuae.ae data.
 *
 * HOW TO USE:
 *   1. Visit  /wp-admin/admin.php?page=sp-import-products
 *   2. Click "Run Import"
 *   3. Delete or comment-out the require line in inc/init.php when done.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('admin_menu', function () {
    add_management_page(
        'Import Products',
        'Import Products',
        'manage_options',
        'sp-import-products',
        'sp_import_products_page'
    );
});

function sp_import_products_page() {
    if (!current_user_can('manage_options')) wp_die('Forbidden');

    $done = false;
    $log  = [];

    if (isset($_POST['sp_do_import']) && check_admin_referer('sp_import_nonce')) {
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $log  = sp_run_import();
        $done = true;
    }
    ?>
    <div class="wrap">
        <h1>Import Products from precastuae.ae</h1>
        <?php if ($done) : ?>
            <div class="notice notice-success"><p>Import complete.</p></div>
            <ul style="font-family:monospace;font-size:13px;background:#f6f7f7;padding:16px;border-radius:6px;max-height:420px;overflow-y:auto">
                <?php foreach ($log as $line) : ?>
                <li><?php echo esc_html($line); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>This will create <strong>6 sp_product posts</strong> with categories, specs, and sideloaded images.</p>
            <p><strong>Safe to run multiple times</strong> — skips posts whose slug already exists.</p>
            <form method="post">
                <?php wp_nonce_field('sp_import_nonce'); ?>
                <input type="hidden" name="sp_do_import" value="1">
                <?php submit_button('Run Import', 'primary large'); ?>
            </form>
        <?php endif; ?>
    </div>
    <?php
}

// ─── Import data ──────────────────────────────────────────────────────────────

function sp_run_import(): array {
    $log  = [];
    $base = 'https://precastuae.ae';
    $ti   = 'https://cdn.jsdelivr.net/npm/@tabler/icons@3.28.1/icons/outline/';

    // ── Category map ──────────────────────────────────────────────────────────
    $cat_ids = [];
    foreach ([
        'road-safety'        => 'Road Safety',
        'structural-systems' => 'Structural Systems',
        'parking-solutions'  => 'Parking Solutions',
        'building-materials' => 'Building Materials',
        'site-safety'        => 'Site Safety',
        'traffic-management' => 'Traffic Management',
    ] as $slug => $name) {
        $term = term_exists($slug, 'sp_product_cat');
        if (!$term) {
            $term = wp_insert_term($name, 'sp_product_cat', ['slug' => $slug]);
        }
        $cat_ids[$slug] = is_array($term) ? (int) $term['term_id'] : (int) $term;
        $log[] = "Category: $name (ID {$cat_ids[$slug]})";
    }

    // ── Product definitions ───────────────────────────────────────────────────
    $products = [

        // 1 — Jersey Barrier
        [
            'slug'     => 'jersey-barrier',
            'title'    => 'RTA Jersey Barriers (1m, 2m & 3m)',
            'excerpt'  => 'Factory-cast concrete road barriers with K-rail profile, interlocking joints, and rapid UAE delivery.',
            'content'  => '<p>Our RTA-approved Jersey Barriers are manufactured to the K-rail profile standard and comply with all UAE road authority specifications. Available in 1000mm, 2000mm, and 3000mm lengths, they feature precision interlocking joints for continuous barrier lines with no gaps.</p><p>Each barrier is cast from C30 grade concrete with exposed aggregate finish. Forklift and crane lifting pockets are cast-in on all units. Stock is maintained in Sharjah for same-week delivery across the UAE.</p><h3>Applications</h3><ul><li>Highway central reservation and lane separation</li><li>Construction zone traffic management</li><li>Temporary and permanent road diversions</li><li>Bridge parapet protection</li></ul>',
            'cats'     => ['road-safety'],
            'certs'    => 'RTA Approved, ICV Certified',
            'material' => 'C30 Grade Concrete',
            'finish'   => 'As-cast concrete finish',
            'icon'     => '/icons/icon_barrier.svg',
            'images'   => [
                '/images/barrier_stockpile_hu_c2f8772c5563f12.webp',
                '/images/barrier_slide_2_hu_d6aa501998fc4774.webp',
                '/images/barrier_slide_3_hu_d25108439516b5fb.webp',
            ],
            'specs'    => [
                ['Barrier Type',    'Jersey / K-Rail',              $ti.'road-sign.svg'],
                ['Length Options',  '1000mm / 2000mm / 3000mm',     $ti.'ruler-2.svg'],
                ['Height',          '810mm',                         $ti.'arrows-vertical.svg'],
                ['Base Width',      '610mm',                         $ti.'arrows-horizontal.svg'],
                ['Weight (1m)',     '1,600 kg',                      $ti.'weight.svg'],
                ['Weight (2m)',     '2,400 kg',                      $ti.'weight.svg'],
                ['Concrete Grade',  'C30',                           $ti.'cube.svg'],
                ['Certification',   'RTA Approved',                  $ti.'certificate.svg'],
            ],
        ],

        // 2 — Precast Bunker
        [
            'slug'     => 'precast-bunker',
            'title'    => 'Precast Bunker, Shelter & Box Culvert Systems',
            'excerpt'  => 'Factory-cast bunker shells, box culverts, C-Channels, T-Walls, and U-Channels for underground shelter, utility, and protective construction.',
            'content'  => '<p>Our precast bunker and shelter system delivers turnkey underground and above-ground protective structures. Each component — bunker shell, roof slab, box culvert, C-Channel, T-Wall, and U-Channel — is manufactured to project drawings and dispatched with installation guide markings.</p><p>Standard concrete is C40/50 with UHPC available on request for blast-resistant requirements. All units can be supplied with pre-cast lifting inserts, shear connectors, and cast-in conduit runs.</p><h3>Available Components</h3><ul><li>Bunker Shell (single or double skin)</li><li>Box Culvert (various openings)</li><li>C-Channel and U-Channel drainage</li><li>T-Wall retaining system</li><li>Roof slabs and cover slabs</li></ul>',
            'cats'     => ['structural-systems'],
            'certs'    => 'ISO 9001:2015, ICV Certified',
            'material' => 'C40/50 Grade Concrete (UHPC on request)',
            'finish'   => 'As-cast concrete finish',
            'icon'     => '/icons/icon_bunker.svg',
            'images'   => [
                '/images/bunker_2026_main_hu_c6a5923a44238431.webp',
                '/images/bunker_2026_alt_hu_aedd13837f30d6b3.webp',
                '/images/bunker_slide_3_hu_6cfe3ad7ac1e377d.webp',
            ],
            'specs'    => [
                ['System',               'Bunker Shell / C-Channel / T-Wall / U-Channel', $ti.'building-fortress.svg'],
                ['Concrete Grade',       'C40/50 / UHPC on request',                      $ti.'box.svg'],
                ['Dimensions',           'Custom to project drawings',                     $ti.'ruler-2.svg'],
                ['Wall / Slab Thickness','150mm to 250mm typical',                         $ti.'layers-intersect.svg'],
                ['Reinforcement',        'BS4449 Grade 460B rebar',                        $ti.'grid-dots.svg'],
                ['Delivery',             'UAE-wide, project schedule',                     $ti.'truck.svg'],
            ],
        ],

        // 3 — Wheel Stopper
        [
            'slug'     => 'wheel-stopper',
            'title'    => 'Heavy-Duty Parking Wheel Stoppers',
            'excerpt'  => '120mm profile concrete wheel stops designed to safeguard property and organise parking bays.',
            'content'  => '<p>Our precast concrete wheel stoppers are manufactured to a proven 120mm profile that safely halts vehicle tyres before they reach kerbs, walls, or pedestrian areas. Each unit is cast from high-density concrete with a non-slip aggregate surface finish.</p><p>Standard lengths of 1.8m and 2.0m suit most parking bay widths. Each unit is pre-drilled for two rebar spike or bolt-down fixings. Yellow paint marking is available on request for high-visibility installations.</p><h3>Applications</h3><ul><li>Commercial and residential car parks</li><li>Loading bays and warehouses</li><li>Petrol stations and drive-throughs</li><li>Villa compounds and hospitality</li></ul>',
            'cats'     => ['parking-solutions'],
            'certs'    => 'DM Approved',
            'material' => 'C25 Grade Concrete',
            'finish'   => 'Exposed aggregate, yellow marking optional',
            'icon'     => '/icons/icon_stopper.svg',
            'images'   => [
                '/images/stopper_installed_hu_1c46aea27f526b01.webp',
                '/images/stopper_slide_2_hu_32e6427ee1ddc03b.webp',
                '/images/stopper_slide_3_hu_ab7fc3a19363dbf3.webp',
            ],
            'specs'    => [
                ['Common Name',     'Car Stop / Curb / Wheel Chock',    $ti.'car.svg'],
                ['Standard Lengths','1.8m / 2.0m',                      $ti.'ruler-2.svg'],
                ['Height',         '100mm / 120mm',                     $ti.'arrows-vertical.svg'],
                ['Width',          '200mm',                              $ti.'arrows-horizontal.svg'],
                ['Fixing Method',  '2x Rebar Spike / Bolt-Down',        $ti.'tool.svg'],
                ['Concrete Grade', 'C25',                                $ti.'cube.svg'],
            ],
        ],

        // 4 — Masonry Block
        [
            'slug'     => 'masonry-block',
            'title'    => 'High-Strength Concrete Masonry Blocks',
            'excerpt'  => 'Load-bearing solid and hollow concrete blocks for structural wall construction.',
            'content'  => '<p>Our concrete masonry blocks are produced on automated hydraulic block machines to tight dimensional tolerances. Available in solid and hollow configurations, they are suited for load-bearing walls, partition walls, retaining structures, and boundary walls.</p><p>Produced in standard 400x200x200mm format, with 100mm, 150mm, and 200mm widths available. Compressive strength grades 7.5N, 15N, and 20N cover light residential to heavy commercial applications. Both normal and lightweight (autoclaved aerated) densities are stocked.</p><h3>Block Types</h3><ul><li>Solid dense block — boundary and retaining walls</li><li>Hollow two-core block — load-bearing partitions</li><li>Hollow three-core block — insulated cavity walls</li><li>Half blocks and specials for corners and openings</li></ul>',
            'cats'     => ['building-materials'],
            'certs'    => 'ESMA Certified, ICV Certified',
            'material' => 'Dense Aggregate Concrete',
            'finish'   => 'Machine-pressed smooth face',
            'icon'     => '/icons/icon_block.svg',
            'images'   => [
                '/images/block_pallets_hu_42ef7d7a61cd9245.webp',
                '/images/block_slide_2_hu_227a9ff28e6bcca.webp',
                '/images/block_slide_3_hu_6a72150325c7020a.webp',
            ],
            'specs'    => [
                ['Standard Size',   '400 x 200 x 200 mm',           $ti.'cube.svg'],
                ['Available Widths','100mm / 150mm / 200mm',         $ti.'arrows-horizontal.svg'],
                ['Types',           'Hollow / Solid',                 $ti.'layout-grid.svg'],
                ['Strength Grades', '7.5N / 15N / 20N',              $ti.'hammer.svg'],
                ['Density',         'Normal / Lightweight',           $ti.'scale.svg'],
                ['Pallet Quantity', '72 – 120 blocks',               $ti.'package.svg'],
            ],
        ],

        // 5 — Hoarding Block
        [
            'slug'     => 'hoarding-block',
            'title'    => 'DM-Compliant Hoarding Blocks',
            'excerpt'  => 'High-stability concrete counterweights for site perimeter fencing and wind-load protection.',
            'content'  => '<p>Our hoarding base blocks are cast to Dubai Municipality (DM) specifications and provide the ballast mass required for free-standing hoarding panels in UAE wind conditions. The blocks accept standard 48mm and 60mm hoarding poles through precision-cast holes, and their wide footprint prevents overturning even at full panel height.</p><p>Standard weight options of 600kg and 1000kg match the wind-load requirements for different panel heights and exposure categories. Painted yellow for high-visibility on active construction sites.</p><h3>Applications</h3><ul><li>Construction site perimeter hoardings</li><li>Temporary event enclosures</li><li>Security fencing counterweights</li><li>Plant and equipment yard boundaries</li></ul>',
            'cats'     => ['site-safety'],
            'certs'    => 'DM Compliant, RTA Approved',
            'material' => 'C25 Grade Concrete',
            'finish'   => 'Yellow painted',
            'icon'     => '/icons/icon_hoarding.svg',
            'images'   => [
                '/images/hoarding_slide_1_hu_5cadc1f4e76901c6.webp',
                '/images/hoarding_slide_2_hu_4e633d0611b3f983.webp',
                '/images/hoarding_slide_3_hu_f02ed68089276a31.webp',
            ],
            'specs'    => [
                ['Market Name',     'Fence Footing / Hoarding Base',    $ti.'fence.svg'],
                ['Standard Weight', '600 kg / 1000 kg',                 $ti.'weight.svg'],
                ['Dimensions',      '1000 x 500 x 500 mm',              $ti.'dimensions.svg'],
                ['Pole Hole Size',  'Dia 48mm / 60mm',                  $ti.'circle-dashed.svg'],
                ['Concrete Grade',  'C25',                               $ti.'cube.svg'],
                ['Compliance',      'Dubai Municipality (DM)',           $ti.'certificate.svg'],
            ],
        ],

        // 6 — Plastic Barrier
        [
            'slug'     => 'plastic-barrier',
            'title'    => 'RTA-Approved Water-Filled Plastic Barriers',
            'excerpt'  => 'UV-stabilised HDPE barriers for agile traffic diversion and crowd control.',
            'content'  => '<p>Our water-filled plastic road barriers are manufactured from UV-stabilised high-density polyethylene (HDPE) and are approved by the Roads and Transport Authority (RTA) for use on UAE highways and roads. Filled with water on-site, they achieve up to 500kg ballast mass per unit without the transport costs of concrete.</p><p>Available in red/white and full orange for RTA-specified lane configurations. Units interlock end-to-end via integrated male/female connectors, creating a continuous barrier line. Forklift pockets are moulded-in for rapid deployment and removal.</p><h3>Applications</h3><ul><li>Highway lane separation and contra-flow</li><li>Work zone protection</li><li>Event crowd management</li><li>Temporary pedestrian channelling</li></ul>',
            'cats'     => ['traffic-management', 'road-safety'],
            'certs'    => 'RTA Approved',
            'material' => 'UV-Stabilised HDPE Plastic',
            'finish'   => 'Red/White or Orange (RTA standard)',
            'icon'     => '/icons/icon_plastic.svg',
            'images'   => [
                '/images/plastic_slide_1_hu_553a2f6db1b5e2e0.webp',
                '/images/plastic_slide_2_hu_daa1b5b84b25546c.webp',
                '/images/plastic_slide_3_hu_e3f11e8759cbb496.webp',
            ],
            'specs'    => [
                ['Type',            'Interlocking Road Separator',       $ti.'barrier-block.svg'],
                ['Dimensions',      '2000L x 800H x 400W mm',           $ti.'dimensions.svg'],
                ['Weight (Empty)',  '18 kg – 22 kg',                     $ti.'feather.svg'],
                ['Weight (Filled)', 'Up to 500 kg',                      $ti.'weight.svg'],
                ['Material',        'UV-Stabilised HDPE',                $ti.'box.svg'],
                ['Certification',   'RTA Approved',                      $ti.'certificate.svg'],
            ],
        ],
    ];

    // ── Create posts ──────────────────────────────────────────────────────────
    foreach ($products as $p) {

        // Skip if already exists
        $existing = get_page_by_path($p['slug'], OBJECT, 'sp_product');
        if ($existing) {
            $log[] = "SKIP (exists): {$p['title']}";
            continue;
        }

        // Insert post
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
            $log[] = "ERROR creating {$p['title']}: " . $post_id->get_error_message();
            continue;
        }
        $log[] = "Created post: {$p['title']} (ID $post_id)";

        // Taxonomy
        $term_ids = array_map(fn($s) => $cat_ids[$s] ?? 0, $p['cats']);
        wp_set_object_terms($post_id, array_filter($term_ids), 'sp_product_cat');

        // Text meta
        update_post_meta($post_id, '_sp_product_certifications', $p['certs']);
        update_post_meta($post_id, '_sp_product_material',       $p['material']);
        update_post_meta($post_id, '_sp_product_finish',         $p['finish']);

        // Specs JSON
        update_post_meta($post_id, '_sp_product_specs', wp_json_encode($p['specs']));

        // Images
        $gallery_ids = [];
        foreach ($p['images'] as $i => $img_path) {
            $img_url = $base . $img_path;
            $att_id  = sp_sideload_image($img_url, $post_id, $p['title'] . ' image ' . ($i + 1));
            if ($att_id) {
                $gallery_ids[] = $att_id;
                if ($i === 0) set_post_thumbnail($post_id, $att_id);
                $log[] = "  Image downloaded: $img_path (att $att_id)";
            } else {
                $log[] = "  Image FAILED: $img_path";
            }
        }
        if (!empty($gallery_ids)) {
            update_post_meta($post_id, '_sp_product_gallery', implode(',', $gallery_ids));
        }

        // Icon — try to sideload from /icons/
        $icon_url = $base . $p['icon'];
        $icon_id  = sp_sideload_image($icon_url, $post_id, $p['title'] . ' icon');
        if ($icon_id) {
            update_post_meta($post_id, '_sp_product_icon', $icon_id);
            $log[] = "  Icon downloaded: {$p['icon']} (att $icon_id)";
        } else {
            $log[] = "  Icon FAILED: {$p['icon']}";
        }
    }

    $log[] = '── Done ──';
    return $log;
}

/**
 * Sideload a remote image into the WP media library.
 * Returns the attachment ID or 0 on failure.
 */
function sp_sideload_image(string $url, int $post_id, string $title): int {
    // Avoid duplicates — check if URL already imported
    $existing = get_posts([
        'post_type'      => 'attachment',
        'meta_key'       => '_sp_source_url',
        'meta_value'     => $url,
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ]);
    if (!empty($existing)) return (int) $existing[0];

    $tmp = download_url($url, 30);
    if (is_wp_error($tmp)) return 0;

    $file_array = [
        'name'     => basename(parse_url($url, PHP_URL_PATH)),
        'tmp_name' => $tmp,
    ];

    $id = media_handle_sideload($file_array, $post_id, $title);
    @unlink($tmp);

    if (is_wp_error($id)) return 0;

    update_post_meta($id, '_sp_source_url', $url);
    return (int) $id;
}
