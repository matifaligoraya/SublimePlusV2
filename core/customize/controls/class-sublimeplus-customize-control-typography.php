<?php
/**
 * Sublimeplus_Customize_Control_Typography
 *
 * @package SublimePulse\Core\Customize\Classes\Controls
 *
 */
final class Sublimeplus_Customize_Control_Typography extends Sublimeplus_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?><script type="text/html" id="tmpl-sublimeplus-customize-control-typography">
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
            <div class="sublimeplus-actions">
                <a href="#" class="action--reset" data-control="{{ data.name }}" title="<?php esc_attr_e( 'Reset to default', 'sublimeplus' ); ?>"><span class="dashicons dashicons-image-rotate"></span></a>
                <a href="#" class="action--edit" data-control="{{ data.name }}" title="<?php esc_attr_e( 'Toggle edit panel', 'sublimeplus' ); ?>"><span class="dashicons dashicons-edit"></span></a>
            </div>
            <div class="sublimeplus-customize-control-settings-inner">
                <input type="hidden" class="sublimeplus-typography-input sublimeplus-only" data-name="{{ data.name }}" value="{{ JSON.stringify( data.value ) }}" data-default="{{ JSON.stringify( data.default ) }}">
            </div>
        </div>
        </script>
        <div id="sublimeplus-typography-panel" class="sublimeplus-typography-panel">
            <div class="sublimeplus-typography-panel--inner">
                <input type="hidden" id="sublimeplus-font-type">
                <div id="sublimeplus-typography-panel--fields"></div>
            </div>
        </div>
        <?php
    }
}
