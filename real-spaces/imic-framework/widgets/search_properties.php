<?php
/* * * Widget code for Properties Search ** */
class search_properties extends WP_Widget {
    // constructor
    function search_properties() {
        $widget_ops = array('description' => __("Search Properties.", 'framework'));
        parent::WP_Widget(false, $name = __('Search Properties', 'framework'), $widget_ops);
    }
    // widget form creation
    function form($instance) {
        // Check values
        if ($instance) {
            $title = esc_attr($instance['title']);
        } else {
            $title = '';
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'framework'); ?></label>
            <input class="spTitle" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>    
        <?php
    }
    // update widget
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    // display widget
    function widget($args, $instance) {
        extract($args);
       global $imic_options;
       $search_widget_blocks = $imic_options['search-widget-blocks']['Enabled'];
        if (count($search_widget_blocks)>1):
            // these are the widget options
            $post_title = apply_filters('widget_title', $instance['title']);
            echo $args['before_widget'];
            if (!empty($instance['title'])) {
                echo $args['before_title'];
                echo apply_filters('widget_title', $post_title, $instance, $this->id_base);
                echo $args['after_title'];
            }
            echo '<div class="full-search-form">
                 <form method="get" action="' . home_url() . '/">';
            echo'<input type="hidden" class="form-control" name="s" id="s" value="' . __('Search1', 'framework') . '" />';
            foreach ($search_widget_blocks as $key => $value) {
                switch ($key) {
                case 'property_type':
                        $args_terms = array('orderby' => 'count', 'hide_empty' => true);
                        $propertyterms = get_terms('property-type', $args_terms);
                        if (!empty($propertyterms)) {
                            $output = '<select name="propery_type" class="form-control selectpicker">';
                            $output .='<option selected>' . __('Property Type', 'framework') . '</option>';
                            foreach ($propertyterms as $term) {
                                $term_name = $term->name;
                                $term_slug = $term->slug;
                                $output .="<option value='" . $term_slug . "'>" . $term_name . "</option>";
                            }
                            $output .="</select>";
                            echo $output;
                        }
                break;
                case 'contract': $args_contract = array('orderby' => 'count', 'hide_empty' => true);
                        $property_contract_type_terms = get_terms('property-contract-type', $args_contract);
                        if (!empty($property_contract_type_terms)) {
                            $output = '<select name="propery_contract_type" class="form-control selectpicker">';
                            $output .='<option selected>' . __('Contract', 'framework') . '</option>';
                            foreach ($property_contract_type_terms as $term) {
                                $term_name = $term->name;
                                $term_slug = $term->slug;
                                $output .="<option value='" . $term_slug . "'>" . $term_name . "</option>";
                            }
                            $output .="</select>";
                            echo $output;
                        }
                break;
                case 'location': $imic_country_wise_city = imic_get_multiple_city();
                        if (!empty($imic_country_wise_city)) {
                            echo'<select name="propery_location" class="form-control selectpicker">
                          <option selected>' . __('State', 'framework') . '</option>';
                            foreach ($imic_country_wise_city as $key => $value) {
                                echo "<option value='" . $key . "'>" . $value . "</option>";
                            }
                            echo'</select>';
                        }
                break;
                case 'baths':
                         echo '<div><label>' . __('Min Baths', 'framework') . '</label>
                              <select name="baths" class="form-control selectpicker">';
                         echo'<option selected>' . __('Any', 'framework') . '</option>';
                            $baths_options = $imic_options['properties_baths'];
    						foreach ($baths_options as $baths) {
                                echo "<option value='" . $baths . "'>" . $baths . "</option>";
                            }
                         echo'</select></div>';
                break;
                case 'city':
                        $args_c = array('orderby' => 'count', 'hide_empty' => true);
                        $terms = get_terms(array('city-type'), $args_c);
                        if (!empty($terms)) {
                            echo '<select name="property_city" class="form-control selectpicker">
                    <option selected>' . __('City', 'framework') . '</option>';
                            foreach ($terms as $term_data) {
                                echo "<option value='" . $term_data->slug . "'>" . $term_data->name . "</option>";
                            }
                            echo'</select>';
                        }
                break;
                case 'beds':
                        echo '<label>' . __('Min Beds', 'framework') . '</label>
                                <select name="beds" class="form-control selectpicker">';
                        echo'<option selected>' . __('Any', 'framework') . '</option>';
                        $beds_options = $imic_options['properties_beds'];
    					foreach ($beds_options as $beds) {
                            echo "<option value='" . $beds . "'>" . $beds . "</option>";
                        }
                        echo'</select>';
                break;
                case 'price':
                        echo '<div><label>' . __('Min Price', 'framework') . '</label>
                                <select name="min_price" class="form-control selectpicker">';
                        echo'<option selected>' . __('Any', 'framework') . '</option>';
                        $m_price_value = $imic_options['properties_price_range'];
                        foreach ($m_price_value as $price_value) {
                            echo "<option value='" . $price_value . "'>" . $currency_symbol . " " . $price_value . "</option>";
                        }
                        echo'</select></div>';
                        echo '<div>
                            <label>' . __('Max Price', 'framework') . '</label>
                            <select name="max_price" class="form-control selectpicker">';
                        echo'<option selected>' . __('Any', 'framework') . '</option>';
                        $max_price_value = $imic_options['properties_price_range'];
                        foreach ($max_price_value as $price_value) {
                            echo "<option value='" . $price_value . "'>" . $currency_symbol . " " . $price_value . "</option>";
                        }
                        echo'</select>
                            </div>';
                    break;
                    case 'area':
                        echo '<div>
                                <label>' . __('Min Area (Sq Ft)', 'framework') . '</label>
                                <input type="text" name="min_area" class="form-control" placeholder="' . __('Any', 'framework') . '">
                            </div>
                            <div>
                                <label>' . __('Max Area (Sq Ft)', 'framework') . '</label>
                                <input type="text" name="max_area" class="form-control" placeholder="' . __('Any', 'framework') . '">
                            </div>';
                    break;
                    case 'search_by':
                        echo '<div class="search_by">
                            <div>
                                <label>' . __('Search By', 'framework') . '</label>
                                <select name="search_by" class="form-control selectpicker">';
                        echo'<option selected>' . __('Search By', 'framework') . '</option>';
                        echo "<option value='Id'>" . __('Id', 'framework') . "</option>";
                        echo "<option value='Address'>" . __('Address', 'framework') . "</option>";
                        echo "<option value='Pincode'>" . __('Pincode', 'framework') . "</option>";
                        echo'</select>
                            </div>
                            <div>';
                        echo'<label>' . __('keyword', 'framework') . '</label>
                             	<input type="text" name="search_by_keyword" class="form-control search_by_keyword" placeholder="' . _e('Please enter ', 'framework') . '">
                            </div>
                            </div>';
                    break;
                }
            }
            echo'<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> ' . __('Search', 'framework') . '</button>
    </form>
  </div>';
           echo $args['after_widget'];
        endif;
    }
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("search_properties");'));
?>