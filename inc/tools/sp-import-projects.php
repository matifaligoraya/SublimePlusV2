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

    $patch_done = false;
    if (isset($_POST['sp_do_patch_images']) && check_admin_referer('sp_patch_images_run')) {
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $log        = sp_project_patch_images();
        $patch_done = true;
        $done       = true;
    }
    ?>
    <div class="wrap" style="max-width:760px">
        <h1>🏗️ Import Projects</h1>
        <p style="color:#64748b">Imports 8 UAE precast showcase projects with descriptions, metadata, categories, and images — directly into <strong>sp_project</strong> posts.</p>

        <?php if ($done) : ?>
            <div class="notice notice-success inline" style="margin:12px 0">
                <p>✅ <?php echo $patch_done ? 'Image patch' : 'Import'; ?> complete — <a href="<?php echo esc_url(admin_url('edit.php?post_type=sp_project')); ?>">view projects</a></p>
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
            <hr style="margin:24px 0">
            <h2 style="font-size:15px;margin-bottom:6px">Fix Project Images</h2>
            <p style="color:#64748b;font-size:13px;margin-bottom:12px">
                Sideloads project images from the local staging folder
                (<code>wp-content/uploads/sp-staging/</code>) and sets them as featured images.
                Run this if images were blocked during the initial import. Works on both new and existing project posts.
            </p>
            <form method="post">
                <?php wp_nonce_field('sp_patch_images_run'); ?>
                <input type="hidden" name="sp_do_patch_images" value="1">
                <button type="submit" class="button button-secondary" style="height:40px;padding:0 22px;font-size:14px;font-weight:600">
                    🖼️ Fix Project Images (Local Staging)
                </button>
            </form>
        <?php endif; ?>
    </div>
    <?php
}

// ─── Patch images (local staging → featured image) ───────────────────────────

function sp_project_patch_images(): array {
    $log     = [];
    $staging = WP_CONTENT_DIR . '/uploads/sp-staging/';

    $map = [
        'al-maktoum-airport-road' => 'project_highway_hu_aedd9ea1c0fa6c10.webp',
        'damac-hills-community'   => 'project_villa_hu_b95f7fcb147f3f5d.webp',
        'sheikh-mbd-road'         => 'project_e311_maintenance_hu_4a59a39d79343a30.webp',
        'etihad-rail-network'     => 'project_etihad_rail_hu_7a010fd8c98f89f4.webp',
        'atlantis-the-royal'      => 'project_atlantis_parking_hu_93e827b4a30f69fb.webp',
        'yas-marina-circuit'      => 'project_yas_marina_hu_435020567dbe2a9c.webp',
        'dubai-hills-estate'      => 'project_dubai_hills_hu_a7a4029162fb3f87.webp',
        'opus-tower-parking'      => 'project_opus_parking_hu_e13269eee20651dd.webp',
    ];

    foreach ($map as $slug => $filename) {
        $post = get_page_by_path($slug, OBJECT, 'sp_project');
        if (!$post) {
            $log[] = 'SKIP (no post): ' . $slug;
            continue;
        }

        $local = $staging . $filename;
        if (!file_exists($local)) {
            $log[] = '── ' . $slug;
            $log[] = '  ✗ staging file missing — copy ' . $filename . ' to wp-content/uploads/sp-staging/';
            continue;
        }

        // Deduplicate via canonical remote URL stored as _sp_src
        $remote_url = 'https://precastuae.ae/images/' . $filename;
        $existing   = get_posts([
            'post_type'      => 'attachment',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'meta_key'       => '_sp_src',
            'meta_value'     => $remote_url,
        ]);

        if ($existing) {
            $attach_id = (int) $existing[0];
            $log[]     = '── ' . $slug . ' (reusing existing media #' . $attach_id . ')';
        } else {
            // Copy to sys temp dir (required by media_handle_sideload)
            $tmp = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;
            if (!copy($local, $tmp)) {
                $log[] = '── ' . $slug;
                $log[] = '  ✗ temp copy failed — check permissions on ' . sys_get_temp_dir();
                continue;
            }

            $attach_id = media_handle_sideload(
                ['name' => $filename, 'tmp_name' => $tmp],
                $post->ID,
                $slug
            );
            @unlink($tmp);

            if (is_wp_error($attach_id)) {
                $log[] = '── ' . $slug;
                $log[] = '  ✗ sideload error — ' . $attach_id->get_error_message();
                continue;
            }

            update_post_meta((int) $attach_id, '_sp_src', $remote_url);
            $log[] = '── ' . $slug;
            $log[] = '  ✓ image imported (attachment #' . $attach_id . ')';
        }

        set_post_thumbnail($post->ID, $attach_id);
        $log[] = '  ✓ featured image set';
    }

    return $log;
}

