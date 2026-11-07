<?php
/**
 * Precast Al Turab — content import for the Nov-2026 redesign.
 * Run on the server:  wp eval-file content-import.php
 * Idempotent: re-running updates existing items by slug.
 */
if (!defined('ABSPATH')) exit('Run via wp eval-file');

$log = function ($m) { WP_CLI::log($m); };

// ─────────────────────────────────────────────────────────────────────────────
// 1. Product categories
// ─────────────────────────────────────────────────────────────────────────────
$prod_cats = [
    'heavy-precast'               => ['Heavy Precast', 'Large reinforced precast components requiring custom moulds, heavy reinforcement and controlled lifting: bunkers, shelters, C-Type structures, heavy panels and custom concrete structures.'],
    'protective-structures'       => ['Protective Structures', 'Reinforced wall systems and shelters for perimeter protection, blast and separation applications.'],
    'culverts-channels'           => ['Culverts & Channels', 'Box culverts, U-Channels and C-Type structures in standard and custom dimensions.'],
    'concrete-barriers'           => ['Concrete Barriers', 'Jersey barriers, security barriers and precast traffic-control products.'],
    'manholes-utility-structures' => ['Manholes & Utility Structures', 'Manholes, telecom chambers, cable troughs, cover slabs, pole foundations and related infrastructure products.'],
    'custom-precast'              => ['Custom Precast', 'Custom reinforced precast products manufactured to client drawings, BOQ and technical specifications.'],
    'standard-products'           => ['Standard Products & Accessories', 'Wheel stoppers, blocks, paving slabs, markers and other standard precast accessories.'],
    'logistics-services'          => ['Logistics Services', 'Delivery, crane and relocation services supporting precast supply.'],
];
$cat_ids = [];
foreach ($prod_cats as $slug => [$name, $desc]) {
    $t = get_term_by('slug', $slug, 'sp_product_cat');
    if ($t) { wp_update_term($t->term_id, 'sp_product_cat', ['name' => $name, 'description' => $desc]); $cat_ids[$slug] = $t->term_id; }
    else { $r = wp_insert_term($name, 'sp_product_cat', ['slug' => $slug, 'description' => $desc]); $cat_ids[$slug] = is_wp_error($r) ? 0 : $r['term_id']; }
}
$log('Product categories ready');

// ─────────────────────────────────────────────────────────────────────────────
// 2. Products (14 per brief) — content, specs, FAQs, SEO
// ─────────────────────────────────────────────────────────────────────────────
$psd = 'According to Approved Structural Drawing';
$pspec = 'Project Specific';
$common_faq_tail = [
    ['Can you arrange transportation and crane offloading?', 'Yes. We coordinate trailer transport across the UAE and can arrange crane loading at the factory and offloading at site when requested in the quotation.'],
    ['How can I get a quotation?', 'Use the Request a Quotation form, upload your drawing, BOQ or specification, or WhatsApp our team. We review the technical requirement and respond with pricing, lead time and any clarifications.'],
];

