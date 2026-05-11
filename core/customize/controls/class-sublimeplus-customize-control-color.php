<?php
/**
 * Sublimeplus_Customize_Control_Color
 *
 * @package SublimePulse\Core\Customize\Classes\Controls
 *
 */
final class Sublimeplus_Customize_Control_Color extends Sublimeplus_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-sublimeplus-customize-control-color">
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
                <div class="sublimeplus-input-color" data-default="{{ data.default }}">
                    <input type="hidden" class="sublimeplus-input sublimeplus-input--color" data-name="{{ data.name }}" value="{{ data.value }}">
                    <input type="text" class="sublimeplus-color-panel" data-alpha="true" value="{{ data.value }}">
                </div>
            </div>
        </div>
        </script>
        <?php
    }
}
