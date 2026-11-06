<?php
/**
 * Precast — RFQ / Upload Drawing form (Brief: Priority 17)
 *
 * Pre-fills from ?product= ?project= ?intent= query args (Priority 31/32).
 *
 * @package SublimePlusV2
 */
defined('ABSPATH') || exit;

$a = wp_parse_args($args ?? [], ['compact' => false, 'heading' => 'Request a Precast Quotation', 'subtext' => '']);
$fields  = sp_rfq_fields();
$checks  = sp_rfq_checkboxes();
$pre_product = sanitize_text_field(wp_unslash($_GET['product'] ?? ''));
$pre_project = sanitize_text_field(wp_unslash($_GET['project'] ?? ''));
$pre_intent  = sanitize_text_field(wp_unslash($_GET['intent']  ?? ''));
$max = size_format(sp_rfq_max_bytes());
$uid = 'rfq' . wp_rand(100, 999);
?>
<div class="pc-rfq<?php echo $a['compact'] ? ' pc-rfq--compact' : ''; ?>" id="rfq-form">
  <?php if ($a['heading']) : ?>
  <div class="pc-rfq__head">
    <h2 class="pc-rfq__title"><?php echo esc_html($a['heading']); ?></h2>
    <?php if ($a['subtext']) : ?><p><?php echo esc_html($a['subtext']); ?></p><?php endif; ?>
    <?php if ($pre_product || $pre_project || $pre_intent) : ?>
    <p class="pc-rfq__context"><?php echo sp_icon('check', 14); ?>
      <?php if ($pre_intent)  echo '<span>' . esc_html($pre_intent) . '</span>'; ?>
      <?php if ($pre_product) echo '<span>Product: ' . esc_html($pre_product) . '</span>'; ?>
      <?php if ($pre_project) echo '<span>Reference project: ' . esc_html($pre_project) . '</span>'; ?>
    </p>
    <?php endif; ?>
  </div>
  <?php endif; ?>

  <form class="pc-rfq__form" method="post" enctype="multipart/form-data" novalidate data-rfq>
    <input type="hidden" name="action" value="sp_rfq_submit">
    <input type="hidden" name="sp_nonce" value="<?php echo esc_attr(wp_create_nonce('sp_rfq_nonce')); ?>">
    <input type="hidden" name="reference_project" value="<?php echo esc_attr($pre_project); ?>">
    <input type="hidden" name="intent" value="<?php echo esc_attr($pre_intent); ?>">
    <input type="hidden" name="source_url" value="<?php echo esc_url((is_ssl() ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '')); ?>">
    <div class="pc-rfq__hp" aria-hidden="true"><label>Website<input type="text" name="website_url" tabindex="-1" autocomplete="off"></label></div>

    <div class="pc-rfq__grid">
      <?php foreach ($fields as $key => $f) :
        $id  = $uid . '-' . $key;
        $val = ($key === 'product') ? $pre_product : '';
        $req = $f['required'] ? ' required' : '';
        $wide = in_array($key, ['message'], true) ? ' pc-rfq__field--wide' : '';
      ?>
      <div class="pc-rfq__field<?php echo $wide; ?>">
        <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($f['label']); ?><?php if ($f['required']) : ?> <em>*</em><?php endif; ?></label>
        <?php if ($f['type'] === 'textarea') : ?>
          <textarea id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($key); ?>" rows="<?php echo $a['compact'] ? 3 : 5; ?>"<?php echo $req; ?> placeholder="Dimensions, concrete grade, reinforcement, quantity, lifting, transport or any other requirement."></textarea>
        <?php elseif ($f['type'] === 'select') : ?>
          <select id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($key); ?>"<?php echo $req; ?>>
            <option value="">Select…</option>
            <?php foreach ($f['options'] as $opt) : ?><option value="<?php echo esc_attr($opt); ?>"><?php echo esc_html($opt); ?></option><?php endforeach; ?>
          </select>
        <?php else : ?>
          <input type="<?php echo esc_attr($f['type']); ?>" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($val); ?>"<?php echo $req; ?><?php if ($key === 'product') : ?> list="<?php echo esc_attr($uid); ?>-products" placeholder="e.g. Precast Bunker, T-Wall, Box Culvert"<?php endif; ?><?php if ($key === 'quantity') : ?> placeholder="e.g. 120 units / 300 m"<?php endif; ?><?php if ($key === 'phone') : ?> placeholder="+971 5X XXX XXXX"<?php endif; ?>>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>

    <datalist id="<?php echo esc_attr($uid); ?>-products">
      <?php foreach (get_posts(['post_type' => 'sp_product', 'posts_per_page' => 40, 'orderby' => 'title', 'order' => 'ASC']) as $pp) : ?>
      <option value="<?php echo esc_attr($pp->post_title); ?>"></option>
      <?php endforeach; ?>
    </datalist>

    <fieldset class="pc-rfq__checks">
      <legend>Project requirements</legend>
      <?php foreach ($checks as $k => $label) : ?>
      <label><input type="checkbox" name="req[<?php echo esc_attr($k); ?>]" value="1"><span><?php echo esc_html($label); ?></span></label>
      <?php endforeach; ?>
    </fieldset>

    <div class="pc-rfq__files" id="rfq-files">
      <label for="<?php echo esc_attr($uid); ?>-files" class="pc-rfq__drop">
        <?php echo sp_icon('upload', 28); ?>
        <strong>Upload drawings, BOQ or specifications</strong>
        <span>PDF, DWG, DXF, Excel, Word, JPG, PNG, ZIP — up to <?php echo esc_html($max); ?> per file, maximum 10 files</span>
        <input type="file" id="<?php echo esc_attr($uid); ?>-files" name="files[]" multiple accept=".pdf,.dwg,.dxf,.xls,.xlsx,.csv,.doc,.docx,.jpg,.jpeg,.png,.webp,.zip,.rar,.7z">
      </label>
      <ul class="pc-rfq__filelist" aria-live="polite"></ul>
    </div>

    <div class="pc-rfq__actions">
      <button type="submit" class="pc-btn pc-btn--accent pc-btn--lg"><?php echo sp_icon('quote', 18); ?> <span>Submit Quotation Request</span></button>
      <a class="pc-btn pc-btn--wa" href="<?php echo esc_url(sp_wa_url($pre_product ? 'Hello Precast Al Turab, I need a quotation for ' . $pre_product . '.' : '')); ?>" target="_blank" rel="noopener" data-track="whatsapp_click"><?php echo sp_icon('whatsapp', 18); ?> <span>Or WhatsApp Our Team</span></a>
    </div>
    <p class="pc-rfq__note">Your information is used only to prepare your quotation and is not shared with third parties.</p>
    <div class="pc-rfq__msg" role="status" aria-live="polite"></div>
  </form>
</div>
