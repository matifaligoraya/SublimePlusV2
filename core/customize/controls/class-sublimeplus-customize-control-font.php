<?php
/**
 * Sublimeplus_Customize_Control_Font
 *
 * @package SublimePulse\Core\Customize\Classes\Controls
 *
 */
final class Sublimeplus_Customize_Control_Font extends Sublimeplus_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-sublimeplus-customize-control-css-ruler">
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
                <input type="hidden" class="sublimeplus-font-type" data-name="{{ data.name }}-type" >
                <div class="sublimeplus-font-families-wrapper">
                    <select class="sublimeplus-font-families" data-value="{{ JSON.stringify( data.value ) }}" data-name="{{ data.name }}-font"></select>
                </div>
                <div class="sublimeplus-font-variants-wrapper">
                    <label><?php esc_html_e( 'Variants', 'sublimeplus' ) ?></label>
                    <select class="sublimeplus-font-variants" data-name="{{ data.name }}-variant"></select>
                </div>
                <div class="sublimeplus-font-subsets-wrapper">
                    <label><?php esc_html_e( 'Languages', 'sublimeplus' ) ?></label>
                    <div data-name="{{ data.name }}-subsets" class="list-subsets">
                    </div>
                </div>
            </div>
        </div>
        </script>
        <?php
    }
}
