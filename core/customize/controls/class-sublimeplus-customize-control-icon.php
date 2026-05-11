<?php
/**
 * Sublimeplus_Customize_Control_Icon
 *
 * @package SublimePulse\Core\Customize\Classes\Controls
 *
 */
final class Sublimeplus_Customize_Control_Icon extends Sublimeplus_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
       <script type="text/html" id="tmpl-sublimeplus-customize-control-icon">
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
            <div class="sublimeplus-icon-picker">
                <div class="sublimeplus-icon-preview">
                    <input type="hidden" class="sublimeplus-input sublimeplus-input-icon-type" data-name="{{ data.name }}-type" value="{{ data.value.type }}">
                    <div class="sublimeplus-icon-preview-icon sublimeplus-pick-icon">
                        <# if ( data.value.icon ) {  #>
                            <i class="{{ data.value.icon }}"></i>
                        <# }  #>
                    </div>
                </div>
                <input type="text" readonly class="sublimeplus-input sublimeplus-pick-icon sublimeplus-input-icon-name" placeholder="<?php esc_attr_e( 'Pick an icon', 'sublimeplus' ); ?>" data-name="{{ data.name }}" value="{{ data.value.icon }}">
                <span class="sublimeplus-icon-remove" title="<?php esc_attr_e( 'Remove', 'sublimeplus' ); ?>">
                    <span class="dashicons dashicons-no-alt"></span>
                    <span class="screen-reader-text">
                    <?php esc_html_e( 'Remove', 'sublimeplus' ) ?></span>
                </span>
            </div>
        </div>
        </div>
        </script>
        <div id="sublimeplus-sidebar-icons">
            <div class="sublimeplus-sidebar-header">
                <a class="customize-controls-icon-close" href="#">
                    <span class="screen-reader-text"><?php esc_html_e( 'Cancel', 'sublimeplus' );  ?></span>
                </a>
                <div class="sublimeplus-icon-type-inner">
                    <select id="sublimeplus-sidebar-icon-type">
                        <option value="all"><?php esc_html_e( 'All Icon Types', 'sublimeplus' ); ?></option>
                    </select>
                </div>
            </div>
            <div class="sublimeplus-sidebar-search">
               <input type="text" id="sublimeplus-icon-search" placeholder="<?php esc_attr_e( 'Type icon name', 'sublimeplus' ) ?>">
            </div>
            <div id="sublimeplus-icon-browser"></div>
        </div>
        <?php
    }
}
