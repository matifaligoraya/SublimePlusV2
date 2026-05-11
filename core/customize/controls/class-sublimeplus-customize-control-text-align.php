<?php
/**
 * Sublimeplus_Customize_Control_Text_Align
 *
 * @package SublimePulse\Core\Customize\Classes\Controls
 *
 */
final class Sublimeplus_Customize_Control_Text_Align extends Sublimeplus_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-sublimeplus-customize-control-text_align">
        <#
        var required = '';
        if ( ! _.isUndefined( data.required ) ) {
            required = JSON.stringify( data.required  );
        }
        #>
        <div class="sublimeplus-customize-control sublimeplus-customize-control-{{ data.type }} {{ data.class }} sublimeplus-customize-control-name-{{ data.original_name }}" data-required="{{ required }}" data-field-name="{{ data.name }}">
            <#
            var uniqueID = data.name + ( new Date().getTime() );
            #>
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
                <div class="sublimeplus-text-align">
                    <label><input type="radio" data-name="{{ data.name }}" value="left" <# if ( data.value == 'left' ){ #> checked="checked" <# } #> name="{{ uniqueID }}"> <span class="button"><span class="dashicons dashicons-editor-alignleft"></span></span></label>
                    <label><input type="radio" data-name="{{ data.name }}" value="center" <# if ( data.value == 'center' ){ #> checked="checked" <# } #> name="{{ uniqueID }}"> <span class="button"><span class="dashicons dashicons-editor-aligncenter"></span></span></label>
                    <label><input type="radio" data-name="{{ data.name }}" value="right" <# if ( data.value == 'right' ){ #> checked="checked" <# } #> name="{{ uniqueID }}"> <span class="button"><span class="dashicons dashicons-editor-alignright"></span></span></label>
                    <# if ( ! data.no_justify ) {  #>
                    <label><input type="radio" data-name="{{ data.name }}" value="justify" <# if ( data.value == 'justify' ){ #> checked="checked" <# } #> name="{{ uniqueID }}"> <span class="button"><span class="dashicons dashicons-editor-justify"></span></span></label>
                    <# } #>
                </div>
            </div>
        </div>
        </script>
        <?php
    }
}
