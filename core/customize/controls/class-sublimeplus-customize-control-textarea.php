<?php
/**
 * Sublimeplus_Customize_Control_Textarea
 *
 * @package SublimePulse\Core\Customize\Classes\Controls
 *
 */
final class Sublimeplus_Customize_Control_Textarea extends Sublimeplus_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-sublimeplus-customize-control-textarea">
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
                <textarea rows="10" class="sublimeplus-input" data-name="{{ data.name }}">{{ DOMPurify.sanitize(data.value) }}</textarea>
            </div>
        </div>
        </script>
        <?php
    }
}
