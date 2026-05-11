<?php
/**
 * Sublimeplus_Customize_Control_Repeater
 *
 * @package SublimePulse\Core\Customize\Classes\Controls
 *
 */
final class Sublimeplus_Customize_Control_Repeater extends Sublimeplus_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-sublimeplus-customize-control-repeater">
            <#
            var required = '';
            if ( ! _.isUndefined( data.required ) ) {
                required = JSON.stringify( data.required  );
            }
            #>
            <div class="sublimeplus-customize-control sublimeplus-customize-control-{{ data.type }} {{ data.class }} sublimeplus-customize-control-name-{{ data.original_name }}" data-required="{{ required }}" data-field-name="{{ data.name }}">
            <# if ( data.label || data.description ) { #>
            <div class="sublimeplus-customize-control-header">
                <# if ( data.label ) { #>
                    <div class="sublimeplus-customize-control-heading">
                        <label class="customize-control-title">{{{ data.label }}}</label>
                    </div>
                <# } #>
                <# if ( data.description ) { #>
                    <p class="description">{{{ data.description }}}</p>
                <# } #>
            </div>
            <# } #>
            <div class="sublimeplus-customize-control-settings-inner">
            </div>
            </div>
        </script>
        <script type="text/html" id="tmpl-customize-control-repeater-item">
            <div class="sublimeplus-repeater-item">
                <div class="sublimeplus-repeater-item-heading">
                    <label class="sublimeplus-repeater-visible" title="<?php esc_attr_e( 'Toggle item visible', 'sublimeplus' ); ?>"><input type="checkbox" class="r-visible-input"><span class="r-visible-icon"></span><span class="screen-reader-text"><?php _e( 'Show', 'sublimeplus' ) ?></label>
                    <span class="sublimeplus-repeater-live-title"></span>
                    <div class="sublimeplus-nav-reorder">
                        <span class="sublimeplus-down" tabindex="-1"><span class="screen-reader-text"><?php esc_html_e( 'Move Down', 'sublimeplus' ) ?></span></span>
                        <span class="sublimeplus-up" tabindex="0"><span class="screen-reader-text"><?php esc_html_e( 'Move Up', 'sublimeplus' ) ?></span></span>
                    </div>
                    <a href="#" class="sublimeplus-repeater-item-toggle"><span class="screen-reader-text"><?php esc_html_e( 'Close', 'sublimeplus' ) ?></span></a>
                </div>
                <div class="sublimeplus-repeater-item-settings">
                    <div class="sublimeplus-repeater-item-inside">
                        <div class="sublimeplus-repeater-item-inner"></div>
                        <# if ( data.addable ){  #>
                            <a href="#" class="sublimeplus-remove"><?php esc_html_e( 'Remove', 'sublimeplus' ); ?></a>
                            <# } #>
                    </div>
                </div>
            </div>
        </script>
        <script type="text/html" id="tmpl-customize-control-repeater-inner">
            <div class="sublimeplus-repeater-inner">
                <div class="sublimeplus-settings-fields sublimeplus-repeater-items"></div>
                <div class="sublimeplus-repeater-actions">
                    <a href="#" class="sublimeplus-repeater-reorder" data-text="<?php esc_attr_e( 'Reorder', 'sublimeplus' ); ?>" data-done="<?php _e( 'Done', 'sublimeplus' ); ?>"><?php _e( 'Reorder', 'sublimeplus' ); ?></a>
                    <# if ( data.addable ){  #>
                        <button type="button" class="button sublimeplus-repeater-add-new"><?php esc_html_e( 'Add an item', 'sublimeplus' ); ?></button>
                        <# } #>
                </div>
            </div>
        </script>
        <?php
    }
}
