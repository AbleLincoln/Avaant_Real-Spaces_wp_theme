<?php
/*
  Template Name: Submit Property
 */
get_header();
global $current_user, $imic_options; // Use global
get_currentuserinfo(); // Make sure global is set, if not set it.
if($imic_options['buyer_rights']==0) { $subscriber = "agent"; } else { $subscriber = "subscriber"; }
if ((user_can($current_user, "agent") ) || (user_can($current_user, "administrator") ) || (user_can($current_user, $subscriber) )):
    global $imic_options;
    $property_details_option_enable = $imic_options['property_details_option_enable'];
    $property_details_option_required = $imic_options['property_details_option_required'];
    $additional_info_option_enable = $imic_options['additional_info_option_enable'];
    $additional_info_option_required = $imic_options['additional_info_option_required'];
    $currency_symbol = imic_get_currency_symbol($imic_options['currency-select']);
    $msg = '';
    $flag = 0;
    $property_address_value = $property_title = $property_pin = $property_amenities_value = $property_area_value = $property_baths_value = $property_beds_value = $property_city_value = $property_parking_value = $property_price_value = $Property_Id = $property_contract_type_value = $property_type_value = $property_content = $property_sights_value = $othertextonomies = $city_type_value = '';
    if (get_query_var('site')) {
        $Property_Id = get_query_var('site');
        $property_title = get_the_title($Property_Id);
        $property_address_value = get_post_meta($Property_Id, 'imic_property_site_address', true);
        $property_content = get_post_field('post_content', $Property_Id);
        $property_city_value = get_post_meta($Property_Id, 'imic_property_site_city', true);
        $property_pin = get_post_meta($Property_Id, 'imic_property_pincode', true);
        $property_price_value = get_post_meta($Property_Id, 'imic_property_price', true);
        $property_area_value = get_post_meta($Property_Id, 'imic_property_area', true);
        $property_baths_value = get_post_meta($Property_Id, 'imic_property_baths', true);
        $property_beds_value = get_post_meta($Property_Id, 'imic_property_beds', true);
        $property_parking_value = get_post_meta($Property_Id, 'imic_property_parking', true);
        $property_amenities_value = get_post_meta($Property_Id, 'imic_property_amenities', true);
        $property_sights_value = get_post_meta($Property_Id, 'imic_property_sights', false);
        $property_amenities_per = $property_amenities_value;
        $type = wp_get_object_terms($Property_Id, 'property-type', array('fields' => 'ids'));
        if (!empty($type)) {
            $term = get_term($type[0], 'property-type');
            $property_type_value = $term->name;
        }
        $city_type = wp_get_object_terms($Property_Id, 'city-type', array('fields' => 'ids'));
        $city_type = array_reverse($city_type);
        if (!empty($city_type)) {
            $city_term = get_term($city_type[0], 'city-type');
            $city_type_value = $city_term->slug;
        }
        $contract = wp_get_object_terms($Property_Id, 'property-contract-type', array('fields' => 'ids'));
        if (!empty($contract)) {
            $terms = get_term($contract[0], 'property-contract-type');
            $property_contract_type_value = $terms->name;
        }
        $othertextonomies = get_post_meta($Property_Id, 'imic_property_custom_city', true);
    }
    $Property_Status = get_post_meta(get_the_ID(), 'imic_property_status', true);
    // Check if the form was submitted
    if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action'])) {
        if (!empty($property_details_option_enable['1']) == 1) {
            $property_title = $_POST['title'];
        }
        if (!empty($property_details_option_enable['5']) == 1) {
            $property_pin = $_POST['pin'];
        }
        if (!empty($property_details_option_enable['6']) == 1) {
            $property_content = $_POST['description'];
        }
        if (!empty($property_details_option_enable['2']) == 1) {
            $property_address_value = $_POST['address'];
        }
        if (!empty($property_details_option_enable['4']) == 1) {
            $property_city_value = $_POST['city'];
        }
        if (!empty($additional_info_option_enable['1']) == 1) {
            $property_price_value = $_POST['price'];
        }
        if (!empty($additional_info_option_enable['4']) == 1) {
            $property_beds_value = $_POST['beds'];
        }
        if (!empty($additional_info_option_enable['5']) == 1) {
            $property_baths_value = $_POST['baths'];
        }
        if (!empty($additional_info_option_enable['6']) == 1) {
            $property_parking_value = $_POST['parking'];
        }
        if (!empty($property_details_option_enable['3']) == 1) {
            $property_area_value = $_POST['area'];
        }
        if (!empty($additional_info_option_enable['3']) == 1) {
            $property_contract_type_value = $_POST['contract'];
        }
        if (!empty($additional_info_option_enable['2']) == 1) {
            $property_type_value = $_POST['type'];
        }
        if (isset($_POST['textonomies_city']) && !empty($_POST['textonomies_city'])) {
            $reverce_data = array_reverse($_POST['textonomies_city']);
            foreach ($reverce_data as $textonomies_city) {
                if (!empty($textonomies_city)) {
                    $city_type_value = $textonomies_city;
                    break;
                }
            }
            $property_custom_city = '';
        }
        if (isset($_POST['othertextonomies'])) {
            $city_type_value = '';
            $property_custom_city = $_POST['othertextonomies'];
        }
