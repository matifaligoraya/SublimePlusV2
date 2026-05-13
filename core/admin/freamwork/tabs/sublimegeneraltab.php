<?php
require_once SUBLIMEPLUS_DIR . 'core/admin/freamwork/sublimebasetab.php'; // If SublimeBaseTab is in the same directory
class SublimeGeneralTab extends SublimeBaseTab {

    public function getTitle() {
        return __('General', 'sublimeplus');
    }
    public function renderopen()
        {
            echo '<div class="tab-pane active show" id="general-settings" role="tabpanel" aria-labelledby="general-settings_">';
            echo '<div class="bd-example bg-light p-3 f-18 border">';
            echo '<caption>'. esc_html_e( $this->getTitle(). ' Options', 'sublimeplus') . '</caption>';
            echo '</div><div class="highlight pan">' ;
        }
        public function renderclsoe()
        {
            echo ' </div></div>';
        }
    public function render() {
        // Render the form fields specific for General Tab
        $this->renderopen();
        ?>

<div class="mb-3">
    <?php $enable_mega_menu = intval($this->getValue('enable_builtin_mega_menu')) ?>
    <label for="enable_builtin_mega_menu"
        class="form-label"><?php esc_html_e('Enable Built-in Mega Menu Editor', 'sublimeplus') ?></label>
    <div class="form-check">
        <input type="checkbox" class="" id="enable_builtin_mega_menu"
            name="<?php echo esc_attr($this->getName('enable_builtin_mega_menu')) ?>" value="1"
            <?php if ($enable_mega_menu) echo ' checked'; ?>>
        <label class="form-check-label" for="enable_builtin_mega_menu">
            <?php esc_html_e('Whether to enable built-in mega menu or not.', 'sublimeplus'); ?>
        </label>
    </div>
</div>

<div class="mb-3">
    <label for="header_scripts" class="form-label"><?php esc_html_e('Header scripts', 'sublimeplus') ?></label>
    <textarea class="form-control" id="header_scripts" name="<?php echo esc_attr($this->getName('header_scripts')) ?>"
        rows="6"><?php echo wp_unslash($this->getValue('header_scripts')) ?></textarea>
    <div id="headerScriptsHelp" class="form-text">
        <?php esc_html_e('Here come custom scripts inserted inside HEAD tag.', 'sublimeplus') ?>
    </div>
</div>

<div class="mb-3">
    <label for="footer_scripts" class="form-label"><?php esc_html_e('Footer scripts', 'sublimeplus') ?></label>
    <textarea class="form-control" id="footer_scripts" name="<?php echo esc_attr($this->getName('footer_scripts')) ?>"
        rows="6"><?php echo wp_unslash($this->getValue('footer_scripts')) ?></textarea>
    <div id="footerScriptsHelp" class="form-text">
        <?php esc_html_e('Here comes your Google Analytics code or any other JS code you want to be loaded in the footer of your website.', 'sublimeplus') ?>
    </div>
</div>

<?php
    // end render
            $this->renderclsoe();
    }

    public function sanitize($inputs) {
        // Sanitize inputs for General Tab
        $sanitizedInputs = [];
        if (isset($inputs['sample_setting'])) {
            $sanitizedInputs['sample_setting'] = sanitize_text_field($inputs['sample_setting']);
        }

        // Sanitize other General tab settings here

        return $sanitizedInputs;
    }
}