<?php
/**
 * Sublimeplus_Customize_Control_Shadow
 *
 * @package SublimePulse\Core\Customize\Classes\Controls
 *
 */
final class Sublimeplus_Customize_Control_Shadow extends Sublimeplus_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-sublimeplus-customize-control-shadow">
        <#
        var required = '';
        if ( ! _.isUndefined( data.required ) ) {
            required = JSON.stringify( data.required  );
        }
        #>
        <div class="sublimeplus-customize-control sublimeplus-customize-control-{{ data.type }} {{ data.class }} sublimeplus-customize-control-name-{{ data.original_name }}" data-required="{{ required }}" data-field-name="{{ data.name }}">
            <#
                if ( ! _.isObject( data.value ) ) {
                data.value = { };
                }

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

                    <div class="sublimeplus-input-color" data-default="{{ data.default }}">
                        <input type="hidden" class="sublimeplus-input sublimeplus-input--color" data-name="{{ data.name }}-color" value="{{ data.value.color }}">
                        <input type="text" class="sublimeplus-color-panel" data-alpha="true" value="{{ data.value.color }}">
                    </div>

                    <div class="sublimeplus-gr-inputs">
                        <span>
                            <input type="number" class="sublimeplus-input sublimeplus-input-css change-by-js"  data-name="{{ data.name }}-x" value="{{ data.value.x }}">
                            <span class="sublimeplus-small-label"><?php esc_html_e( 'X', 'sublimeplus' ); ?></span>
                        </span>
                        <span>
                            <input type="number" class="sublimeplus-input sublimeplus-input-css change-by-js"  data-name="{{ data.name }}-y" value="{{ data.value.y }}">
                            <span class="sublimeplus-small-label"><?php esc_html_e( 'Y', 'sublimeplus' ); ?></span>
                        </span>
                        <span>
                            <input type="number" class="sublimeplus-input sublimeplus-input-css change-by-js" data-name="{{ data.name }}-blur" value="{{ data.value.blur }}">
                            <span class="sublimeplus-small-label"><?php esc_html_e( 'Blur', 'sublimeplus' ); ?></span>
                        </span>
                        <span>
                            <input type="number" class="sublimeplus-input sublimeplus-input-css change-by-js" data-name="{{ data.name }}-spread" value="{{ data.value.spread }}">
                            <span class="sublimeplus-small-label"><?php esc_html_e( 'Spread', 'sublimeplus' ); ?></span>
                        </span>
                        <span>
                            <span class="input">
                                <input type="checkbox" class="sublimeplus-input sublimeplus-input-css change-by-js" <# if ( data.value.inset == 1 ){ #> checked="checked" <# } #> data-name="{{ data.name }}-inset" value="{{ data.value.inset }}">
                            </span>
                            <span class="sublimeplus-small-label"><?php esc_html_e( 'inset', 'sublimeplus' ); ?></span>
                        </span>
                    </div>
                </div>
            </div>
            </script>
            <?php
    }
}
