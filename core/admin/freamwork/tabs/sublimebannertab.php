   <?php
    require_once SUBLIMEPLUS_DIR . 'core/admin/freamwork/SublimeBaseTab.php'; // If SublimeBaseTab is in the same directory
    class SublimeBannerTab extends SublimeBaseTab {
        private $subTabs = [];
        public function getTitle() {
            return __('Banner', 'sublimeplus');
        }
        public function renderopen()
        {
            echo '<div class="tab-pane" id="banner-settings" role="tabpanel" aria-labelledby="banner-settings_">';
            echo '<div class="bd-example bg-light p-3 f-18 border">';
            echo '<caption>'. esc_html_e( $this->getTitle(). ' Options', 'sublimeplus') . '</caption>';
            echo '</div><div class="highlight pan">' ;
        }
        public function renderclsoe()
        {
            echo ' </div></div>';
        }
        public function render() {
            // Render the form fields specific for Banner Tab
            $this->renderopen();
            ?>



   <?php $trial_button_text = $this->getValue('trial_button_text'); ?>
   <div class="mb-3">
       <label class="form-label"><?php esc_html_e('Trial Button Text', 'sublimeplus'); ?></label>
       <input type="text" class="form-control" name="<?php echo esc_attr($this->getName('trial_button_text')) ?>"
           value="<?php echo esc_attr($trial_button_text); ?>">
       <small class="form-text"><?php esc_html_e('Please provide button text.', 'sublimeplus'); ?></small>
   </div>

   <?php $trial_button_url = $this->getValue('trial_button_url'); ?>
   <div class="mb-3">
       <label class="form-label"><?php esc_html_e('Trial Button URL', 'sublimeplus'); ?></label>
       <input type="text" class="form-control" name="<?php echo esc_attr($this->getName('trial_button_url')) ?>"
           value="<?php echo esc_attr($trial_button_url); ?>">
       <small class="form-text"><?php esc_html_e('Please provide button URL.', 'sublimeplus'); ?></small>
   </div>

   <?php
        // end render
                $this->renderclsoe();
        }
    
        public function sanitize($inputs) {
            // Sanitize inputs for Banner Tab
            $sanitizedInputs = [];
            if (isset($inputs['sample_setting'])) {
                $sanitizedInputs['sample_setting'] = sanitize_text_field($inputs['sample_setting']);
            }
    
            // Sanitize other Banner tab settings here
    
            return $sanitizedInputs;
        }
    }