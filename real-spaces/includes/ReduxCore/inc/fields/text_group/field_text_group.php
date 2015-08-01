<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @subpackage  Field_text_group
 * @author      Luciano "WebCaos" Ubertini
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys
 * @version     3.0.0
 */
// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) ) {
    exit;
}
// Don't duplicate me!
if ( !class_exists ( 'ReduxFramework_text_group' ) ) {
    /**
     * Main ReduxFramework_text_group class
     *
     * @since       1.0.0
     */
    class ReduxFramework_text_group {
        /**
         * Field Constructor.
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct ( $field = array(), $value = '', $parent ) {
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;
        }
        /**
         * Field Render Function.
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render () {
            $defaults = array(
                'show' => array(
                    'title' => true,
                    'number_of_property' => true,
                    'property_price' => true,
                    'property_description' => true,
                ),
                'content_title' => __ ( 'Plan', 'redux-framework' )
            );
            $this->field = wp_parse_args ( $this->field, $defaults );
            echo '<div class="redux-text_group-accordion" data-new-content-title="' . esc_attr ( sprintf ( __ ( 'New %s', 'redux-framework' ), $this->field[ 'content_title' ] ) ) . '">';
            $x = 0;
            $multi = ( isset ( $this->field[ 'multi' ] ) && $this->field[ 'multi' ] ) ? ' multiple="multiple"' : "";
            if ( isset ( $this->value ) && is_array ( $this->value ) && !empty ( $this->value ) ) {
                $text_group = $this->value;
                foreach ( $text_group as $slide ) {
                    if ( empty ( $slide ) ) {
                        continue;
                    }
                    $defaults = array(
                        'title' => '',
                        'number_of_property' => '',
                        'sort' => '',
                        'property_price' => '',
                        'property_description' => '',
                        'image' => '',
                        'thumb' => '',
                        'attachment_id' => '',
                        'height' => '',
                        'width' => '',
                        'select' => array(),
                    );
                    $slide = wp_parse_args ( $slide, $defaults );
                    if ( empty ( $slide[ 'thumb' ] ) && !empty ( $slide[ 'attachment_id' ] ) ) {
                        $img = wp_get_attachment_image_src ( $slide[ 'attachment_id' ], 'full' );
                        $slide[ 'image' ] = $img[ 0 ];
                        $slide[ 'width' ] = $img[ 1 ];
                        $slide[ 'height' ] = $img[ 2 ];
                    }
                    echo '<div class="redux-text_group-accordion-group"><fieldset class="redux-field" data-id="' . $this->field[ 'id' ] . '"><h3><span class="redux-text_group-header">' . $slide[ 'title' ] . '</span></h3><div>';
                    $hide = '';
                    if ( empty ( $slide[ 'image' ] ) ) {
                        $hide = ' hide';
                    }
                    echo '<div class="screenshot' . $hide . '">';
                    echo '<img class="redux-text_group-image" id="image_image_id_' . $x . '" src="' . $slide[ 'thumb' ] . '" alt="" target="_blank" rel="external" />';
                    echo '</a>';
                    echo '</div>';
                    echo '<div class="redux_text_group_add_remove">';
                   
                    $hide = '';
                    if ( empty ( $slide[ 'image' ] ) || $slide[ 'image' ] == '' ) {
                        $hide = ' hide';
                    }
                    echo '<span class="button remove-image' . $hide . '" id="reset_' . $x . '" rel="' . $slide[ 'attachment_id' ] . '">' . __ ( 'Remove', 'redux-framework' ) . '</span>';
                    echo '</div>' . "\n";
                    echo '<ul id="' . $this->field[ 'id' ] . '-ul" class="redux-text_group-list">';
                    if ( $this->field[ 'show' ][ 'title' ] ) {
                        $title_type = "text";
                    } else {
                        $title_type = "hidden";
                    }
                    $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'title' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'title' ] ) : __ ( 'Title', 'redux-framework' );
                    echo '<li><input type="' . $title_type . '" id="' . $this->field[ 'id' ] . '-title_' . $x . '" name="' . $this->field[ 'name' ] . '[' . $x . '][title]' . $this->field['name_suffix'] . '" value="' . esc_attr ( $slide[ 'title' ] ) . '" placeholder="' . $placeholder . '" class="full-text slide-title" /></li>';
                    if ( $this->field[ 'show' ][ 'number_of_property' ] ) {
                        $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'number_of_property' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'number_of_property' ] ) : __ ( 'Enter number of properties available to list with this plan', 'redux-framework' );
                      
                        echo '<li><input type="text" name="' . $this->field[ 'name' ] . '[' . $x . '][number_of_property]' . $this->field['name_suffix'] . '" id="' . $this->field[ 'id' ] . '-number_of_property_' . $x . '" placeholder="' . $placeholder . '" value ="'.esc_attr ( $slide[ 'number_of_property' ] ).'" class="full-text slide-title" ></li>';
                    }
                    $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'property_price' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'property_price' ] ) : __ ( 'Enter plan price', 'redux-framework' );
                    if ( $this->field[ 'show' ][ 'property_price' ] ) {
                        $property_price_type = "text";
                    } else {
                        $property_price_type = "hidden";
                    }
                    echo '<li><input type="' . $property_price_type . '" id="' . $this->field[ 'id' ] . '-property_price_' . $x . '" name="' . $this->field[ 'name' ] . '[' . $x . '][property_price]' . $this->field['name_suffix'] .'" value="' . esc_attr ( $slide[ 'property_price' ] ) . '" class="full-text" placeholder="' . $placeholder . '" /></li>';
                    echo '<li><input type="hidden" class="slide-sort" name="' . $this->field[ 'name' ] . '[' . $x . '][sort]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-sort_' . $x . '" value="' . $slide[ 'sort' ] . '" />';
                    if ( $this->field[ 'show' ][ 'property_description' ] ) {
                        $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'property_description' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'property_description' ] ) : __ ( 'Enter plan features. Make sure each feature start in a new line and end with a full stop(.)', 'redux-framework' );
                        echo '<li><textarea name="' . $this->field[ 'name' ] . '[' . $x . '][property_description]' . $this->field['name_suffix'] . '" id="' . $this->field[ 'id' ] . '-property_description_' . $x . '" placeholder="' . $placeholder . '" class="large-text" rows="6">' . esc_attr ( $slide[ 'property_description' ] ) . '</textarea></li>';
                    }
                    
                    echo '<li><a href="javascript:void(0);" class="button deletion redux-text_group-remove">' . sprintf ( __ ( 'Delete %s', 'redux-framework' ), $this->field[ 'content_title' ] ) . '</a></li>';
                    echo '</ul></div></fieldset></div>';
                    $x ++;
                }
            }
            if ( $x == 0 ) {
                echo '<div class="redux-text_group-accordion-group"><fieldset class="redux-field" data-id="' . $this->field[ 'id' ] . '"><h3><span class="redux-text_group-header">New ' . $this->field[ 'content_title' ] . '</span></h3><div>';
                $hide = ' hide';
                echo '<div class="screenshot' . $hide . '">';
              
                echo '</div>';
               
                echo '<ul id="' . $this->field[ 'id' ] . '-ul" class="redux-text_group-list">';
                if ( $this->field[ 'show' ][ 'title' ] ) {
                    $title_type = "text";
                } else {
                    $title_type = "hidden";
                }
                $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'title' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'title' ] ) : __ ( 'Title', 'redux-framework' );
                echo '<li><input type="' . $title_type . '" id="' . $this->field[ 'id' ] . '-title_' . $x . '" name="' . $this->field[ 'name' ] . '[' . $x . '][title]' . $this->field['name_suffix'] .'" value="" placeholder="' . $placeholder . '" class="full-text slide-title" /></li>';
                if ( $this->field[ 'show' ][ 'number_of_property' ] ) {
                    $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'number_of_property' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'number_of_property' ] ) : __ ( 'Insert Number of property', 'redux-framework' );
                    echo '<li><input type ="text" name="' . $this->field[ 'name' ] . '[' . $x . '][number_of_property]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-number_of_property_' . $x . '" placeholder="' . $placeholder . '" class="full-text slide-title" /></li>';
                }
                $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'property_price' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'property_price' ] ) : __ ( 'Insert Property Price', 'redux-framework' );
                if ( $this->field[ 'show' ][ 'property_price' ] ) {
                    $property_price_type = "text";
                } else {
                    $property_price_type = "hidden";
                }
                echo '<li><input type="' . $property_price_type . '" id="' . $this->field[ 'id' ] . '-property_price_' . $x . '" name="' . $this->field[ 'name' ] . '[' . $x . '][property_price]' . $this->field['name_suffix'] .'" value="" class="full-text" placeholder="' . $placeholder . '" /></li>';
                echo '<li><input type="hidden" class="slide-sort" name="' . $this->field[ 'name' ] . '[' . $x . '][sort]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-sort_' . $x . '" value="' . $x . '" />';
              if ( $this->field[ 'show' ][ 'property_description' ] ) {
                        $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'property_description' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'property_description' ] ) : __ ( 'Property Description', 'redux-framework' );
                        echo '<li><textarea name="' . $this->field[ 'name' ] . '[' . $x . '][property_description]' . $this->field['name_suffix'] . '" id="' . $this->field[ 'id' ] . '-property_description_' . $x . '" placeholder="' . $placeholder . '" class="large-text" rows="6">' . esc_attr ( $slide[ 'property_description' ] ) . '</textarea></li>';
                    }
                
                echo '<li><a href="javascript:void(0);" class="button deletion redux-text_group-remove">' . sprintf ( __ ( 'Delete %s', 'redux-framework' ), $this->field[ 'content_title' ] ) . '</a></li>';
                echo '</ul></div></fieldset></div>';
            }
            echo '</div><a href="javascript:void(0);" class="button redux-text_group-add button-primary" rel-id="' . $this->field[ 'id' ] . '-ul" rel-name="' . $this->field[ 'name' ] . '[title][]' . $this->field['name_suffix'] .'">' . sprintf ( __ ( 'Add %s', 'redux-framework' ), $this->field[ 'content_title' ] ) . '</a><br/>';
        }
        /**
         * Enqueue Function.
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue () {
            wp_enqueue_script(
                'redux-field-media-js',
                ReduxFramework::$_url . 'assets/js/media/media' . Redux_Functions::isMin() . '.js',
                array( 'jquery', 'redux-js' ),
                time(),
                true
            );
            wp_enqueue_style (
                'redux-field-media-css', 
                ReduxFramework::$_url . 'inc/fields/media/field_media.css', 
                time (), 
                true
            );
            wp_enqueue_script (
                'redux-field-text_group-js', 
                ReduxFramework::$_url . 'inc/fields/text_group/field_text_group' . Redux_Functions::isMin () . '.js', 
                array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'wp-color-picker' ), 
                time (), 
                true
            );
            wp_enqueue_style (
                'redux-field-text_group-css', 
                ReduxFramework::$_url . 'inc/fields/text_group/field_text_group.css', 
                time (), 
                true
            );
        }
    }
}