$products = [
    'precast-bunker' => [
        'title' => 'Precast Bunkers', 'h1' => 'Precast Concrete Bunkers UAE', 'menu_order' => 1, 'cats' => ['heavy-precast', 'protective-structures'], 'thumb' => 13, 'gallery' => '13,14,15', 'icon' => 12,
        'excerpt' => 'Heavy reinforced precast concrete bunkers manufactured in the UAE to project-specific drawings, with custom moulds, heavy reinforcement and planned crane lifting.',
        'overview' => "Precast concrete bunkers are large reinforced units manufactured in a controlled factory environment and delivered to site as complete shells or modular segments. They are used for protection of personnel, equipment and critical assets on security, military, industrial and infrastructure projects.\n\nPrecast Al Turab manufactures bunker components from approved structural drawings: wall, roof and base elements, openings, embedded items and lifting anchors are built into the mould so that units arrive ready for placement and connection.",
        'apps' => 'Security Projects, Government Projects, Industrial, Oil & Gas, Infrastructure, Temporary or Permanent Protection',
        'material' => 'C40/50 or as specified (sulphate-resisting options available)',
        'specs' => [['Dimensions', $psd], ['Reinforcement', $psd], ['Wall Thickness', $pspec], ['Unit Weight', $pspec . ' (typically several tonnes per element)'], ['Lifting System', 'Cast-in lifting anchors, crane lifted'], ['Embedded Items', 'Openings, frames, sleeves and plates as per drawing'], ['Quantity Capability', 'Single units to full project quantities'], ['Customisation', 'Full — shell, segmental or modular configurations']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for a precast bunker.',
        'seo_title' => 'Precast Concrete Bunker Manufacturer UAE | Precast Al Turab',
        'seo_desc' => 'Precast concrete bunkers manufactured in the UAE to project drawings. Heavy reinforcement, custom moulds, cast-in lifting and UAE-wide delivery. Request a quotation.',
        'faqs' => [
            ['What sizes of precast bunkers can you manufacture?', 'Bunker dimensions are project specific. We manufacture to approved structural drawings and can produce single-piece shells or segmental units where transport and crane limits require it.'],
            ['Can bunkers be manufactured from our own drawings?', 'Yes. Send your drawings, BOQ or specification. Our technical team reviews reinforcement, embedded items, lifting points and tolerances before mould fabrication starts.'],
            ['What concrete grade is used?', 'Typically C40/50, with sulphate-resisting or higher grades available where the project specification requires it.'],
            ['Are lifting points included?', 'Yes. Cast-in lifting anchors are positioned according to the lifting plan so units can be crane lifted at the factory and on site.'],
            ['Do you manufacture the moulds in-house?', 'Yes. Project-specific steel moulds are fabricated in-house, which allows non-standard openings, thicknesses and connection details.'],
        ],
    ],
    'precast-shelter' => [
        'title' => 'Precast Shelters', 'h1' => 'Precast Concrete Shelters UAE', 'menu_order' => 2, 'cats' => ['heavy-precast', 'protective-structures'], 'thumb' => 14, 'gallery' => '14,15,13', 'icon' => 12,
        'excerpt' => 'Reinforced precast concrete shelters and C-Type protective units for personnel, guard posts, equipment and utility enclosures across UAE projects.',
        'overview' => "Precast shelters provide a fast, durable and relocatable form of protection. Units are cast as complete sections or assembled from precast wall and roof panels, with doors, vents and service openings formed in the mould.\n\nTypical uses include guard shelters, emergency refuge units, equipment enclosures and protective structures on industrial and infrastructure sites.",
        'apps' => 'Security, Industrial, Oil & Gas, Infrastructure, Government Projects, Temporary or Permanent Protection',
        'material' => 'C40/50 or as specified',
        'specs' => [['Dimensions', $psd], ['Reinforcement', $psd], ['Wall Thickness', $pspec], ['Unit Weight', $pspec], ['Lifting System', 'Cast-in lifting anchors'], ['Embedded Items', 'Door frames, vents, conduits as per drawing'], ['Quantity Capability', 'Single units to repeat production runs'], ['Customisation', 'Full']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for precast shelters.',
        'seo_title' => 'Precast Concrete Shelter Manufacturer UAE | Precast Al Turab',
        'seo_desc' => 'Precast concrete shelters and C-Type protective units manufactured in the UAE to project drawings. Custom moulds, heavy reinforcement and crane delivery.',
        'faqs' => [
            ['What is the difference between a bunker and a shelter?', 'Bunkers are generally heavier structures designed for a higher level of protection. Shelters are lighter protective enclosures for personnel or equipment. Both are manufactured to the project drawing and specification.'],
            ['Can shelters be relocated?', 'Yes. Units are designed with lifting anchors so they can be crane lifted and moved between locations.'],
            ['Can you include doors and ventilation openings?', 'Yes. Openings, frames and conduits are formed in the mould according to the approved drawing.'],
        ],
    ],
    't-wall' => [
        'title' => 'T-Walls', 'h1' => 'Precast Concrete T-Walls UAE', 'menu_order' => 3, 'cats' => ['heavy-precast', 'protective-structures'], 'thumb' => 0, 'gallery' => '', 'icon' => 0,
        'excerpt' => 'Heavy reinforced precast T-Wall systems for perimeter protection, blast mitigation, separation and infrastructure applications, manufactured in the UAE.',
        'overview' => "T-Walls are free-standing reinforced concrete wall units with an integral base that allows them to be placed without foundations and relocated when required. They are used for site perimeters, security lines, blast protection, traffic separation and protection of critical infrastructure.\n\nPrecast Al Turab manufactures T-Walls in standard and project-specific heights, with interlocking edges, lifting anchors and finishes according to the project requirement.",
        'apps' => 'Security, Infrastructure, Government Projects, Industrial, Oil & Gas, Temporary or Permanent Protection',
        'material' => 'C40/50 or as specified',
        'specs' => [['Dimensions', 'Standard heights available; project-specific on request'], ['Reinforcement', $psd], ['Wall Thickness', $pspec], ['Unit Weight', $pspec . ' (depends on height and thickness)'], ['Lifting System', 'Cast-in lifting anchors, crane lifted'], ['Finish', 'As-cast; smooth or textured on request'], ['Quantity Capability', 'Large repeat runs'], ['Customisation', 'Height, thickness, interlock, embedded items']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for T-Walls.',
        'seo_title' => 'Precast T-Wall Manufacturer UAE | Precast Al Turab',
        'seo_desc' => 'Precast concrete T-Walls manufactured in the UAE for security perimeters, blast protection and infrastructure. Standard and custom heights, cast-in lifting, UAE delivery.',
        'faqs' => [
            ['What sizes of T-Walls can you manufacture?', 'We manufacture standard T-Wall heights and can produce project-specific heights, thicknesses and base widths from approved drawings.'],
            ['Can T-Walls be manufactured according to client drawings?', 'Yes. Send your drawing or specification and we will confirm reinforcement, lifting points and production details.'],
            ['What concrete grades are available?', 'Typically C40/50, with higher or sulphate-resisting grades available where specified.'],
            ['Do you manufacture custom moulds?', 'Yes. Steel moulds for non-standard profiles are fabricated in-house.'],
            ['Can lifting points be incorporated?', 'Yes. Cast-in lifting anchors are included for crane handling at the factory and on site.'],
        ],
    ],
    'jersey-barrier' => [
        'title' => 'Jersey Barriers', 'h1' => 'Concrete Jersey Barriers UAE', 'menu_order' => 4, 'cats' => ['concrete-barriers'], 'thumb' => 8, 'gallery' => '8,9,10', 'icon' => 7,
        'excerpt' => 'Precast concrete Jersey barriers for road works, lane separation, site security and traffic management, manufactured in the UAE in 1 m, 2 m and 3 m lengths.',
        'overview' => "Jersey barriers are modular precast concrete safety barriers used for highway diversions, work zones, lane separation and site protection. Units interlock end to end and can be relocated as the project progresses.\n\nStandard lengths of 1 m, 2 m and 3 m are available, with project-specific profiles, reflectors and lifting details on request.",
        'apps' => 'Road Works, Infrastructure, Construction, Security, Traffic Management, Temporary or Permanent Protection',
        'material' => 'C30 to C40/50 as specified',
        'specs' => [['Length Options', '1000 mm / 2000 mm / 3000 mm'], ['Height', 'Standard profile; project specific on request'], ['Reinforcement', 'Reinforced as per standard or project detail'], ['Unit Weight', 'Depends on length and profile'], ['Lifting System', 'Lifting slots or cast-in anchors'], ['Finish', 'As-cast concrete finish'], ['Quantity Capability', 'Bulk supply'], ['Customisation', 'Profile, interlock, reflectors, colour']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for Jersey barriers.',
        'seo_title' => 'Concrete Jersey Barrier Supplier UAE | Precast Al Turab',
        'seo_desc' => 'Precast concrete Jersey barriers manufactured in the UAE in 1 m, 2 m and 3 m lengths for road works, lane separation and site security. Request a quotation.',
        'faqs' => [
            ['What lengths of Jersey barrier do you supply?', 'Standard 1 m, 2 m and 3 m units. Other lengths and profiles can be manufactured to drawing.'],
            ['Can barriers be delivered and placed on site?', 'Yes. We arrange trailer delivery across the UAE and crane offloading or placement on request.'],
            ['Are the barriers reusable?', 'Yes. Units can be lifted and relocated between work zones.'],
        ],
    ],
    'security-barrier' => [
        'title' => 'Security Barriers', 'h1' => 'Precast Concrete Security Barriers UAE', 'menu_order' => 5, 'cats' => ['concrete-barriers', 'protective-structures'], 'thumb' => 9, 'gallery' => '9,10,8', 'icon' => 7,
        'excerpt' => 'Heavy precast security barriers and vehicle-mitigation units for perimeter control, access points and protection of sensitive facilities across the UAE.',
        'overview' => "Security barriers are heavier precast units designed to control vehicle access and protect perimeters, gates and critical facilities. They are supplied as interlocking blocks, planters or custom profiles according to the security requirement.\n\nPrecast Al Turab manufactures security barriers to project drawings with reinforcement, mass and lifting details confirmed during technical review.",
        'apps' => 'Security, Government Projects, Infrastructure, Industrial, Oil & Gas, Commercial',
        'material' => 'C40/50 or as specified',
        'specs' => [['Dimensions', $psd], ['Reinforcement', $psd], ['Unit Weight', $pspec], ['Lifting System', 'Cast-in lifting anchors'], ['Finish', 'As-cast or architectural on request'], ['Quantity Capability', 'Single units to perimeter runs'], ['Customisation', 'Profile, mass, interlock, finish']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for security barriers.',
        'seo_title' => 'Precast Security Barrier Manufacturer UAE | Precast Al Turab',
        'seo_desc' => 'Heavy precast concrete security barriers manufactured in the UAE for perimeter control and vehicle mitigation. Custom profiles, cast-in lifting, UAE delivery.',
        'faqs' => [
            ['Can security barriers be manufactured to a specific mass?', 'Yes. Unit mass and reinforcement are confirmed from your drawing or security specification.'],
            ['Can you provide an architectural finish?', 'Yes. Smooth, textured or coloured finishes can be discussed at quotation stage.'],
        ],
    ],
    'box-culvert' => [
        'title' => 'Box Culverts', 'h1' => 'Precast Box Culverts UAE', 'menu_order' => 6, 'cats' => ['culverts-channels', 'heavy-precast'], 'thumb' => 15, 'gallery' => '15,13', 'icon' => 12,
        'excerpt' => 'Precast reinforced concrete box culverts for drainage, utility crossings and infrastructure works, manufactured in the UAE in standard and custom dimensions.',
        'overview' => "Box culverts are reinforced concrete sections used for storm water drainage, irrigation, utility crossings and pedestrian or service tunnels under roads and infrastructure. Precast manufacture provides consistent quality, fast installation and reduced site works.\n\nUnits are manufactured to the specified internal span and height with jointing, lifting anchors and any headwall or wingwall elements included where required.",
        'apps' => 'Infrastructure, Road Works, Utilities, Drainage, Industrial, Government Projects',
        'material' => 'C40/50 or as specified',
        'specs' => [['Dimensions', 'Standard and custom internal spans; ' . $psd], ['Reinforcement', $psd], ['Wall Thickness', $pspec], ['Unit Weight', $pspec], ['Lifting System', 'Cast-in lifting anchors'], ['Jointing', 'Tongue and groove or as specified'], ['Quantity Capability', 'Full project lengths'], ['Customisation', 'Span, height, length, skew, openings']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for box culverts.',
        'seo_title' => 'Precast Box Culvert Manufacturer UAE | Precast Al Turab',
        'seo_desc' => 'Precast concrete box culverts manufactured in the UAE in standard and custom sizes for drainage and utility crossings. Reinforced to drawing, crane lifted, UAE delivery.',
        'faqs' => [
            ['What box culvert sizes can you manufacture?', 'Standard internal spans are available and custom sizes are manufactured to the approved drawing, within transport and lifting limits.'],
            ['Do you supply headwalls and wingwalls?', 'Yes. End structures can be manufactured as part of the same package.'],
            ['How are the segments jointed?', 'Typically tongue and groove joints with sealant or as specified by the consultant.'],
        ],
    ],
    'u-channel' => [
        'title' => 'U-Channels', 'h1' => 'Precast U-Channels UAE', 'menu_order' => 7, 'cats' => ['culverts-channels'], 'thumb' => 0, 'gallery' => '', 'icon' => 0,
        'excerpt' => 'Precast reinforced concrete U-Channels for open drainage, cable routes and service corridors, with optional cover slabs, manufactured in the UAE.',
        'overview' => "U-Channels are open-top reinforced concrete sections used for surface drainage, irrigation and cable or pipe corridors. They can be supplied with precast cover slabs to form a closed duct.\n\nPrecast Al Turab manufactures U-Channels in standard sizes and to project drawings, including heavy-duty sections for trafficked areas.",
        'apps' => 'Infrastructure, Utilities, Drainage, Industrial, Road Works',
        'material' => 'C40/50 or as specified',
        'specs' => [['Dimensions', 'Standard and custom; ' . $psd], ['Reinforcement', $psd], ['Wall Thickness', $pspec], ['Unit Weight', $pspec], ['Lifting System', 'Cast-in lifting anchors'], ['Cover Slabs', 'Available to match'], ['Quantity Capability', 'Full project lengths'], ['Customisation', 'Width, depth, length, load class']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for U-Channels.',
        'seo_title' => 'Precast U-Channel Manufacturer UAE | Precast Al Turab',
        'seo_desc' => 'Precast concrete U-Channels manufactured in the UAE for drainage and service corridors, with matching cover slabs. Standard and custom sizes. Request a quotation.',
        'faqs' => [
            ['Can U-Channels be supplied with covers?', 'Yes. Precast cover slabs are manufactured to suit the channel width and required load class.'],
            ['Are heavy-duty channels available for trafficked areas?', 'Yes. Wall thickness and reinforcement are increased according to the load specification.'],
        ],
    ],
    'c-type-structure' => [
        'title' => 'C-Type Structures', 'h1' => 'Precast C-Type Structures UAE', 'menu_order' => 8, 'cats' => ['culverts-channels', 'heavy-precast'], 'thumb' => 0, 'gallery' => '', 'icon' => 0,
        'excerpt' => 'Precast reinforced C-Type (three-sided) concrete structures for shelters, culverts and service tunnels, manufactured in the UAE to project drawings.',
        'overview' => "C-Type structures are three-sided reinforced concrete sections that combine the function of walls and roof in one unit. They are used as protective shelters, large culverts over existing beds, and service or pedestrian tunnels.\n\nUnits are heavy and are manufactured with project-specific moulds, reinforcement and lifting arrangements.",
        'apps' => 'Infrastructure, Security, Industrial, Utilities, Government Projects',
        'material' => 'C40/50 or as specified',
        'specs' => [['Dimensions', $psd], ['Reinforcement', $psd], ['Wall Thickness', $pspec], ['Unit Weight', $pspec . ' (heavy units)'], ['Lifting System', 'Cast-in lifting anchors, planned lifting'], ['Quantity Capability', 'Single units to project runs'], ['Customisation', 'Full']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for C-Type structures.',
        'seo_title' => 'Precast C-Type Structure Manufacturer UAE | Precast Al Turab',
        'seo_desc' => 'Precast three-sided C-Type concrete structures manufactured in the UAE for shelters, culverts and service tunnels. Custom moulds, heavy lifting, UAE delivery.',
        'faqs' => [
            ['What is a C-Type structure used for?', 'As a shelter, a large three-sided culvert, or a service tunnel where an open base is required.'],
            ['How are heavy C-Type units lifted?', 'With cast-in lifting anchors and a lifting plan agreed during technical review.'],
        ],
    ],
    'manhole' => [
        'title' => 'Manholes', 'h1' => 'Precast Manholes UAE', 'menu_order' => 9, 'cats' => ['manholes-utility-structures'], 'thumb' => 0, 'gallery' => '', 'icon' => 0,
        'excerpt' => 'Precast concrete manholes and chambers for sewerage, drainage and utility networks, manufactured in the UAE with cover slabs and step irons.',
        'overview' => "Precast manholes provide consistent wall thickness, accurate openings and fast installation for sewerage, storm water and utility networks. Units are supplied as base sections, rings or square chambers with matching cover slabs.\n\nPrecast Al Turab manufactures manholes to standard dimensions and to the project drawing, including pipe openings, benching and step irons.",
        'apps' => 'Utilities, Infrastructure, Drainage, Sewerage, Road Works, Industrial',
        'material' => 'C40/50, sulphate-resisting where specified',
        'specs' => [['Dimensions', 'Standard and custom chamber sizes'], ['Reinforcement', $psd], ['Wall Thickness', $pspec], ['Unit Weight', $pspec], ['Lifting System', 'Cast-in lifting anchors'], ['Accessories', 'Cover slabs, step irons, pipe openings'], ['Quantity Capability', 'Full network quantities'], ['Customisation', 'Depth, openings, benching']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for precast manholes.',
        'seo_title' => 'Precast Manhole Manufacturer UAE | Precast Al Turab',
        'seo_desc' => 'Precast concrete manholes and chambers manufactured in the UAE for sewerage, drainage and utility networks. Cover slabs, step irons, custom openings. Request a quotation.',
        'faqs' => [
            ['Do you supply manhole cover slabs?', 'Yes. Cover slabs are manufactured to suit the chamber and the specified load class.'],
            ['Can pipe openings be formed in the factory?', 'Yes. Openings are formed to the drawing so site cutting is avoided.'],
        ],
    ],
    'telecom-chamber' => [
        'title' => 'Telecom Chambers', 'h1' => 'Precast Telecom Chambers UAE', 'menu_order' => 10, 'cats' => ['manholes-utility-structures'], 'thumb' => 0, 'gallery' => '', 'icon' => 0,
        'excerpt' => 'Precast concrete telecom and cable chambers for fibre, power and utility networks, manufactured in the UAE to authority and project drawings.',
        'overview' => "Telecom chambers are precast concrete access chambers for fibre-optic, telecom and low-voltage cable networks. They are manufactured with duct entries, cable brackets and matching cover frames according to the network standard.\n\nUnits are supplied in standard chamber sizes or to the approved project drawing.",
        'apps' => 'Utilities, Telecom, Infrastructure, Commercial, Industrial',
        'material' => 'C40/50 or as specified',
        'specs' => [['Dimensions', 'Standard chamber types; ' . $psd], ['Reinforcement', $psd], ['Wall Thickness', $pspec], ['Unit Weight', $pspec], ['Lifting System', 'Cast-in lifting anchors'], ['Accessories', 'Duct entries, cover slabs, frames'], ['Quantity Capability', 'Full network quantities'], ['Customisation', 'Duct configuration, depth']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for telecom chambers.',
        'seo_title' => 'Precast Telecom Chamber Manufacturer UAE | Precast Al Turab',
        'seo_desc' => 'Precast concrete telecom and cable chambers manufactured in the UAE with duct entries and cover slabs. Standard types and custom chambers. Request a quotation.',
        'faqs' => [
            ['Can duct entries be pre-formed?', 'Yes. Duct entries are formed in the mould according to the network drawing.'],
        ],
    ],
    'cable-trough' => [
        'title' => 'Cable Troughs', 'h1' => 'Precast Cable Troughs UAE', 'menu_order' => 11, 'cats' => ['manholes-utility-structures'], 'thumb' => 0, 'gallery' => '', 'icon' => 0,
        'excerpt' => 'Precast concrete cable troughs with lids for power, rail and infrastructure cable routes, manufactured in the UAE in standard and custom sizes.',
        'overview' => "Cable troughs are precast channel sections with removable lids that protect power and control cables along roads, rail corridors and industrial sites. Units interlock to form continuous runs and allow easy cable access.\n\nPrecast Al Turab manufactures troughs and lids in standard sizes and to project drawings.",
        'apps' => 'Utilities, Rail, Infrastructure, Industrial, Oil & Gas',
        'material' => 'C40/50 or as specified',
        'specs' => [['Dimensions', 'Standard and custom'], ['Reinforcement', $psd], ['Unit Weight', $pspec], ['Lids', 'Precast lids to match'], ['Lifting System', 'Lifting slots or anchors'], ['Quantity Capability', 'Long continuous runs'], ['Customisation', 'Width, depth, length, lid type']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for cable troughs.',
        'seo_title' => 'Precast Cable Trough Manufacturer UAE | Precast Al Turab',
        'seo_desc' => 'Precast concrete cable troughs and lids manufactured in the UAE for power, rail and infrastructure cable routes. Standard and custom sizes. Request a quotation.',
        'faqs' => [
            ['Are lids included?', 'Yes. Precast lids are manufactured to match each trough size.'],
        ],
    ],
    'cover-slab' => [
        'title' => 'Cover Slabs', 'h1' => 'Precast Cover Slabs UAE', 'menu_order' => 12, 'cats' => ['manholes-utility-structures'], 'thumb' => 0, 'gallery' => '', 'icon' => 0,
        'excerpt' => 'Precast reinforced concrete cover slabs and roof slabs for chambers, channels, tanks and shelters, manufactured in the UAE to the required load class.',
        'overview' => "Cover slabs are reinforced concrete slabs used to close chambers, channels, tanks and culverts, and as roof slabs on precast shelters. They are manufactured to the required load class with openings for covers, vents and access.\n\nHeavy roof slabs for protective structures are manufactured with the same reinforcement and lifting controls as our heavy precast range.",
        'apps' => 'Utilities, Infrastructure, Drainage, Security, Industrial',
        'material' => 'C40/50 or as specified',
        'specs' => [['Dimensions', $psd], ['Reinforcement', $psd], ['Thickness', $pspec], ['Unit Weight', $pspec], ['Lifting System', 'Cast-in lifting anchors'], ['Openings', 'Formed as per drawing'], ['Quantity Capability', 'Full project quantities'], ['Customisation', 'Size, load class, openings']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for precast cover slabs.',
        'seo_title' => 'Precast Cover Slab Manufacturer UAE | Precast Al Turab',
        'seo_desc' => 'Precast reinforced concrete cover slabs and roof slabs manufactured in the UAE for chambers, channels, tanks and shelters. Any load class. Request a quotation.',
        'faqs' => [
            ['Can cover slabs be designed for vehicle loading?', 'Yes. Thickness and reinforcement are provided according to the specified load class.'],
        ],
    ],
    'pole-foundation' => [
        'title' => 'Pole Foundations', 'h1' => 'Precast Pole Foundations UAE', 'menu_order' => 13, 'cats' => ['manholes-utility-structures'], 'thumb' => 128, 'gallery' => '128,125', 'icon' => 124,
        'excerpt' => 'Precast concrete foundations for street lighting, signage, CCTV and utility poles, manufactured in the UAE with cast-in anchor bolts and conduits.',
        'overview' => "Precast pole foundations replace in-situ concrete bases for lighting columns, signs, cameras and fences. Anchor bolt clusters, conduits and lifting points are cast in at the factory so the foundation can be set and backfilled in one visit.\n\nPrecast Al Turab manufactures foundations to authority standards and to project drawings.",
        'apps' => 'Road Works, Infrastructure, Utilities, Commercial, Industrial',
        'material' => 'C40/50 or as specified',
        'specs' => [['Dimensions', 'Standard and project specific'], ['Reinforcement', $psd], ['Unit Weight', $pspec], ['Anchor Bolts', 'Cast-in to template'], ['Conduits', 'As per drawing'], ['Lifting System', 'Cast-in lifting anchors'], ['Quantity Capability', 'Bulk supply'], ['Customisation', 'Bolt pattern, depth, conduit layout']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for precast pole foundations.',
        'seo_title' => 'Precast Pole Foundation Manufacturer UAE | Precast Al Turab',
        'seo_desc' => 'Precast concrete pole foundations for lighting, signage and utility poles manufactured in the UAE with cast-in anchor bolts and conduits. Request a quotation.',
        'faqs' => [
            ['Can you match a specific anchor bolt template?', 'Yes. Bolt clusters are cast in to the template supplied with the pole or drawing.'],
        ],
    ],
    'custom-precast' => [
        'title' => 'Custom Precast Concrete', 'h1' => 'Custom Precast Concrete UAE', 'menu_order' => 14, 'cats' => ['custom-precast', 'heavy-precast'], 'thumb' => 15, 'gallery' => '15,14,13', 'icon' => 12,
        'excerpt' => 'Custom reinforced precast concrete products manufactured in the UAE from client drawings, BOQ and technical specifications, with in-house mould fabrication.',
        'overview' => "Many project requirements do not fit a standard product. Precast Al Turab manufactures custom reinforced precast elements, including structural panels, roof slabs, bases, plinths, tank sections and specialised protective units, from the client drawing.\n\nThe process covers technical review, mould engineering, reinforcement fabrication, casting, QA/QC, lifting and delivery, so one team is responsible from drawing to site.",
        'apps' => 'Infrastructure, Industrial, Oil & Gas, Security, Commercial, Government Projects',
        'material' => 'As specified',
        'specs' => [['Dimensions', $psd], ['Reinforcement', $psd], ['Wall Thickness', $pspec], ['Unit Weight', $pspec], ['Lifting System', 'Designed per unit'], ['Embedded Items', 'As per drawing'], ['Quantity Capability', 'Single units to repeat production'], ['Customisation', 'Full']],
        'wa' => 'Hello Precast Al Turab, I need a quotation for a custom precast product.',
        'seo_title' => 'Custom Precast Concrete Manufacturer UAE | Precast Al Turab',
        'seo_desc' => 'Custom reinforced precast concrete manufactured in the UAE from your drawings and BOQ. In-house moulds, heavy reinforcement, QA/QC, lifting and delivery. Send your drawing.',
        'faqs' => [
            ['What do you need from us to quote a custom item?', 'A drawing or sketch with dimensions, the concrete and reinforcement requirement if known, quantity, and the delivery location. We confirm the rest during technical review.'],
            ['Is there a minimum quantity?', 'No. Single units are manufactured, although mould cost is shared across larger quantities.'],
            ['Can you produce shop drawings?', 'Yes. Shop drawings and technical submittals can be prepared for consultant approval when requested.'],
        ],
    ],
];

$pid_by_slug = [];
foreach ($products as $slug => $p) {
    $existing = get_page_by_path($slug, OBJECT, 'sp_product');
    $faqs = array_merge($p['faqs'], $common_faq_tail);
    $data = [
        'post_type' => 'sp_product', 'post_status' => 'publish', 'post_name' => $slug,
        'post_title' => $p['title'], 'post_excerpt' => $p['excerpt'], 'post_content' => '', 'menu_order' => $p['menu_order'],
    ];
    if ($existing) { $data['ID'] = $existing->ID; $id = wp_update_post($data); }
    else { $id = wp_insert_post($data); }
    if (!$id || is_wp_error($id)) { $log("FAILED product $slug"); continue; }
    $pid_by_slug[$slug] = $id;
    wp_set_object_terms($id, array_map(fn($c) => $cat_ids[$c], $p['cats']), 'sp_product_cat');
    update_post_meta($id, '_sp_overview', $p['overview']);
    update_post_meta($id, '_sp_applications', $p['apps']);
    update_post_meta($id, '_sp_product_material', $p['material']);
    update_post_meta($id, '_sp_product_finish', 'As-cast concrete finish (other finishes on request)');
    update_post_meta($id, '_sp_product_specs', wp_json_encode($p['specs'], JSON_UNESCAPED_UNICODE));
    update_post_meta($id, '_sp_faqs', wp_json_encode($faqs, JSON_UNESCAPED_UNICODE));
    update_post_meta($id, '_sp_wa_message', $p['wa']);
    update_post_meta($id, '_sp_seo_title', $p['seo_title']);
    update_post_meta($id, '_sp_seo_desc', $p['seo_desc']);
    update_post_meta($id, '_sp_h1', $p['h1']);
    update_post_meta($id, '_sp_product_certifications', '');
    if ($p['thumb']) set_post_thumbnail($id, $p['thumb']); else delete_post_thumbnail($id);
    update_post_meta($id, '_sp_product_gallery', $p['gallery']);
    if ($p['icon']) update_post_meta($id, '_sp_product_icon', $p['icon']);
    delete_post_meta($id, '_sp_product_model_id');
    delete_post_meta($id, 'sp_model_url');
    $log("Product OK: $slug (#$id)");
}

// Small / legacy products → Standard Products / Logistics, pushed to the end
$legacy = ['wheel-stopper' => 'standard-products', 'masonry-block' => 'standard-products', 'hoarding-block' => 'standard-products', 'plastic-barrier' => 'standard-products', 'fence-base' => 'standard-products', 'ac-slab' => 'standard-products', 'light-footing' => 'manholes-utility-structures', 'cable-marker' => 'standard-products', 'paving-slab' => 'standard-products', 'traffic-cone' => 'standard-products', 'bulk-logistics' => 'logistics-services', 'relocation' => 'logistics-services', 'consolidated-delivery' => 'logistics-services'];
$order = 50;
foreach ($legacy as $slug => $cat) {
    $p = get_page_by_path($slug, OBJECT, 'sp_product');
    if (!$p) continue;
    wp_set_object_terms($p->ID, [$cat_ids[$cat]], 'sp_product_cat');
    wp_update_post(['ID' => $p->ID, 'menu_order' => $order++]);
    delete_post_meta($p->ID, '_sp_product_model_id');
    delete_post_meta($p->ID, 'sp_model_url');
}
// Light footing duplicates pole-foundation → keep but unpublish to avoid duplicate pages
if ($lf = get_page_by_path('light-footing', OBJECT, 'sp_product')) wp_update_post(['ID' => $lf->ID, 'post_status' => 'draft']);
// Remove now-empty old categories
foreach (get_terms(['taxonomy' => 'sp_product_cat', 'hide_empty' => false]) as $t) {
    if (!isset($prod_cats[$t->slug]) && (int) $t->count === 0) wp_delete_term($t->term_id, 'sp_product_cat');
}
$log('Legacy products re-categorised');

// ─────────────────────────────────────────────────────────────────────────────
// 3. Project categories (6 filters) + re-assignment
// ─────────────────────────────────────────────────────────────────────────────
$proj_cats = ['heavy-precast' => 'Heavy Precast', 'infrastructure' => 'Infrastructure', 'industrial' => 'Industrial', 'security' => 'Security', 'commercial' => 'Commercial', 'utilities' => 'Utilities'];
$pc_ids = [];
foreach ($proj_cats as $slug => $name) {
    $t = get_term_by('slug', $slug, 'sp_project_cat');
    if ($t) { $pc_ids[$slug] = $t->term_id; wp_update_term($t->term_id, 'sp_project_cat', ['name' => $name]); }
    else { $r = wp_insert_term($name, 'sp_project_cat', ['slug' => $slug]); $pc_ids[$slug] = is_wp_error($r) ? 0 : $r['term_id']; }
}
// slug => [cats, product supplied, quantity]
$proj_map = [
    'opus-tower-parking'                 => [['commercial'],                 'Parking Wheel Stoppers',                 ''],
    'dubai-hills-estate'                 => [['commercial', 'infrastructure'], 'Precast Blocks & Barriers',           ''],
    'yas-marina-circuit'                 => [['infrastructure', 'security'], 'Concrete Safety Barriers',               ''],
    'atlantis-the-royal'                 => [['commercial'],                 'Precast Parking Products',               ''],
    'etihad-rail-network'                => [['infrastructure', 'utilities'],'Concrete Barriers & Utility Precast',    ''],
    'sheikh-mbd-road'                    => [['infrastructure'],             'Jersey Barriers',                        ''],
    'sharjah-industrial-zone-perimeter'  => [['industrial', 'security'],     'Perimeter Barriers',                     ''],
    'jebel-ali-port-perimeter'           => [['security', 'infrastructure'], 'Security Perimeter Barriers',            ''],
    'etihad-rail-phase-2'                => [['infrastructure'],             'Safety Corridor Barriers',               ''],
    'expo-city-dubai-perimeter'          => [['commercial', 'security'],     'Perimeter Hoarding Blocks & Barriers',   ''],
    'yas-island-aldar-residential'       => [['commercial'],                 'Masonry Blocks',                         ''],
    'damac-hills-community'              => [['commercial'],                 'Masonry Blocks',                         ''],
    'sheikh-mbd-road-expansion'          => [['infrastructure'],             'Jersey Barriers',                        ''],
    'al-maktoum-airport-road'            => [['infrastructure'],             'Jersey Barriers',                        ''],
];
foreach ($proj_map as $slug => [$cats, $product, $qty]) {
    $p = get_page_by_path($slug, OBJECT, 'sp_project');
    if (!$p) { $log("project missing: $slug"); continue; }
    wp_set_object_terms($p->ID, array_map(fn($c) => $pc_ids[$c], $cats), 'sp_project_cat');
    if (!get_post_meta($p->ID, '_sp_project_product', true)) update_post_meta($p->ID, '_sp_project_product', $product);
    if ($qty) update_post_meta($p->ID, '_sp_project_quantity', $qty);
    // Contract value is not a verifiable public figure → do not display
    delete_post_meta($p->ID, '_sp_project_value');
}
foreach (get_terms(['taxonomy' => 'sp_project_cat', 'hide_empty' => false]) as $t) {
    if (!isset($proj_cats[$t->slug])) wp_delete_term($t->term_id, 'sp_project_cat');
}
$log('Projects re-categorised');

// ─────────────────────────────────────────────────────────────────────────────
// 4. Pages
// ─────────────────────────────────────────────────────────────────────────────
$row = fn($inner) => '[vc_row full_width="stretch_row_content_no_spaces" el_class="no-pad-row"][vc_column]' . $inner . '[/vc_column][/vc_row]';
$upsert_page = function ($slug, $title, $content, $extra = []) use ($log) {
    $existing = get_page_by_path($slug, OBJECT, 'page');
    $data = array_merge(['post_type' => 'page', 'post_status' => 'publish', 'post_name' => $slug, 'post_title' => $title, 'post_content' => $content], $extra);
    if ($existing) { $data['ID'] = $existing->ID; $id = wp_update_post($data); } else { $id = wp_insert_post($data); }
    update_post_meta($id, '_sp_hide_inquiry', '1');
    $log("Page OK: $slug (#$id)");
    return $id;
};

// Home (ID 36 "Al Turab")
$home = $row('[sublime_hero_heavy bg_image_id="13"]')
      . $row('[sublime_capability_bar]')
      . $row('[sublime_systems]')
      . $row('[sublime_heavy_feature image_id="14"]')
      . $row('[sublime_process]')
      . $row('[sublime_featured_projects count="4"]')
      . $row('[sublime_why]')
      . $row('[sublime_qaqc]')
      . $row('[sublime_partners]')
      . $row('[sublime_resources_teaser]')
      . $row('[sublime_final_cta]');
$home_id = $upsert_page('al-turab', 'Precast Al Turab — Heavy-Duty Precast Concrete Manufacturing in the UAE', $home);
update_option('page_on_front', $home_id); update_option('show_on_front', 'page');
update_post_meta($home_id, '_sp_seo_title', 'Precast Concrete Manufacturer UAE | Bunkers, T-Walls & Barriers | Precast Al Turab');
update_post_meta($home_id, '_sp_seo_desc', 'Precast Al Turab manufactures reinforced precast concrete products in the UAE including bunkers, T-Walls, barriers, box culverts, chambers and custom precast structures. Request a quotation.');

// About
$about = $row('[sublime_page_hero eyebrow="About Precast Al Turab" heading="UAE Precast Manufacturing for Complex Project Requirements" subtext="Precast Al Turab is a UAE-based precast concrete manufacturing company serving construction, infrastructure, industrial and specialised projects." bg_image_id="15"]')
       . $row('[sublime_text_block eyebrow="Who We Are" heading="Beyond Standard Concrete Products" image_id="13" img_pos="right" cta_text="See Our Capabilities" cta_url="/capabilities/"]Our focus extends beyond standard concrete products. We manufacture project-specific reinforced precast components where dimensional accuracy, structural reinforcement, mould engineering, lifting and production planning are critical.

From protective bunkers and T-Walls to box culverts, chambers and custom structural elements, our team supports projects from drawing review and mould fabrication through production, lifting and delivery.

We work with government bodies, main contractors, consultants, civil engineers, infrastructure contractors, industrial companies and security projects across the UAE.[/sublime_text_block]')
       . $row('[sublime_about_capabilities]')
       . $row('[sublime_stats eyebrow="Company" heading="Precast Al Turab in Numbers" bg="dark" stats="%5B%7B%22number%22%3A%2225000%22%2C%22label%22%3A%22SQ.%20METRE%20FACILITY%22%7D%2C%7B%22number%22%3A%222015%22%2C%22label%22%3A%22ESTABLISHED%22%7D%2C%7B%22number%22%3A%227%22%2C%22label%22%3A%22EMIRATES%20SERVED%22%7D%2C%7B%22number%22%3A%2214%22%2C%22suffix%22%3A%22%2B%22%2C%22label%22%3A%22PRODUCT%20LINES%22%7D%5D"]')
       . $row('[sublime_process bg="light"]')
       . $row('[sublime_qaqc]')
       . $row('[sublime_partners]')
       . $row('[sublime_final_cta]');
$about_id = $upsert_page('about-us', 'About Us', $about);
update_post_meta($about_id, '_sp_seo_title', 'About Precast Al Turab | UAE Precast Concrete Manufacturer');
update_post_meta($about_id, '_sp_seo_desc', 'Precast Al Turab is a UAE precast concrete manufacturer of project-specific reinforced components: heavy precast, custom moulds, reinforcement, casting, QA/QC, lifting and logistics.');

// Capabilities
$cap = $row('[sublime_page_hero eyebrow="Capabilities" heading="Complete Precast Manufacturing Capability" subtext="Technical review, mould fabrication, reinforcement, casting, quality control, custom manufacturing, heavy lifting and logistics — managed by one team." bg_image_id="14"]')
     . $row('[sublime_capabilities]')
     . $row('[sublime_process bg="dark"]')
     . $row('[sublime_qaqc]')
     . $row('[sublime_final_cta]');
$cap_id = $upsert_page('capabilities', 'Capabilities', $cap);
update_post_meta($cap_id, '_sp_seo_title', 'Precast Manufacturing Capabilities UAE | Precast Al Turab');
update_post_meta($cap_id, '_sp_seo_desc', 'Complete precast concrete manufacturing capability in the UAE: technical review, custom mould fabrication, reinforcement, casting, QA/QC, heavy lifting and logistics.');

// Technical resources
$tr = $row('[sublime_page_hero eyebrow="Downloads" heading="Technical Resources" subtext="Company profile, product data sheets, method statements, lifting guidelines and certificates for engineers, consultants and procurement teams." show_cta="1"]')
    . $row('[sublime_tech_resources]')
    . $row('[sublime_final_cta heading="Need a Document That Is Not Listed?" subheading="Request technical data, submittals or certificates"]');
$tr_id = $upsert_page('technical-resources', 'Technical Resources', $tr);
update_post_meta($tr_id, '_sp_seo_title', 'Technical Resources & Data Sheets | Precast Al Turab UAE');
update_post_meta($tr_id, '_sp_seo_desc', 'Download or request Precast Al Turab company profile, precast product data sheets, method statements, lifting guidelines, material submittals and certificates.');

// Request quotation
$rfq = $row('[sublime_page_hero eyebrow="RFQ" heading="Request a Precast Quotation" subtext="Send your drawing, BOQ or technical specification. Our team reviews dimensions, concrete, reinforcement, quantity, moulds, lifting and transport, then responds with a quotation." show_cta="0"]')
     . '[vc_row][vc_column][sublime_rfq_form heading="" subtext=""][/vc_column][/vc_row]';
$rfq_id = $upsert_page('request-quotation', 'Request Quotation', $rfq);
update_post_meta($rfq_id, '_sp_seo_title', 'Request a Precast Concrete Quotation UAE | Precast Al Turab');
update_post_meta($rfq_id, '_sp_seo_desc', 'Request a quotation for precast bunkers, T-Walls, barriers, box culverts, manholes or custom precast. Upload drawings, BOQ and specifications. UAE manufacturing.');

// Contact
$contact = $row('[sublime_page_hero eyebrow="Contact" heading="Contact Us" subtext="Phone, WhatsApp, email, office and factory location, business hours and a direct quotation form." show_cta="0"]')
         . $row('[sublime_contact_pc]');
$contact_id = $upsert_page('contact-us', 'Contact Us', $contact);
update_post_meta($contact_id, '_sp_seo_title', 'Contact Precast Al Turab | UAE Precast Concrete Manufacturer');
update_post_meta($contact_id, '_sp_seo_desc', 'Contact Precast Al Turab by phone, WhatsApp or email. Office in Mohamed Bin Zayed City, Abu Dhabi; factory in Sharjah. Request a precast quotation.');

// Privacy + Terms (plain pages)
$privacy = "<h2>Privacy Policy</h2><p>Precast Al Turab (Al Turab Concrete Products Manufacturing L.L.C. S.P.) respects your privacy. This policy explains what information we collect through precastalturab.ae and how it is used.</p><h3>Information we collect</h3><p>When you submit a quotation request or contact form we collect the details you provide: company name, contact person, phone number, email address, project information, messages and any files you upload (drawings, BOQs, specifications).</p><h3>How we use it</h3><p>Your information is used only to prepare and follow up your quotation, to respond to your enquiry and to deliver products or services you order. We do not sell or share your information with third parties for marketing.</p><h3>Files you upload</h3><p>Uploaded drawings and documents are stored securely, used only for technical review and quotation, and treated as confidential.</p><h3>Analytics</h3><p>We may use Google Analytics to understand how visitors use the website. This data is aggregated and does not identify you personally.</p><h3>Contact</h3><p>For any privacy request, email info@precastalturab.ae.</p>";
$privacy_id = $upsert_page('privacy-policy', 'Privacy Policy', $privacy);
update_option('wp_page_for_privacy_policy', $privacy_id);
$terms = "<h2>Terms &amp; Conditions</h2><p>These terms apply to the use of precastalturab.ae and to quotations issued by Precast Al Turab (Al Turab Concrete Products Manufacturing L.L.C. S.P.).</p><h3>Website content</h3><p>Product information, dimensions and technical data shown on this website are indicative. Values described as Project Specific or According to Approved Structural Drawing are confirmed in writing for each project. Nothing on this website constitutes a structural design or warranty.</p><h3>Quotations</h3><p>Quotations are valid for the period stated on the quotation and are subject to final approved drawings, quantities, delivery location and payment terms agreed in writing.</p><h3>Intellectual property</h3><p>Photographs, text and drawings on this website belong to Precast Al Turab unless otherwise stated and may not be reproduced without permission.</p><h3>Governing law</h3><p>These terms are governed by the laws of the United Arab Emirates.</p>";
$upsert_page('terms-and-conditions', 'Terms & Conditions', $terms);

// ─────────────────────────────────────────────────────────────────────────────
// 5. Menu
// ─────────────────────────────────────────────────────────────────────────────
$menu = wp_get_nav_menu_object('main-menu') ?: wp_get_nav_menu_object('Main Menu');
if (!$menu) { $mid = wp_create_nav_menu('Main Menu'); $menu = wp_get_nav_menu_object($mid); }
foreach (wp_get_nav_menu_items($menu->term_id) ?: [] as $it) wp_delete_post($it->ID, true);
$items = [
    ['Home', 'custom', home_url('/')],
    ['About Us', 'page', $about_id],
    ['Products', 'custom', get_post_type_archive_link('sp_product')],
    ['Projects', 'custom', get_post_type_archive_link('sp_project')],
    ['Capabilities', 'page', $cap_id],
    ['Technical Resources', 'page', $tr_id],
    ['Contact', 'page', $contact_id],
];
$pos = 1;
foreach ($items as [$label, $type, $ref]) {
    $args = ['menu-item-title' => $label, 'menu-item-status' => 'publish', 'menu-item-position' => $pos++];
    if ($type === 'page') { $args += ['menu-item-type' => 'post_type', 'menu-item-object' => 'page', 'menu-item-object-id' => $ref]; }
    else { $args += ['menu-item-type' => 'custom', 'menu-item-url' => $ref]; }
    wp_update_nav_menu_item($menu->term_id, 0, $args);
}
$locs = get_theme_mod('nav_menu_locations', []);
$locs['main-menu'] = $menu->term_id; $locs['primary-menu'] = $menu->term_id; $locs['mobile-menu'] = $menu->term_id;
set_theme_mod('nav_menu_locations', $locs);
$log('Menu rebuilt');

// ─────────────────────────────────────────────────────────────────────────────
// 6. Theme mods / options
// ─────────────────────────────────────────────────────────────────────────────
set_theme_mod('sp_footer_phone', '+971 54 350 7724');
set_theme_mod('sp_footer_whatsapp', 'https://wa.me/971543507724');
set_theme_mod('sp_footer_email', 'info@precastalturab.ae');
set_theme_mod('sp_footer_tagline', 'UAE Precast Concrete Manufacturing');
set_theme_mod('sp_footer_address', 'MAZYAD Offices 2, 75 Sultan Bin Mohammed Al Qubaisi St (Street 207), Mohamed Bin Zayed City, Abu Dhabi 20614, UAE');
set_theme_mod('sp_factory_address', 'Al Sajaa Industrial Area, Sharjah, UAE');
set_theme_mod('sp_hours', 'Mon – Sat: 8:00 AM – 6:00 PM');
set_theme_mod('sp_legal_name', 'Al Turab Concrete Products Manufacturing L.L.C. S.P.');
if (!get_theme_mod('custom_logo')) {
    $logo = (int) get_option('site_logo');
    if (!$logo && ($l = get_page_by_title('cropped-turab.png', OBJECT, 'attachment'))) $logo = $l->ID;
    if ($logo) set_theme_mod('custom_logo', $logo);
}
update_option('blogdescription', 'Heavy-Duty Precast Concrete Manufacturing in the UAE');
flush_rewrite_rules();
$log('Done. Theme mods + rewrite flushed.');
