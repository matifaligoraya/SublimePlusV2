<?php
/**
 * Sublimeplus_Customize_Control_Checkbox
 *
 * @package SublimePulse\Core\Customize\Classes\Controls
 *
 */
final class Sublimeplus_Customize_Control_Checkbox extends Sublimeplus_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-sublimeplus-customize-control-checkbox">
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
            <label>
                <input type="checkbox" class="sublimeplus-input" <# if ( data.value == 1 ){ #> checked="checked" <# } #> data-name="{{ data.name }}" value="1">
                {{{ data.checkbox_label }}}
            </label>
        </div>
        </div>
        </script>
        <?php
    }
}
