<?php
/**
 * One-click project importer.
 * Tools → Import Projects → click the button.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

add_action('admin_menu', function () {
    add_management_page('Import Projects', 'Import Projects', 'manage_options', 'sp-import-projects', 'sp_project_importer_render');
});

function sp_project_importer_render() {
    if (!current_user_can('manage_options')) wp_die('Forbidden');

    $log  = [];
    $done = false;

    if (isset($_POST['sp_do_import_projects']) && check_admin_referer('sp_import_projects_run')) {
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $log  = sp_project_importer_run();
        $done = true;
    }
    ?>
    <div class="wrap" style="max-width:760px">
        <h1>🏗️ Import Projects</h1>
        <p style="color:#64748b">Imports 8 UAE precast showcase projects with descriptions, metadata, categories, and images — directly into <strong>sp_project</strong> posts.</p>

        <?php if ($done) : ?>
            <div class="notice notice-success inline" style="margin:12px 0">
                <p>✅ Import complete — <a href="<?php echo esc_url(admin_url('edit.php?post_type=sp_project')); ?>">view projects</a></p>
            </div>
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:14px 18px;font-family:monospace;font-size:12px;line-height:1.9;max-height:480px;overflow-y:auto">
                <?php foreach ($log as $line) :
                    $color = str_starts_with($line, 'ERR')  ? '#dc2626'
                           : (str_starts_with($line, 'SKIP') ? '#94a3b8'
                           : (str_starts_with($line, '  ✗')  ? '#f97316'
                           : (str_starts_with($line, '  ✓')  ? '#16a34a' : '#1e293b')));
                ?>
                <div style="color:<?php echo $color; ?>"><?php echo esc_html($line); ?></div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="notice notice-info inline" style="margin:12px 0">
                <p>Safe to run multiple times — existing posts are skipped, already-downloaded images are reused.</p>
            </div>
            <form method="post" style="margin-top:16px">
                <?php wp_nonce_field('sp_import_projects_run'); ?>
                <input type="hidden" name="sp_do_import_projects" value="1">
                <button type="submit" class="button button-primary" style="height:44px;padding:0 28px;font-size:15px;font-weight:700">
                    🚀 Import All Projects
                </button>
            </form>
        <?php endif; ?>
    </div>
    <?php
}

// ─── Project data ─────────────────────────────────────────────────────────────

function sp_project_importer_data(): array {
    $B = 'https://precastuae.ae';

    return [

        [
            'slug'     => 'al-maktoum-airport-road',
            'title'    => 'Al Maktoum Airport Road Expansion',
            'excerpt'  => '3,200 RTA-approved Jersey Barriers installed across the DWC access corridors — delivered in four staged crane deployments over six weeks.',
            'content'  => '<p>This project required rapid mobilisation of 3,200 RTA-approved Jersey Barriers across the main access corridors to Al Maktoum International Airport (DWC). Working under a live RTA road permit, our delivery team deployed crane-mounted 40ft trailers for direct offloading onto active construction zones, completing the full barrier installation in four staged deliveries.</p><p>Each barrier was supplied with full mill certificates and compressive strength reports for RTA site inspection. Our technical team provided on-site placement guidance and joint alignment checking throughout the programme.</p><h3>Scope of Work</h3><ul><li>3,200 × 1m and 2m Jersey Barriers — K-Rail profile</li><li>Crane-assisted offloading at three site access points</li><li>RTA compliance documentation for each delivery batch</li><li>Joint alignment and placement guidance by technical team</li></ul>',
            'cats'     => ['Infrastructure'],
            'client'   => 'RTA Dubai',
            'emirate'  => 'dubai',
            'scale'    => '3,200 Barriers',
            'value'    => 'AED 4.2M',
            'status'   => 'completed',
            'date'     => '2024-03-15',
            'products' => ['jersey-barrier', 'plastic-barrier'],
            'images'   => [
                $B . '/images/barrier_stockpile_hu_c2f8772c5563f12.webp',
                $B . '/images/barrier_slide_2_hu_d6aa501998fc4774.webp',
                $B . '/images/feature_delivery_new_hu_434855aada6d92f4.webp',
            ],
        ],

        [
            'slug'     => 'damac-hills-community',
            'title'    => 'DAMAC Hills Community — Phase 3',
            'excerpt'  => '8,500 high-strength masonry blocks supplied and delivered to the Phase 3 boundary wall and landscaping programme at DAMAC Hills, Dubai.',
            'content'  => '<p>Phase 3 of DAMAC Hills required 8,500 high-strength concrete masonry blocks across boundary walls, garden retaining structures, and landscaping podiums. Our 400×200×200mm solid and hollow blocks were specified for the load-bearing boundary wall sections, with half-blocks and corner specials supplied for all openings.</p><p>Deliveries were co-ordinated with the main contractor\'s block-laying gangs to ensure zero downtime — a total of 12 staged deliveries across the 14-week block-laying programme.</p><h3>Scope of Work</h3><ul><li>8,500 masonry blocks — solid and hollow configurations</li><li>Corner specials, half-blocks, and lintel blocks</li><li>12 staged deliveries co-ordinated with laying programme</li><li>Batch test certificates for all structural wall sections</li></ul>',
            'cats'     => ['Residential'],
            'client'   => 'DAMAC Properties',
            'emirate'  => 'dubai',
            'scale'    => '8,500 Blocks',
            'value'    => 'AED 2.8M',
            'status'   => 'completed',
            'date'     => '2023-11-30',
            'products' => ['masonry-block'],
            'images'   => [
                $B . '/images/block_pallets_hu_42ef7d7a61cd9245.webp',
                $B . '/images/block_slide_2_hu_227a9ff28e6bcca.webp',
                $B . '/images/block_slide_3_hu_6a72150325c7020a.webp',
            ],
        ],

        [
            'slug'     => 'sheikh-mbd-road-expansion',
            'title'    => 'Sheikh Mohammed Bin Zayed Road Lane Expansion',
            'excerpt'  => '5,400 Jersey Barriers deployed along an 18 km corridor for the MBZ Road widening works — UAE\'s longest single precast barrier contract in 2023.',
            'content'  => '<p>The MBZ Road widening project required the largest single barrier supply contract in our history — 5,400 Jersey Barriers across an 18 km active motorway corridor. Deliveries were phased nightly to avoid peak traffic disruption, with crane offloading completing each 300-unit nightly drop within a 2-hour window.</p><p>All barriers were supplied with RTA-compliant mill certificates and compressive strength test reports. A dedicated technical team managed barrier placement sequencing and joint alignment throughout the 20-week programme.</p><h3>Scope of Work</h3><ul><li>5,400 × 2m Jersey Barriers — K-Rail profile, C30 grade</li><li>Night-shift phased delivery programme — 20 nightly drops</li><li>Crane-mounted truck deployment at 6 access points</li><li>Full RTA documentation package for each delivery batch</li></ul>',
            'cats'     => ['Infrastructure'],
            'client'   => 'RTA Dubai',
            'emirate'  => 'dubai',
            'scale'    => '5,400 Barriers',
            'value'    => 'AED 6.8M',
            'status'   => 'completed',
            'date'     => '2023-08-20',
            'products' => ['jersey-barrier'],
            'images'   => [
                $B . '/images/barrier_slide_3_hu_d25108439516b5fb.webp',
                $B . '/images/barrier_stockpile_hu_c2f8772c5563f12.webp',
                $B . '/images/feature_site_support_hu_6f60d4b30e09f89c.webp',
            ],
        ],

        [
            'slug'     => 'etihad-rail-phase-2',
            'title'    => 'Etihad Rail Phase 2 — Safety Corridor',
            'excerpt'  => '12,000 concrete barriers lining 42 km of the Etihad Rail Phase 2 right-of-way across Abu Dhabi, Sharjah, and Dubai.',
            'content'  => '<p>Etihad Rail Phase 2 required a continuous barrier line along 42 km of the rail right-of-way to prevent vehicle encroachment. Our supply of 12,000 Jersey Barriers was delivered across 9 months in 38 staged loads, with barriers placed by contractor-operated cranes working from our delivery trucks.</p><p>The programme spanned three emirates — requiring co-ordination with RTA Dubai, DoT Abu Dhabi, and Sharjah Traffic authorities for road permits on each delivery route. All documentation was managed by our compliance team.</p><h3>Scope of Work</h3><ul><li>12,000 × 2m and 3m Jersey Barriers — C30 grade</li><li>38 staged deliveries across Abu Dhabi, Dubai, and Sharjah</li><li>Multi-emirate road permit co-ordination</li><li>Production scheduling to sustain 350 units per week</li></ul>',
            'cats'     => ['Infrastructure'],
            'client'   => 'Etihad Rail',
            'emirate'  => 'abu-dhabi',
            'scale'    => '12,000 Barriers',
            'value'    => 'AED 14.4M',
            'status'   => 'completed',
            'date'     => '2024-01-10',
            'products' => ['jersey-barrier', 'plastic-barrier'],
            'images'   => [
                $B . '/images/barrier_slide_2_hu_d6aa501998fc4774.webp',
                $B . '/images/barrier_stockpile_hu_c2f8772c5563f12.webp',
                $B . '/images/feature_delivery_new_hu_434855aada6d92f4.webp',
            ],
        ],

        [
            'slug'     => 'expo-city-dubai-perimeter',
            'title'    => 'Expo City Dubai — Perimeter Hoarding & Traffic Works',
            'excerpt'  => '2,800 hoarding base blocks and jersey barriers securing the Expo City construction perimeter during the post-Expo legacy conversion works.',
            'content'  => '<p>The Expo City Dubai legacy conversion programme required a comprehensive perimeter hoarding solution across the 4.38 km site boundary. Our supply included 1,800 DM-compliant hoarding base blocks and 1,000 Jersey Barriers, creating a continuous and highly visible site perimeter that met Dubai Municipality requirements.</p><p>Delivery was co-ordinated around live public access zones on the former Expo site — all drops were completed during approved low-footfall windows and with traffic management support.</p><h3>Scope of Work</h3><ul><li>1,800 DM hoarding base blocks — 600kg and 1000kg variants</li><li>1,000 Jersey Barriers for traffic segregation zones</li><li>DM compliance documentation for perimeter hoarding approval</li><li>Site visit by technical team for placement layout and pole alignment</li></ul>',
            'cats'     => ['Commercial'],
            'client'   => 'Expo City Dubai Authority',
            'emirate'  => 'dubai',
            'scale'    => '2,800 Units',
            'value'    => 'AED 3.4M',
            'status'   => 'completed',
            'date'     => '2023-06-30',
            'products' => ['hoarding-block', 'jersey-barrier'],
            'images'   => [
                $B . '/images/hoarding_slide_1_hu_5cadc1f4e76901c6.webp',
                $B . '/images/hoarding_slide_2_hu_4e633d0611b3f983.webp',
                $B . '/images/feature_docs_hu_27e801fac11363c.webp',
            ],
        ],

        [
            'slug'     => 'yas-island-aldar-residential',
            'title'    => 'Yas Island — Aldar Residential Development',
            'excerpt'  => '18,000 masonry blocks across six residential towers at Yas Island, with consolidated deliveries of blocks, stoppers, and hoarding base units on shared loads.',
            'content'  => '<p>Aldar\'s Yas Island residential development required 18,000 masonry blocks across six towers, with block sizes ranging from 100mm partition blocks to 200mm structural hollow units. Our consolidated delivery model combined block deliveries with wheel stoppers for the basement car parks — reducing Aldar\'s site co-ordination burden to a single supplier.</p><p>The block production programme ran in parallel with piling works, allowing block-laying to begin immediately after structural completion of each tower core. Full batch test certificates and ESMA compliance documentation were provided for the structural wall sections.</p><h3>Scope of Work</h3><ul><li>18,000 masonry blocks — solid, hollow, and half-block variants</li><li>360 wheel stoppers for basement and podium car parks</li><li>ESMA-certified batch test documentation</li><li>Consolidated delivery: blocks + stoppers on shared loads</li></ul>',
            'cats'     => ['Residential'],
            'client'   => 'Aldar Properties',
            'emirate'  => 'abu-dhabi',
            'scale'    => '18,360 Units',
            'value'    => 'AED 6.1M',
            'status'   => 'ongoing',
            'date'     => '2025-06-01',
            'products' => ['masonry-block', 'wheel-stopper'],
            'images'   => [
                $B . '/images/block_pallets_hu_42ef7d7a61cd9245.webp',
                $B . '/images/stopper_installed_hu_1c46aea27f526b01.webp',
                $B . '/images/feature_moulds_hu_e7cb04c5aeb7c48f.webp',
            ],
        ],

        [
            'slug'     => 'jebel-ali-port-perimeter',
            'title'    => 'Jebel Ali Port — Security Perimeter Barriers',
            'excerpt'  => '1,600 heavy-duty Jersey Barriers and hoarding blocks forming the expanded security perimeter at Jebel Ali Port Terminal 3.',
            'content'  => '<p>DP World\'s Terminal 3 expansion at Jebel Ali Port required a robust security perimeter capable of withstanding vehicle impact at designated access control points. Our supply of 1,200 Jersey Barriers and 400 hoarding base blocks was completed in eight weekly deliveries across the 8-week perimeter construction programme.</p><p>All barriers were supplied with ADNOC-format traceability documentation alongside the standard RTA mill certificates — a requirement specified by DP World\'s security compliance team for port installations.</p><h3>Scope of Work</h3><ul><li>1,200 × 2m Jersey Barriers — impact-rated perimeter line</li><li>400 × 1000kg hoarding base blocks — access control points</li><li>ADNOC-format + RTA traceability documentation</li><li>Eight weekly delivery drops — crane-assisted placement</li></ul>',
            'cats'     => ['Industrial'],
            'client'   => 'DP World',
            'emirate'  => 'dubai',
            'scale'    => '1,600 Units',
            'value'    => 'AED 2.4M',
            'status'   => 'completed',
            'date'     => '2023-04-15',
            'products' => ['jersey-barrier', 'hoarding-block'],
            'images'   => [
                $B . '/images/hoarding_slide_3_hu_f02ed68089276a31.webp',
                $B . '/images/barrier_slide_3_hu_d25108439516b5fb.webp',
                $B . '/images/feature_lab_hu_9f78b2a1c3d4e5f6.webp',
            ],
        ],

        [
            'slug'     => 'sharjah-industrial-zone-perimeter',
            'title'    => 'Sharjah Industrial Zone — Perimeter Works',
            'excerpt'  => '1,800 RTA-standard barriers defining the eastern perimeter of the Sharjah Industrial Area expansion — delivered and placed within a 4-week window.',
            'content'  => '<p>The Sharjah Economic Development Department (SEDD) required a clearly marked and impact-resistant perimeter for the eastern expansion of Sharjah Industrial Area. Our supply of 1,800 Jersey Barriers was completed in five deliveries over four weeks, with crane-assisted placement directly from the delivery trucks.</p><p>All barriers were supplied with Sharjah Roads Authority-compliant documentation alongside the standard RTA mill certificates, satisfying the dual-authority approval requirement for this cross-boundary site.</p><h3>Scope of Work</h3><ul><li>1,800 × 1m and 2m Jersey Barriers</li><li>Five crane-assisted delivery and placement drops</li><li>Sharjah Roads Authority + RTA compliance documentation</li><li>Site-to-site relocation option agreed for post-construction reuse</li></ul>',
            'cats'     => ['Industrial'],
            'client'   => 'SEDD',
            'emirate'  => 'sharjah',
            'scale'    => '1,800 Barriers',
            'value'    => 'AED 2.2M',
            'status'   => 'completed',
            'date'     => '2023-09-30',
            'products' => ['jersey-barrier'],
            'images'   => [
                $B . '/images/barrier_stockpile_hu_c2f8772c5563f12.webp',
                $B . '/images/feature_site_support_hu_6f60d4b30e09f89c.webp',
                $B . '/images/feature_delivery_new_hu_434855aada6d92f4.webp',
            ],
        ],

    ];
}

// ─── Run import ───────────────────────────────────────────────────────────────

function sp_project_importer_run(): array {
    $log      = [];
    $projects = sp_project_importer_data();

    // ── Ensure categories ──────────────────────────────────────────────────────
    $cat_ids  = [];
    $all_cats = array_unique(array_merge(...array_column($projects, 'cats')));
    foreach ($all_cats as $name) {
        $slug = sanitize_title($name);
        $term = term_exists($slug, 'sp_project_cat') ?: wp_insert_term($name, 'sp_project_cat', ['slug' => $slug]);
        if (!is_wp_error($term)) {
            $cat_ids[$name] = (int) ($term['term_id'] ?? $term);
            $log[]          = 'Category: ' . $name;
        }
    }

    // ── Product slug → ID lookup ───────────────────────────────────────────────
    $product_id_map = [];
    $all_products   = get_posts(['post_type' => 'sp_product', 'posts_per_page' => -1, 'fields' => 'ids', 'post_status' => 'publish']);
    foreach ($all_products as $pid) {
        $slug = get_post_field('post_name', $pid);
        if ($slug) $product_id_map[$slug] = $pid;
    }

    // ── Import each project ────────────────────────────────────────────────────
    foreach ($projects as $idx => $p) {

        if (get_page_by_path($p['slug'], OBJECT, 'sp_project')) {
            $log[] = 'SKIP (exists): ' . $p['title'];
            continue;
        }

        $post_id = wp_insert_post([
            'post_type'    => 'sp_project',
            'post_status'  => 'publish',
            'post_title'   => $p['title'],
            'post_name'    => $p['slug'],
            'post_excerpt' => $p['excerpt'],
            'post_content' => $p['content'],
            'menu_order'   => $idx,
        ], true);

        if (is_wp_error($post_id)) {
            $log[] = 'ERROR: ' . $p['title'] . ' — ' . $post_id->get_error_message();
            continue;
        }
        $log[] = '── ' . $p['title'];

        // Categories
        $tids = array_filter(array_map(fn($c) => $cat_ids[$c] ?? 0, $p['cats']));
        if ($tids) wp_set_object_terms($post_id, array_values($tids), 'sp_project_cat');

        // Text / select meta
        update_post_meta($post_id, '_sp_project_client',  sanitize_text_field($p['client']));
        update_post_meta($post_id, '_sp_project_emirate', sanitize_text_field($p['emirate']));
        update_post_meta($post_id, '_sp_project_status',  sanitize_text_field($p['status']));
        update_post_meta($post_id, '_sp_project_scale',   sanitize_text_field($p['scale']));
        update_post_meta($post_id, '_sp_project_value',   sanitize_text_field($p['value']));
        if (!empty($p['date'])) {
            update_post_meta($post_id, '_sp_project_date', sanitize_text_field($p['date']));
        }

        // Related products (resolve slugs to IDs)
        $related_ids = [];
        foreach (($p['products'] ?? []) as $prod_slug) {
            if (!empty($product_id_map[$prod_slug])) {
                $related_ids[] = $product_id_map[$prod_slug];
            }
        }
        if ($related_ids) {
            update_post_meta($post_id, '_sp_project_products', wp_json_encode($related_ids));
            $log[] = '  ✓ Related products: ' . implode(', ', $p['products']);
        }

        // Featured image + gallery
        $gids = [];
        foreach ($p['images'] as $i => $url) {
            $id = sp_dl($url, $post_id, 'image ' . ($i + 1));
            if ($id) {
                $gids[] = $id;
                if ($i === 0) set_post_thumbnail($post_id, $id);
                $log[]  = '  ✓ Image ' . ($i + 1);
            } else {
                $log[]  = '  ✗ Image ' . ($i + 1) . ' (blocked — upload manually)';
            }
        }
        if ($gids) {
            update_post_meta($post_id, '_sp_project_gallery', $gids);
        }
    }

    return $log;
}