// ─── Project data ─────────────────────────────────────────────────────────────

function sp_project_importer_data(): array {
    $B = 'https://precastuae.ae';

    return [

        [
            'slug'     => 'al-maktoum-airport-road',
            'title'    => 'Al Maktoum Airport Road',
            'excerpt'  => 'Supply and installation of 15 km of K-Type Jersey Barriers for the main airport access road, with 24/7 delivery logistics to meet the fast-track paving schedule.',
            'content'  => '<p>Supply and installation of 15 km of K-Type Jersey Barriers for the main access road to Al Maktoum International Airport at Dubai South. The project required 24/7 delivery logistics to meet the fast-track paving schedule, with crane-mounted flatbed trucks completing staged overnight drops across multiple site access points.</p><p>Every barrier was supplied with RTA mill certificates and compressive strength test reports to satisfy on-site inspections. Our technical team provided joint alignment guidance and barrier sequencing support throughout the programme.</p><h3>Scope of Work</h3><ul><li>15 km of K-Type Jersey Barriers — K-Rail profile, C30 grade</li><li>24/7 crane-assisted delivery to active construction zones</li><li>Full RTA compliance documentation per delivery batch</li><li>On-site joint alignment and technical support</li></ul>',
            'cats'     => ['Infrastructure', 'Road Barriers', 'RTA'],
            'client'   => 'Dubai Aviation City Corporation',
            'emirate'  => 'dubai',
            'scale'    => '15 km K-Rail',
            'value'    => 'AED 4.8M',
            'status'   => 'completed',
            'date'     => '2024-03-01',
            'products' => ['jersey-barrier'],
            'images'   => [
                $B . '/images/project_highway_hu_aedd9ea1c0fa6c10.webp',
            ],
        ],

        [
            'slug'     => 'damac-hills-community',
            'title'    => 'Damac Hills Community',
            'excerpt'  => 'Bulk supply of high-density 200 mm hollow blocks for boundary walls and substructures of 150 luxury villas, delivered on crane-mounted trucks for direct plot offloading.',
            'content'  => '<p>Bulk supply of high-density 200 mm hollow masonry blocks for the boundary walls and substructures of 150 luxury villas at Damac Hills, Dubai. Deliveries were co-ordinated directly with villa construction teams, with crane-mounted trucks offloading pallets to individual plots to eliminate site handling.</p><p>All blocks were ESMA-certified and supplied with batch test certificates for the structural wall sections. Corner specials and half-blocks were included to minimise site cutting and maintain wall quality across all boundary treatments.</p><h3>Scope of Work</h3><ul><li>High-density 200 mm hollow masonry blocks — boundary walls</li><li>Corner specials and half-blocks for all openings</li><li>Crane-mounted truck delivery — direct plot offloading</li><li>ESMA batch certificates for structural wall sections</li></ul>',
            'cats'     => ['Residential', 'Masonry Blocks', 'Construction'],
            'client'   => 'DAMAC Properties',
            'emirate'  => 'dubai',
            'scale'    => '150 Luxury Villas',
            'value'    => 'AED 3.2M',
            'status'   => 'completed',
            'date'     => '2023-11-30',
            'products' => ['masonry-block'],
            'images'   => [
                $B . '/images/project_villa_hu_b95f7fcb147f3f5d.webp',
            ],
        ],

        [
            'slug'     => 'sheikh-mbd-road',
            'title'    => 'Sheikh Mohammed Bin Zayed Rd',
            'excerpt'  => 'Urgent maintenance contract: removal of damaged barriers and installation of new precast elements during night shifts to minimise traffic disruption on the E311.',
            'content'  => '<p>Urgent maintenance contract on the E311 (Sheikh Mohammed Bin Zayed Road) involving the removal of crash-damaged barriers and installation of new precast concrete elements during approved night-shift windows to minimise traffic disruption to one of Dubai\'s busiest arterial corridors.</p><p>Our crane-equipped delivery teams completed each nightly drop within tight road-closure windows, with all damaged units removed and new barriers placed and jointed before the morning peak. Full RTA road-permit and documentation compliance was maintained throughout.</p><h3>Scope of Work</h3><ul><li>Removal and disposal of crash-damaged Jersey Barriers</li><li>Installation of new K-Rail precast barriers — night shifts</li><li>Crane-assisted placement within RTA road-closure windows</li><li>Full RTA permit and documentation compliance</li></ul>',
            'cats'     => ['Maintenance', 'Infrastructure', 'Emergency'],
            'client'   => 'RTA Dubai',
            'emirate'  => 'dubai',
            'scale'    => 'Emergency Works',
            'value'    => 'AED 1.6M',
            'status'   => 'completed',
            'date'     => '2024-01-20',
            'products' => ['jersey-barrier'],
            'images'   => [
                $B . '/images/project_e311_maintenance_hu_4a59a39d79343a30.webp',
            ],
        ],

        [
            'slug'     => 'etihad-rail-network',
            'title'    => 'Etihad Rail Network',
            'excerpt'  => 'Production and delivery of customised reinforced operational barriers for the UAE\'s national railway network, engineered for high-impact resistance and long-term desert durability.',
            'content'  => '<p>Production and delivery of customised reinforced concrete operational barriers for the Etihad Rail national railway network spanning Abu Dhabi and Dubai. The barriers were engineered specifically for high-impact resistance and long-term structural durability in UAE desert conditions, with enhanced concrete mix design and reinforcement detailing beyond standard K-Rail specification.</p><p>Supply was coordinated across multiple active construction fronts, with delivery logistics managed to avoid conflict with live rail installation works. All documentation met the multi-authority requirements of DoT Abu Dhabi and RTA Dubai.</p><h3>Scope of Work</h3><ul><li>Custom reinforced concrete barriers — rail right-of-way protection</li><li>Enhanced mix design for desert durability and impact resistance</li><li>Multi-front delivery co-ordination across Abu Dhabi and Dubai</li><li>DoT Abu Dhabi + RTA Dubai compliance documentation</li></ul>',
            'cats'     => ['Rail', 'Infrastructure', 'Mega Project'],
            'client'   => 'Etihad Rail',
            'emirate'  => 'uae',
            'scale'    => 'National Rail Network',
            'value'    => 'AED 14.4M',
            'status'   => 'completed',
            'date'     => '2023-09-01',
            'products' => ['jersey-barrier'],
            'images'   => [
                $B . '/images/project_etihad_rail_hu_7a010fd8c98f89f4.webp',
            ],
        ],

        [
            'slug'     => 'atlantis-the-royal',
            'title'    => 'Atlantis The Royal',
            'excerpt'  => 'Bespoke polished concrete wheel stoppers for the ultra-luxury resort\'s valet and guest parking zones on Palm Jumeirah, designed to complement the hotel\'s high-end architectural finish.',
            'content'  => '<p>Supply of bespoke polished concrete wheel stoppers for the valet and guest parking zones at Atlantis The Royal, Palm Jumeirah. The stoppers were finished to a polished surface standard and colour-matched to the hotel\'s architectural palette, replacing the standard exposed-aggregate finish used in commercial car parks.</p><p>Each unit was pre-drilled for bolt-down fixing to the polished concrete parking deck, with low-profile chamfering to avoid damage to low-clearance luxury vehicles. Delivery was stage-managed around the hotel\'s pre-opening fitout programme.</p><h3>Scope of Work</h3><ul><li>Bespoke polished-finish concrete wheel stoppers</li><li>Colour-matched to hotel architectural specification</li><li>Pre-drilled bolt-down fixing — polished deck substrate</li><li>Low-profile chamfered profile for luxury vehicle clearance</li></ul>',
            'cats'     => ['Hospitality', 'Luxury', 'Wheel Stoppers'],
            'client'   => 'Kerzner International',
            'emirate'  => 'dubai',
            'scale'    => 'Valet & Guest Parking',
            'value'    => 'AED 0.9M',
            'status'   => 'completed',
            'date'     => '2022-12-01',
            'products' => ['wheel-stopper'],
            'images'   => [
                $B . '/images/project_atlantis_parking_hu_93e827b4a30f69fb.webp',
            ],
        ],

        [
            'slug'     => 'yas-marina-circuit',
            'title'    => 'Yas Marina Circuit',
            'excerpt'  => 'Rapid deployment of modular barrier systems for crowd control and track safety during the Formula 1 Etihad Airways Abu Dhabi Grand Prix.',
            'content'  => '<p>Rapid deployment of modular precast barrier systems for crowd control and track safety during the Formula 1 Etihad Airways Abu Dhabi Grand Prix at Yas Marina Circuit, Yas Island. Barriers were installed across multiple spectator zones, pit lane access points, and paddock entries to meet FIA safety requirements and circuit crowd management standards.</p><p>Precision manufacturing ensured perfect alignment at every junction — critical for both safety compliance and the high-visibility broadcast environment of a Formula 1 event. Post-race barrier removal and reinstatement was completed within the circuit\'s tight post-event window.</p><h3>Scope of Work</h3><ul><li>Modular barrier systems — FIA crowd control and track safety zones</li><li>Precision-manufactured for perfect joint alignment</li><li>Rapid deployment and post-event removal programme</li><li>Pit lane, paddock, and spectator zone installations</li></ul>',
            'cats'     => ['Events', 'Motorsport', 'Temporary Safety'],
            'client'   => 'Yas Marina Circuit',
            'emirate'  => 'abu-dhabi',
            'scale'    => 'F1 Grand Prix',
            'value'    => 'AED 1.4M',
            'status'   => 'completed',
            'date'     => '2023-11-25',
            'products' => ['jersey-barrier', 'plastic-barrier'],
            'images'   => [
                $B . '/images/project_yas_marina_hu_435020567dbe2a9c.webp',
            ],
        ],

        [
            'slug'     => 'dubai-hills-estate',
            'title'    => 'Dubai Hills Estate',
            'excerpt'  => 'Supply chain coordination for 500+ villa boundary walls at Dubai Hills Estate, using high-strength hollow blocks for structural integrity and thermal insulation.',
            'content'  => '<p>Massive supply chain coordination for the construction of boundary walls across 500+ villas at Dubai Hills Estate, Dubai. Our high-strength hollow masonry blocks were specified for all boundary wall and party-wall applications, providing the structural performance and thermal insulation values required by Emaar\'s design standards for this flagship master community.</p><p>Deliveries were sequenced across multiple active construction clusters simultaneously, with a dedicated site coordinator managing delivery windows to avoid congestion on the community\'s internal road network.</p><h3>Scope of Work</h3><ul><li>High-strength hollow masonry blocks — 500+ villa boundary walls</li><li>Multi-cluster simultaneous delivery co-ordination</li><li>Dedicated site coordinator for community access management</li><li>ESMA certificates and Emaar structural compliance documentation</li></ul>',
            'cats'     => ['Residential', 'Mega Community', 'Masonry'],
            'client'   => 'Emaar Properties',
            'emirate'  => 'dubai',
            'scale'    => '500+ Villa Walls',
            'value'    => 'AED 5.6M',
            'status'   => 'completed',
            'date'     => '2024-04-01',
            'products' => ['masonry-block'],
            'images'   => [
                $B . '/images/project_dubai_hills_hu_a7a4029162fb3f87.webp',
            ],
        ],

        [
            'slug'     => 'opus-tower-parking',
            'title'    => 'Opus Tower Parking',
            'excerpt'  => '2,500 premium painted wheel stoppers for the 3-level underground parking at the Opus Tower, Business Bay, with custom yellow/black epoxy finish.',
            'content'  => '<p>Provision of 2,500 premium painted wheel stoppers for the three-level underground car park at the Opus Tower, Business Bay. The stoppers were supplied with a custom yellow and black two-tone epoxy finish applied to match the building\'s internal safety colour scheme, replacing the standard concrete-grey finish specified in the base design.</p><p>Delivery was co-ordinated with the fit-out contractor to arrive post-screed, allowing direct placement without the risk of surface damage during construction activity. Each stopper was pre-drilled for bolt-down fixing to the finished parking deck.</p><h3>Scope of Work</h3><ul><li>2,500 wheel stoppers — custom yellow/black epoxy finish</li><li>Colour scheme matched to building safety aesthetics</li><li>Pre-drilled for bolt-down fixing — finished deck substrate</li><li>Post-screed delivery staged with fit-out programme</li></ul>',
            'cats'     => ['Commercial', 'Wheel Stoppers', 'Parking'],
            'client'   => 'Omniyat',
            'emirate'  => 'dubai',
            'scale'    => '2,500 Wheel Stoppers',
            'value'    => 'AED 1.1M',
            'status'   => 'completed',
            'date'     => '2023-05-15',
            'products' => ['wheel-stopper'],
            'images'   => [
                $B . '/images/project_opus_parking_hu_e13269eee20651dd.webp',
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