//        print_r($_POST);
        $ac = $heating = $balcony = $dish = $pool = $net = $terrace = $microwave = $fridge = $cable = $camera = $toaster = $grill = $oven = $fans = $servants = $furnished = '';
        if (isset($imic_options['properties_amenities']) && count($imic_options['properties_amenities']) > 1) {
            $amenity_array = array();
            foreach ($imic_options['properties_amenities'] as $properties_amenities) {
                $am_name = strtolower(str_replace(' ', '', $properties_amenities));
                if (isset($_POST[$am_name])) {
                    $am_name = $properties_amenities;
                } else {
                    $am_name = __('Not Selected', 'framework');
                }
                array_push($amenity_array, $am_name);
            }
        }
      
        if (($city_type_value == 'other') || ($city_type_value == 'city')) {
            $city_type_value = '';
        }
        if (!empty($property_details_option_required['1']) == 1 && !empty($property_details_option_enable['1']) == 1) {
            if (empty($property_title)) {
                $msg = __("Please enter project name.", "framework") . "<br/>";
            }
        }
        if (!empty($property_details_option_required['6']) == 1 && !empty($property_details_option_enable['6']) == 1) {
            if (empty($property_content)) {
                $msg .= __("Please enter project description.", "framework") . "<br/>";
            }
        }
        if (!empty($property_details_option_required['2']) == 1 && !empty($property_details_option_enable['2']) == 1) {
            if (empty($property_address_value)) {
                $msg .= __("Please enter property address.", "framework") . "<br/>";
            }
        }
        if (!empty($property_details_option_required['4']) == 1 && !empty($property_details_option_enable['4']) == 1) {
            if ($property_city_value == __('Province', 'framework')) {
                $msg .= __("Please select property province.", "framework") . "<br/>";
            }
        }
        if (!empty($additional_info_option_required['1']) == 1 && !empty($additional_info_option_enable['1']) == 1) {
            if (empty($property_price_value)) {
                $msg .= __("Please enter property value.", "framework") . "<br/>";
            }
        }
        if (!empty($additional_info_option_required['4']) == 1 && !empty($additional_info_option_enable['4']) == 1) {
            if ($property_beds_value == __('Beds', 'framework')) {
                $msg .= __("Please select property bedrooms.", "framework") . "<br/>";
            }
        }
        if (!empty($additional_info_option_required['5']) == 1 && !empty($additional_info_option_enable['5']) == 1) {
            if ($property_baths_value == __('Baths', 'framework')) {
                $msg .= __("Please enter property baths.", "framework") . "<br/>";
            }
        }
        if (!empty($additional_info_option_required['6']) == 1 && !empty($additional_info_option_enable['6']) == 1) {
            if ($property_parking_value == __('Parking', 'framework')) {
                $msg .= __("Please select property parking.", "framework") . "<br/>";
            }
        }
        if (!empty($additional_info_option_required['2']) == 1 && !empty($additional_info_option_enable['2']) == 1) {
            if ($property_type_value == __('Project category', 'framework')) {
                $msg .= __("Please select project category.", "framework") . "<br/>";
            }
        }
        if (!empty($additional_info_option_required['3']) == 1 && !empty($additional_info_option_enable['3']) == 1) {
            if ($property_contract_type_value == __('Contract Type', 'framework')) {
                $msg .= __("Please select property contract type.", "framework") . "<br/>";
            }
        }
        if (!empty($property_details_option_required['3']) == 1 && !empty($property_details_option_enable['3']) == 1) {
            if (empty($property_area_value)) {
                $msg .= __("Please enter property area.", "framework") . "<br/>";
            }
        }
        if (empty($property_sights_value)) {
            if (!file_exists($_FILES['sightMulti']['tmp_name'][0]) && empty($_FILES['sightMulti']['tmp_name'][0])) {
                $msg .= __("Please upload file.", "framework");
            }
        }
        if ($msg == '') {
            if (get_query_var('site')) {
                $post = array(
                    'ID' => get_query_var('site'),
                    'post_title' => $property_title,
                    'post_content' => $property_content,
                    'post_status' => 'publish', // Choose: publish, preview, future, etc.
                    'post_type' => 'property'  // Use a custom post type if you want to
                );
                $pid = wp_update_post($post);
                // Pass  the value of $post to WordPress the insert function
                $flag = 1;
            } else {
                if (isset($imic_options['submit_post_status']) && !empty($imic_options['submit_post_status'])) {
                    $post_status = $imic_options['submit_post_status'];
                } else {
                    $post_status = 'draft';
                }
                $post = array(
                    'post_title' => $property_title,
                    'post_content' => $property_content,
                    'post_status' => $post_status,
                    'post_type' => 'property'  // Use a custom post type if you want to
                );
                $pid = wp_insert_post($post);
                $total_property = get_user_meta($current_user->ID, 'property_value', true);
                $new_value = ($total_property != 0) ? ($total_property - 1) : $total_property;
                update_user_meta($current_user->ID, 'property_value', $new_value);
                $flag = 1;
            }
            if (!empty($additional_info_option_enable['3']) == 1) {
                wp_set_object_terms($pid, $property_contract_type_value, 'property-contract-type');
            }
            if (!empty($additional_info_option_enable['2']) == 1) {
                wp_set_object_terms($pid, $property_type_value, 'property-type');
            }
            if ('POST' == $_SERVER['REQUEST_METHOD']) {
                if (!empty($property_details_option_enable['2']) == 1) {
                    update_post_meta($pid, 'imic_property_site_address', $property_address_value);
                }
                if (!empty($property_details_option_enable['5']) == 1) {
                    update_post_meta($pid, 'imic_property_pincode', $property_pin);
                }
                update_post_meta($pid, 'imic_property_site_city', $property_city_value);
                if (!empty($additional_info_option_enable['1']) == 1) {
                    update_post_meta($pid, 'imic_property_price', $property_price_value);
                }
                if (!empty($property_details_option_enable['3']) == 1) {
                    update_post_meta($pid, 'imic_property_area', $property_area_value);
                }
                if (!empty($additional_info_option_enable['5']) == 1) {
                    update_post_meta($pid, 'imic_property_baths', $property_baths_value);
                }
                if (!empty($additional_info_option_enable['4']) == 1) {
                    
                    update_post_meta($pid, 'imic_property_beds', $property_beds_value);
                }
                update_post_meta($pid, 'imic_property_amenities', $amenity_array);
                if (!empty($additional_info_option_enable['6']) == 1) {
                    update_post_meta($pid, 'imic_property_parking', $property_parking_value);
                }
                if (!empty($additional_info_option_enable['3']) == 1) {
                    wp_set_object_terms($pid, $property_contract_type_value, 'property-contract-type');
                }
                if (!empty($additional_info_option_enable['2']) == 1) {
                    wp_set_object_terms($pid, $property_type_value, 'property-type');
                }
                update_post_meta($pid, 'imic_property_custom_city', $property_custom_city);
                $city_for_update = get_term_by('slug', $city_type_value, 'city-type');
                $term_array = array();
                while ($city_for_update->parent != 0) {
                    $city_for_update = get_term_by('id', $city_for_update->parent, 'city-type');
                    array_push($term_array, $city_for_update->slug);
                }
                array_push($term_array, $city_type_value);
                wp_set_object_terms($pid, $term_array, 'city-type');
                if (!empty($_FILES['sightMulti']['tmp_name'][0])) {
                    $i = 1;
                    $files = $_FILES['sightMulti'];
                    foreach ($files['name'] as $key => $value) {
                        if ($files['name'][$key]) {
                            $file = array(
                                'name' => $files['name'][$key],
                                'type' => $files['type'][$key],
                                'tmp_name' => $files['tmp_name'][$key],
                                'error' => $files['error'][$key],
                                'size' => $files['size'][$key]
                            );
                            $_FILES = array("sight" . $i => $file);
                            $newuploadMulti = sight("sight" . $i, $pid);
                            if ($i == 1) {
                                update_post_meta($pid, '_thumbnail_id', $newuploadMulti);
                            }
                            add_post_meta($pid, 'imic_property_sights', $newuploadMulti, false);
                        }
                        $i++;
                    }
                }
            }
            if (get_query_var('site')) {
                $Property_Id = get_query_var('site');
                $property_title = get_the_title($Property_Id);
                $property_address_value = get_post_meta($Property_Id, 'imic_property_site_address', true);
                $property_pin = get_post_meta($Property_Id, 'imic_property_pincode', true);
                $property_city_value = get_post_meta($Property_Id, 'imic_property_site_city', true);
                $property_price_value = get_post_meta($Property_Id, 'imic_property_price', true);
                $property_area_value = get_post_meta($Property_Id, 'imic_property_area', true);
                $property_baths_value = get_post_meta($Property_Id, 'imic_property_baths', true);
                $property_beds_value = get_post_meta($Property_Id, 'imic_property_beds', true);
                $property_parking_value = get_post_meta($Property_Id, 'imic_property_parking', true);
                $property_amenities_value = get_post_meta($Property_Id, 'imic_property_amenities', true);
                $property_sights_value = get_post_meta($Property_Id, 'imic_property_sights', false);
                $property_amenities_per = $property_amenities_value;
                $type = wp_get_object_terms($Property_Id, 'property-type', array('fields' => 'ids'));
                if (!empty($type)) {
                    $term = get_term($type[0], 'property-type');
                    $property_type_value = $term->name;
                }
                $contract = wp_get_object_terms($Property_Id, 'property-contract-type', array('fields' => 'ids'));
                if (!empty($contract)) {
                    $terms = get_term($contract[0], 'property-contract-type');
                    $property_contract_type_value = $terms->name;
                }
            }
        }
    }
    if (get_query_var('site')) {
        $current_Id = get_query_var('site');
    } else {
        $current_Id = get_the_ID();
    }
    if (($flag == 1) && (!get_query_var('site'))) {
        wp_reset_query();
        $id = 'submit_success';
        $text = __('Your project has been created. Our team will analyze it and optimize your projects unique page before publishing it onto Avaant. Please allow less than twenty minutes.', 'framework');
        $url1 = "location.href='" . get_permalink(get_the_ID()) . "'";
        $url2 = "location.href='" . site_url() . "'";
        echo $modalBox = '<button class="btn btn-primary btn-lg property_prompt" data-toggle="modal" data-target="#' . $id . '"></button>
    <div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="' . $id . 'Label" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    </div>
    <div class="modal-body"> ' . $text . ' </div>
    <div class="modal-footer">
    <button type="button" onclick="' . $url1 . '" class="btn btn-default inverted" data-dismiss="modal">Create another project</button></a>
    <button type="button" onclick="' . $url2 . '" class="btn btn-default inverted" data-dismiss="modal">Back to Home</button>
    </div>
      </div>
    </div>
    </div>';
        ?>
        <script>
            jQuery(document).ready(function () {
                jQuery('.property_prompt').hide();
                jQuery('.property_prompt').click(function () {
                    jQuery('.modal').addClass('in').show();
                });
                jQuery('.property_prompt').trigger('click');
            });
        </script>
        <?php
    }
    if (($flag == 1) && (get_query_var('site'))) {
        wp_reset_query();
        $id = 'submit_success';
        $text = __('Your property has been successfully updated.', 'framework');
        $url1 = "location.href='" . get_permalink(get_the_ID()) . "'";
        $url2 = "location.href='" . site_url() . "'";
        echo $modalBox = '<button class="btn btn-primary btn-lg property_prompt" data-toggle="modal" data-target="#' . $id . '"></button>
    <div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="' . $id . 'Label" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    </div>
    <div class="modal-body"> ' . $text . ' </div>
    <div class="modal-footer">
    <button type="button" onclick="' . $url1 . '" class="btn btn-default inverted" data-dismiss="modal">Add property</button></a>
    <button type="button" onclick="' . $url2 . '" class="btn btn-default inverted" data-dismiss="modal">Back to Home</button>
    </div>
      </div>
    </div>
    </div>';
        ?>
        <script>
            jQuery(document).ready(function () {
                jQuery('.property_prompt').hide();
                jQuery('.property_prompt').click(function () {
                    jQuery('.modal').addClass('in').show();
                });
                jQuery('.property_prompt').trigger('click');
            });
        </script>
        <?php
    }
    ?>
    <!-- Start Content -->
    <div class="main" role="main"><div id="content" class="content full"><div class="container">
                <div class="page"><div class="row"><div class="col-md-12">
                            <form id="add-property" action="#submit-property" method="post" enctype="multipart/form-data">
                                <div class="block-heading" id="details">
                                    <a href="#additionalinfo" class="btn btn-sm btn-default pull-right"><?php _e('Additional Info ', 'framework'); ?><i class="fa fa-chevron-down"></i></a>
                                    <h4><span class="heading-icon"><i class="fa fa-home"></i></span><?php _e('Project Details', 'framework'); ?></h4>
                                </div>
                                <div class="padding-as25 margin-30 lgray-bg">
                                    <div class="row">
                                        <?php $div_class_check = 0; ?>
                                        <?php
                                        if (!empty($property_details_option_enable['1']) == 1) {
                                            $div_class_check++;
                                            ?>
                                            <div class="col-md-4 col-sm-4">                                            
                                                <input name="title" value="<?php echo $property_title; ?>" type="text" class="form-control" placeholder="<?php _e('Project name', 'framework'); ?>">
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if (!empty($property_details_option_enable['2']) == 1) {
                                            $div_class_check++;
                                            ?>
                                            <div class="col-md-4 col-sm-4">
                                                <input name="address" value="<?php echo $property_address_value; ?>" type="text" class="form-control" placeholder="<?php _e('Address', 'framework'); ?>">
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if (!empty($property_details_option_enable['3']) == 1) {
                                            $div_class_check++;
                                            ?>
                                            <div class="col-md-4 col-sm-4">
                                                <input name="area" value="<?php echo $property_area_value; ?>" type="text" class="form-control" placeholder="<?php _e('Area', 'framework'); ?>">
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if ($div_class_check == 4) {
                                            echo '</div><div class="row">';
                                        }
                                        ?>
                                        <?php ?>
                                        <?php
                                        $imic_country_wise_city = imic_get_multiple_city();
                                        if (!empty($imic_country_wise_city)) {
                                            if (!empty($property_details_option_enable['4']) == 1) {
                                                $div_class_check++;
                                                if ($div_class_check == 4) {
                                                    echo '</div><div class="row">';
                                                }
                                                echo '<div class="col-md-4 col-sm-4">';
                                                echo '<select name="city" class="form-control margin-0 selectpicker">';
                                                echo'<option>' . __('Province', 'framework') . '</option>';
                                                foreach ($imic_country_wise_city as $key => $value) {
                                                    if (is_int($key)) {
                                                        echo '<optgroup label="' . $value . '">';
                                                    } else {
                                                        echo "<option value='" . $key . "' " . selected($property_city_value, $key) . ">" . $value . "</option>";
                                                    }
                                                }
                                                echo'</select>';
                                                echo '</div>';
                                            }
                                        }
                                        ?>
                                        <?php
                                        if (!empty($property_details_option_enable['5']) == 1) {
                                            $div_class_check++;
                                            if ($div_class_check == 4) {
                                                echo '</div><div class="row">';
                                            }
                                            ?>
                                            <div class="col-md-4 col-sm-4">
                                                <input name="pin" value="<?php echo $property_pin; ?>" type="text" class="form-control" placeholder="<?php _e('Property Pin Code', 'framework'); ?>">
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if (!empty($property_details_option_enable['6']) == 1) {
                                            $div_class_check++;
                                            if ($div_class_check == 4) {
                                                echo '</div><div class="row">';
                                            }
                                            ?>
                                            <div class="col-md-4 col-sm-4 submit-description">
                                                <textarea name="description" style="resize:vertical" class="form-control margin-0" rows="1" cols="10" placeholder="<?php _e('Project Description', 'framework'); ?>"><?php echo $property_content; ?></textarea>
                                            </div>
                                        <?php } ?>
                                    </div>  
                                    <?php
                                    echo '<div class="row">';
                                    $args = array('orderby' => 'count', 'hide_empty' => false, 'parent' => 0);
                                    $terms = get_terms(array('city-type'), $args);
                                    if (!empty($terms)) {
                                        $selected_other = '';
                                        if (!empty($othertextonomies)) {
                                            $selected_other = "selected=selected";
                                        }
                                        echo '<div class="col-md-4 col-sm-4 cities">';
                                        echo '<select name="textonomies_city[]" data-city-type-value="' . $city_type_value . '" data-last-select_value="" data-id="parent_city" class="textonomies_city form-control margin-0 selectpicker">';
                                        echo'<option value="city">' . __('City', 'framework') . '</option>';
                                        $city_current_id = get_term_by('slug', $city_type_value, 'city-type');
                                        $parent_id = '';
                                        if (!empty($city_current_id)) {
                                            $data = get_term_top_most_parent($city_current_id->term_id, 'city-type');
                                            $parent_id = $data->term_id;
                                        }
                                        foreach ($terms as $term_data) {
                                            echo "<option value='" . $term_data->slug . "' " . selected($parent_id, $term_data->term_id, false) . ">" . $term_data->name . "</option>";
                                        }
                                        echo'<option value ="other" ' . $selected_other . '>' . __('Other', 'framework') . '</option>';
                                        echo'</select>';
                                        echo '</div>';
                                    }
                                    // use for provide othertextonomies meta id in js
                                    echo '<span class ="othertextonomies_meta" id="' . $othertextonomies . '"></span>';
                                    if (!empty($data)) {
                                        echo '<span class ="sub_sub_category_id" id="' . $city_current_id->term_id . '"></span>';
                                    }
                                    echo '</div>';
                                    ?>
                                    <div id="LoadingImage" style="display: none">
                                        <img src="<?php echo get_template_directory_uri() ?>/images/assets/ajax-loader.gif" />
                                    </div>
                                </div>
                                <div class="block-heading" id="additionalinfo">
                                    <a href="#amenities" class="btn btn-sm btn-default pull-right"><?php _e('Enter Amenities ', 'framework'); ?><i class="fa fa-chevron-down"></i></a>
                                    <h4><span class="heading-icon"><i class="fa fa-plus"></i></span><?php _e('Additional Info', 'framework'); ?></h4>
                                </div>
                                <div class="padding-as25 margin-30 lgray-bg">
                                    <div class="row">
                                        <?php $div_additional_row_check = 0; ?>
                                        <?php
                                        if (!empty($additional_info_option_enable['1']) == 1) {
                                            $div_additional_row_check++;
                                            ?>
                                            <div class="col-md-4 col-sm-4">
                                                <input name="price" value="<?php echo $property_price_value; ?>" type="text" class="form-control" placeholder="<?php echo __('Price', 'framework') . '(' . $currency_symbol . ')'; ?>">
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if (!empty($additional_info_option_enable['2']) == 1) {
                                            $div_additional_row_check++;
                                            echo '<div class="col-md-4 col-sm-4 submit-property-type">';
                                            echo '<select name="type" class="form-control margin-0 selectpicker">';
                                            echo '<option>' . __('Project category', 'framework') . '</option>';
                                            $property_type = get_terms('property-type', array(
                                                'hide_empty' => 0
                                            ));
                                            if (!empty($property_type) && !is_wp_error($property_type)) {
                                                foreach ($property_type as $term) {
                                                    $selected = ($property_type_value == $term->name) ? "selected" : "";
                                                    echo '<option ' . $selected . '>' . $term->name . '</option>';
                                                }
                                            }
                                            echo "</select>";
                                            echo '</div>';
                                        }
                                        if (!empty($additional_info_option_enable['3']) == 1) {
                                            $div_additional_row_check++;
                                            echo '<div class="col-md-4 col-sm-4 submit-contract-type">';
                                            echo '<select name="contract" class="form-control margin-0 selectpicker">';
                                            echo '<option>' . __('Contract Type', 'framework') . '</option>';
                                            $property_contract_type = get_terms('property-contract-type', array(
                                                'hide_empty' => 0
                                            ));
                                            if (!empty($property_contract_type) && !is_wp_error($property_contract_type)) {
                                                foreach ($property_contract_type as $term) {
                                                    $selected = ($property_contract_type_value == $term->name) ? "selected" : "";
                                                    echo '<option ' . $selected . '>' . $term->name . '</option>';
                                                }
                                            } echo "</select>";
                                            echo '</div>';
                                        }
                                        ?>
                                        <?php
                                        if ($div_additional_row_check == 4) {
                                            echo '</div><div class="row">';
                                        }
                                        ?>     
                                        <?php
                                        if (!empty($additional_info_option_enable['4']) == 1) {
                                            $div_additional_row_check++;
                                            if ($div_additional_row_check == 4) {
                                                echo '</div><div class="row">';
                                            }
                                            ?>
                                            <div class="col-md-4 col-sm-4">
                                                <select name="beds" class="form-control selectpicker">
                                                    <?php
                                                    echo'<option>' . __('Beds', 'framework') . '</option>';
                                                    $beds_options = $imic_options['properties_beds'];
                                                    foreach ($beds_options as $beds) {
                                                        echo "<option value='" . $beds . "' " . selected($property_beds_value, $beds) . ">" . $beds . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if (!empty($additional_info_option_enable['5']) == 1) {
                                            $div_additional_row_check++;
                                            if ($div_additional_row_check == 4) {
                                                echo '</div><div class="row">';
                                            }
                                            ?>
                                            <div class="col-md-4 col-sm-4">
                                                <select name="baths" class="form-control selectpicker">
                                                    <?php
                                                    echo'<option>' . __('Baths', 'framework') . '</option>';
                                                    $baths_options = $imic_options['properties_baths'];
                                                    foreach ($baths_options as $baths) {
                                                        echo "<option value='" . $baths . "' " . selected($property_baths_value, $baths) . ">" . $baths . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if (!empty($additional_info_option_enable['6']) == 1) {
                                            $div_additional_row_check++;
                                            if ($div_additional_row_check == 4) {
                                                echo '</div><div class="row">';
                                            }
                                            ?>
                                            <div class="col-md-4 col-sm-4">
                                                <select name="parking" class="form-control selectpicker">
                                                    <?php
                                                    echo'<option>' . __('Parking', 'framework') . '</option>';
                                                    $parking_options = $imic_options['properties_parking'];
                                                    foreach ($parking_options as $parking) {
                                                        echo "<option value='" . $parking . "' " . selected($property_parking_value, $parking) . ">" . $parking . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <label><?php _e('Upload project image', 'framework'); ?></label>
                                            <p><?php _e('This is the image that displays with your project. It does not need to be a picture of your actual product. Think of this as the attention grabber!', 'framework'); ?></p> 
                                        </div>
                                    </div>
                                    <div class="row" id="multiplePhotos" style="margin-top:15px;">
                                        <div class="col-md-12 col-sm-12">
                                            <?php
                                            echo'<div class="image-placeholder" id="photoList">';
                                            if (!empty($property_sights_value)) {
                                                foreach ($property_sights_value as $property_sights) {
                                                    $default_featured_image = get_post_meta($Property_Id, '_thumbnail_id', true);
                                                    if ($default_featured_image == $property_sights) {
                                                        $def_class = 'default-feat-image';
                                                    } else {
                                                        $def_class = '';
                                                    }
                                                    echo '<div class="col-md-2 col-sm-2">';
                                                    echo '<div id="property-img"><div id="property-thumb" class="' . $def_class . '"><a id="feat-image" class="accent-color default-image" data-original-title="Set as default image" data-toggle="tooltip" style="text-decoration:none;" href="#"><div class="property-details" style="display:none;"><span class="property-id">' . $Property_Id . '</span><span class="thumb-id">' . $property_sights . '</span></div><img src="' . wp_get_attachment_thumb_url($property_sights) . '" class="image-placeholder" id="filePhoto2" alt=""/></a>';
                                                    if (get_query_var('site')) {
                                                        echo '<input rel="' . $Property_Id . '" type="button" id="' . $property_sights . '" value="Remove" class="btn btn-sm btn-default remove-image">';
                                                    }
                                                    echo '</div></div>';
                                                    echo '</div>';
                                                }
                                            }
                                            echo '</div>';
                                            ?>
                                            <input id="filePhotoMulti" type="file" name="sightMulti[]" multiple onChange="previewMultiPhotos();">
                                        </div>
                                    </div>
                                </div>
                                <div class="block-heading" id="amenities">
                                    <a href="#submit-property" class="btn btn-sm btn-default pull-right"><?php _e('Submit Property ', 'framework'); ?><i class="fa fa-chevron-down"></i></a>
                                    <h4><span class="heading-icon"><i class="fa fa-star"></i></span><?php _e('Team members needed', 'framework'); ?></h4>
                                </div>
                                <div class="padding-as25 margin-30 lgray-bg">
                                    <div class="row">
                                        <?php
                                        $amenity_array = array();
                                        $id = get_query_var('site');
                                        if (!empty($id)) {
                                            $property_amenities = get_post_meta($id, 'imic_property_amenities', true);
                                            global $imic_options;
                                            foreach ($property_amenities as $properties_amenities_temp) {
                                                if ($properties_amenities_temp != 'Not Selected') {
                                                    array_push($amenity_array, $properties_amenities_temp);
                                                }
                                            }
                                        }
                                        global $imic_options;
                                        if (isset($imic_options['properties_amenities']) && count($imic_options['properties_amenities']) > 1) {
                                            foreach ($imic_options['properties_amenities'] as $properties_amenities) {
                                                $am_name = strtolower(str_replace(' ', '', $properties_amenities));
                                                $check = '';
                                                if (in_array($properties_amenities, $amenity_array)) {
                                                    $check = 'checked="checked"';
                                                }
                                                echo '<div class="col-md-2 col-sm-2 col-xs-6">';
                                                echo '<label class="checkbox">';
                                                echo '<input type ="checkbox" name ="' . $am_name . '" ' . $check . ' value ="' . $properties_amenities . '">' . $properties_amenities;
                                                echo '</label>';
                                                echo '</div>';
                                            }
                                        } else {
                                            _e('There is no Properties Amenities', 'framework');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="text-align-center" id="submit-property">
                                    <?php
                                    $current_user_id = $current_user->ID;
                                    $total_property = get_user_meta($current_user_id, 'property_value', true);
                                    $check_for_update = get_query_var('site');
                                    if ((isset($imic_options['plan_show_option'])) && ($imic_options['plan_show_option'] == '1')) {
                                        if (($total_property > 0) || !empty($check_for_update)) {
                                            ?>
                                            <input type="submit" value="<?php _e('Submit Now', 'framework'); ?>" name="submit" class="btn btn-primary btn-lg"/>
                                            <?php
                                        } else {
                                            $pay_for_plan_url = imic_get_template_url('template-price-listing.php');
                                            if (!empty($pay_for_plan_url)) {
                                                $pay_for_plan_url = '<a href="' . $pay_for_plan_url . '">' . __('Buy another plan', 'framework') . '</a>';
                                            }
                                            echo "<div id=\"message\"><div class=\"alert alert-success\">" . __('You have reached your maximum limit for property addition with current plan  ', 'framework') . $pay_for_plan_url . "</div></div>";
                                        }
                                    } else {
                                        echo '<input type="submit" value="' . __('Submit Now', 'framework') . '" name="submit" class="btn btn-primary btn-lg"/>';
                                    }
                                    ?>
                                    <input type="hidden" name="post_type" id="post_type" value="domande" />
                                    <input type="hidden" name="action" value="post" />
                                    <?php wp_nonce_field('new-post'); ?>
                                </div>
                            </form>	
                            <?php
                            if ($msg != '') {
                                echo '<div id="message"><div class="alert alert-error">' . $msg . '</div></div>';
                            }
                            if (isset($pid)) {
                                //echo "<div id=\"message\"><div class=\"alert alert-success\">".__('Successfully Added Property','framework')."</div></div>"; 
                            }
                            ?>
                        </div></div></div></div></div></div>
    <?php
else: echo imic_unidentified_agent();
endif;
get_footer();
?>
