<?php
/**
 * Precast — "Request a Project Quote" form, laid out like the reference site
 * (precastuae.ae/contact/): 1 Contact · 2 Project (Product Interest cards) · 3 Details.
 * A drawing upload is kept in step 3 so the site's "Send Drawing" links land here.
 *
 * Pre-fills from ?product= ?project= ?intent= query args.
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$a = wp_parse_args($args ?? [], ['compact' => false, 'heading' => 'Request a Project Quote', 'subtext' => '']);
if ($a['heading'] === '') $a['heading'] = 'Request a Project Quote';
if ($a['subtext'] === '') $a['subtext'] = "Share your requirements and we'll get back to you within 24 hours.";

$fields   = sp_rfq_fields();
$cards    = sp_rfq_products();
$pre_text = sanitize_text_field(wp_unslash($_GET['product'] ?? ''));
$pre_proj = sanitize_text_field(wp_unslash($_GET['project'] ?? ''));
$pre_int  = sanitize_text_field(wp_unslash($_GET['intent']  ?? ''));
$pre_slug = sp_rfq_match_product($pre_text);
$pre_msg  = trim(implode("\n", array_filter([
    ($pre_text && (!$pre_slug || $cards[$pre_slug][0] !== $pre_text)) ? 'Product: ' . $pre_text : '',
    $pre_proj ? 'Reference project: ' . $pre_proj : '',
])));
$max = size_format(sp_rfq_max_bytes());
$uid = 'rfq' . wp_rand(100, 999);

$render_field = function (string $key, array $f) use ($uid, $pre_msg) {
    $id  = $uid . '-' . $key;
    $req = $f['required'] ? ' required' : '';
    echo '<div class="pc-rfq__field' . ($f['type'] === 'textarea' ? ' pc-rfq__field--wide' : '') . '">';
    echo '<label for="' . esc_attr($id) . '">' . esc_html($f['label']) . ($f['required'] ? ' <em>*</em>' : '') . '</label>';
    if ($f['type'] === 'textarea') {
        echo '<textarea id="' . esc_attr($id) . '" name="' . esc_attr($key) . '" rows="4" placeholder="' . esc_attr($f['ph']) . '"' . $req . '>' . esc_textarea($pre_msg) . '</textarea>';
    } elseif ($f['type'] === 'select') {
        echo '<select id="' . esc_attr($id) . '" name="' . esc_attr($key) . '"' . $req . '><option value="">' . esc_html($f['ph']) . '</option>';
        foreach ($f['options'] as $o) echo '<option value="' . esc_attr($o) . '">' . esc_html($o) . '</option>';
        echo '</select>';
    } else {
        echo '<input type="' . esc_attr($f['type']) . '" id="' . esc_attr($id) . '" name="' . esc_attr($key) . '" placeholder="' . esc_attr($f['ph']) . '"' . $req . ($key === 'phone' ? ' autocomplete="tel"' : '') . ($key === 'email' ? ' autocomplete="email"' : '') . ($key === 'contact' ? ' autocomplete="name"' : '') . '>';
    }
    echo '</div>';
};
?>
<div class="pc-rfq<?php echo $a['compact'] ? ' pc-rfq--compact' : ''; ?>" id="rfq-form">
  <div class="pc-rfq__head">
    <h2 class="pc-rfq__title"><?php echo esc_html($a['heading']); ?></h2>
    <p><?php echo esc_html($a['subtext']); ?></p>
    <?php if ($pre_proj || $pre_int) : ?>
    <p class="pc-rfq__context"><?php echo sp_icon('check', 14); ?>
      <?php if ($pre_int)  echo '<span>' . esc_html($pre_int) . '</span>'; ?>
      <?php if ($pre_proj) echo '<span>Reference project: ' . esc_html($pre_proj) . '</span>'; ?>
    </p>
    <?php endif; ?>
  </div>

  <form class="pc-rfq__form" method="post" enctype="multipart/form-data" novalidate data-rfq>
    <input type="hidden" name="action" value="sp_rfq_submit">
    <input type="hidden" name="sp_nonce" value="<?php echo esc_attr(wp_create_nonce('sp_rfq_nonce')); ?>">
    <input type="hidden" name="reference_project" value="<?php echo esc_attr($pre_proj); ?>">
    <input type="hidden" name="intent" value="<?php echo esc_attr($pre_int); ?>">
    <input type="hidden" name="source_url" value="<?php echo esc_url((is_ssl() ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '')); ?>">
    <div class="pc-rfq__hp" aria-hidden="true"><label>Website<input type="text" name="website_url" tabindex="-1" autocomplete="off"></label></div>

    <!-- 1 Contact -->
    <fieldset class="pc-rfq__step">
      <legend><span class="pc-rfq__num">1</span> Contact</legend>
      <div class="pc-rfq__grid pc-rfq__grid--3">
        <?php foreach ($fields as $k => $f) if ($f['step'] === 1) $render_field($k, $f); ?>
      </div>
    </fieldset>

    <!-- 2 Project -->
    <fieldset class="pc-rfq__step">
      <legend><span class="pc-rfq__num">2</span> Project</legend>
      <p class="pc-rfq__label">Product Interest <em>*</em> <small>Select all that apply</small></p>
      <div class="pc-pi" role="group" aria-label="Product interest">
        <?php foreach ($cards as $slug => [$label, $img_id]) : $img = sp_img_url($img_id, 'thumbnail'); ?>
        <label class="pc-pi__card">
          <input type="checkbox" name="products[]" value="<?php echo esc_attr($slug); ?>"<?php checked($slug, $pre_slug); ?>>
          <span class="pc-pi__thumb"><?php if ($img) : ?><img src="<?php echo esc_url($img); ?>" alt="" width="48" height="42" loading="lazy" decoding="async"><?php else : echo sp_icon('box', 24); endif; ?></span>
          <span class="pc-pi__name"><?php echo esc_html($label); ?></span>
          <span class="pc-pi__check" aria-hidden="true"><?php echo sp_icon('check', 12); ?></span>
        </label>
        <?php endforeach; ?>
      </div>
      <div class="pc-rfq__grid pc-rfq__grid--2">
        <?php foreach ($fields as $k => $f) if ($f['step'] === 2) $render_field($k, $f); ?>
      </div>
    </fieldset>

    <!-- 3 Details -->
    <fieldset class="pc-rfq__step">
      <legend><span class="pc-rfq__num">3</span> Details</legend>
      <div class="pc-rfq__grid">
        <?php foreach ($fields as $k => $f) if ($f['step'] === 3) $render_field($k, $f); ?>
      </div>
      <div class="pc-rfq__files" id="rfq-files">
        <label for="<?php echo esc_attr($uid); ?>-files" class="pc-rfq__drop">
          <?php echo sp_icon('upload', 24); ?>
          <strong>Attach drawings or BOQ (optional)</strong>
          <span>PDF, DWG, DXF, Excel, Word, JPG, PNG, ZIP — up to <?php echo esc_html($max); ?> per file, max 10 files</span>
          <input type="file" id="<?php echo esc_attr($uid); ?>-files" name="files[]" multiple accept=".pdf,.dwg,.dxf,.xls,.xlsx,.csv,.doc,.docx,.jpg,.jpeg,.png,.webp,.zip,.rar,.7z">
        </label>
        <ul class="pc-rfq__filelist" aria-live="polite"></ul>
      </div>
    </fieldset>

    <div class="pc-rfq__actions">
      <button type="submit" class="pc-btn pc-btn--accent pc-btn--lg pc-btn--block"><?php echo sp_icon('quote', 18); ?> <span>Submit Inquiry</span></button>
    </div>
    <p class="pc-rfq__note"><?php echo sp_icon('shield', 14); ?> Your information is secure and will not be shared.</p>
    <div class="pc-rfq__msg" role="status" aria-live="polite"></div>
  </form>
</div>
