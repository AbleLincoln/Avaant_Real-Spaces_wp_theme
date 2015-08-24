<?php
/* * ** Meta Box Functions **** */
$prefix = 'imic_';
global $meta_boxes, $imic_options;
load_theme_textdomain('framework', IMIC_FILEPATH . '/language');
$meta_boxes = array();
/* Post/Page Title and Banner Meta Box
=========================================== */
$meta_boxes[] = array(
    'id' => 'post_page_meta_box',
    'title' => __('Custom Title/Banner Meta Box', 'framework'),
    'pages' => array('post','page'),
    'fields' => array(
        // Custom title
        array(
            'name' => __('Custom Title', 'framework'),
            'id' => $prefix . 'post_page_custom_title',
            'desc' => __("Enter Custom Title.", 'framework'),
            'type' => 'text',
        ),
		//Map Display
        array(
            'name' => __('Banner Type', 'framework'),
            'id' => $prefix . 'banner_type',
            'desc' => __("Select banner type to display on page.", 'framework'),
            'type' => 'select',
            'options' => array(
                'no' => __('Default', 'framework'),
                'banner' => __('Banner', 'framework'),
                'map' => __('Map', 'framework'),
            ),
        ),
        array(
            'name' => __('Banner Image', 'framework'),
            'id' => $prefix . 'banner_image',
            'desc' => __("Upload banner image for this Page/Post.", 'framework'),
            'type' => 'image_advanced',
            'max_file_uploads' => 1
        ),
)
);
/* Home Page Slider Options (Home Meta Box 2)
=============================================================*/
$meta_boxes[] = array(
    'id' => 'template-home2',
    'title' => __('Home Page Slider Options', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		//Slider auto slide
        
           array(
            'name' => __('Choose Slider', 'framework'),
            'id' => $prefix . 'slider_with_property',
            'desc' => __("Select Slider Display.", 'framework'),
            'type' => 'select',
            'options' => array(
                '0' => __('Slider With Property', 'framework'),
                '1' => __('Slider Without Property', 'framework'),
                '2' => __('Revolution Slider', 'framework'),
            ),
        ),
          //Slider Image
        array(
            'name' => __('Slider Image', 'framework'),
            'id' => $prefix . 'slider_image',
            'desc' => __("Enter Slider Image.", 'framework'),
            'type' => 'image_advanced',
        ),
        array(
                   'name' => __('Select Revolution Slider from list','framework'),
                    'id' => $prefix . 'pages_select_revolution_from_list',
                    'desc' => __("Select Revolution Slider from list", 'framework'),
                    'type' => 'select',
                    'options' => imicRevSliderShortCode(),
                ),
        array(
            'name' => __('Slider Auto Slide', 'framework'),
            'id' => $prefix . 'slider_auto_slide',
            'desc' => __("Select Yes to slide automatically.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		//Slider arrows
		array(
            'name' => __('Slider Direction Arrows', 'framework'),
            'id' => $prefix . 'slider_direction_arrows',
            'desc' => __("Select Yes to show slider direction arrows.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		//Slider effects
		array(
            'name' => __('Slider Effects', 'framework'),
            'id' => $prefix . 'slider_effects',
            'desc' => __("Select effects for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'fade' => __('Fade', 'framework'),
                'slide' => __('Slide', 'framework'),
            ),
        ),
));
/* Home Page Recent Listed Section Options (Home Meta Box 3)
=============================================================*/
$meta_boxes[] = array(
    'id' => 'template-home3',
    'title' => __('Recent Listed Section Options', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		//Enable/Disable Recent Listed Section
		array(
            'name' => __('Recent Listed Section', 'framework'),
            'id' => $prefix . 'home_recent_section',
            'desc' => __('Enable/Disable Recent Listed Section on Home Page.', 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('Enable', 'framework'),
                '0' => __('Disable', 'framework'),
            ),
			'std' => 1,
        ),
		//Recent Listed Section Heading
        array(
            'name' => __('Recent Listed Section Heading', 'framework'),
            'id' => $prefix . 'home_recent_heading',
            'desc' => __("Enter Recent Listed Section Heading text to show on Home page", 'framework'),
            'type' => 'text',
            'std' => 'Recent Listed'
        ),
		//Recent Listed Section more link
        array(
            'name' => __('View more properties URL', 'framework'),
            'id' => $prefix . 'home_recent_more',
            'desc' => __("Enter Recent Listed Section's view more properties URL to redirect link", 'framework'),
            'type' => 'url'
        ),
		//Number of Recent Listed Property
        array(
            'name' => __('Number of Properties', 'framework'),
            'id' => $prefix . 'home_recent_property_no',
            'desc' => __("Enter number of Recent Listed property to show on Home page", 'framework'),
            'type' => 'number',
            'std' => 3
        ),
));
/* Home Page Featured Properties Section Options (Home Meta Box 4)
=============================================================*/
$meta_boxes[] = array(
    'id' => 'template-home4',
    'title' => __('Featured Properties Section Options', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		//Enable/Disable Featured properties Section
		array(
            'name' => __('Featured properties Section', 'framework'),
            'id' => $prefix . 'home_featured_section',
            'desc' => __('Enable/Disable Featured Properties Section on Home Page.', 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('Enable', 'framework'),
                '0' => __('Disable', 'framework'),
            ),
			'std' => 1,
        ),
		//Featured Section Heading
        array(
            'name' => __('Featured Section Heading', 'framework'),
            'id' => $prefix . 'home_featured_heading',
            'desc' => __("Enter Featured Properties Section Heading text to show on Home page", 'framework'),
            'type' => 'text',
            'std' => 'Featured Properties'
        ),
));
/* Partners Meta Box
======================= */
$meta_boxes[] = array(
    'id' => 'partners_meta_box',
    'title' => __('Partners Meta Box', 'framework'),
    'pages' => array('partner'),
    'fields' => array(
        
        array(
            'name' => __('Display on Home page', 'framework'),
            'id' => $prefix . 'partner_home',
            'desc' => __("Check for display on site index(home) page.", 'framework'),
            'type' => 'checkbox',
			'std'  => 1,
        ),
		//Partner Image
		array(
            'name' => __('Partner Logo', 'framework'),
            'id' => $prefix . 'partner_logo',
            'desc' => __("Upload Partner's Logo.", 'framework'),
            'type' => 'image_advanced',
            'max_file_uploads' => 1
        ),
		//Partner URL
		array(
            'name' => __('URL', 'framework'),
            'id' => $prefix . 'partner_url',
            'desc' => __("Enter partner logo url.", 'framework'),
            'type' => 'text',
        ),
		array(
            'name' => __('Target Blank', 'framework'),
            'id' => $prefix . 'partner_target',
            'desc' => __("Open partner link target to blank page.", 'framework'),
            'type' => 'checkbox',
			'std'  => 1,
        ),
     )
);
/* Home Page Partner Meta Box (Home Meta Box 6)
=============================================================*/
$meta_boxes[] = array(
    'id' => 'template-home6',
    'title' => __('Partner Section', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		array(
            'name' => __('Partners', 'framework'),
            'id' => $prefix . 'home_partners_section',
            'desc' => __('Enable/Disable Partners Section on Home Page.', 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('Enable', 'framework'),
                '0' => __('Disable', 'framework'),
            ),
			'std' => 1,
        ),
		//Partner Title
		 array(
            'name' => __('Partner Heading', 'framework'),
            'id' => $prefix . 'home_partner_heading',
            'desc' => __("Enter heading for partner section.", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
		//All Partner URL
        array(
            'name' => __('All Partner URL', 'framework'),
            'id' => $prefix . 'home_partner_url',
            'desc' => __("Enter URL for all partner.", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
));
/* Property Page Layout (Home Meta Box 1)
=============================================================*/
$meta_boxes[] = array(
    'id' => 'template-property-listing1',
    'title' => __('Property Layout Options', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		//Design Layout
        array(
            'name' => __('Design Layout', 'framework'),
            'id' => $prefix . 'property_design_layout',
            'desc' => __("Select design layout to change property page design.", 'framework'),
            'type' => 'select',
            'options' => array(
                'listing' => __('Listing', 'framework'),
                'grid' => __('Grid', 'framework'),
            ),
			'std' => 'listing',
        ),
		array(
            'name' => __('Listing Layout URL', 'framework'),
            'id' => $prefix . 'property_listing_url',
            'desc' => __("Enter Recent Listed Section Heading text to show on Home page", 'framework'),
            'type' => 'text',
        ),
		array(
            'name' => __('Grid Layout URL', 'framework'),
            'id' => $prefix . 'property_grid_url',
            'desc' => __("Enter Recent Listed Section Heading text to show on Home page", 'framework'),
            'type' => 'text',
        ),
));
/* Register Agent Page Layout Options (Register Agent Meta Box 1)
========================================================= */
$meta_boxes[] = array(
    'id' => 'template-register1',
    'title' => __('Login/Register Page Layout Options', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		//Layout options
		array(
            'name' => __('Page Layout Options', 'framework'),
            'id' => $prefix . 'register_layout',
            'desc' => __("Select login/register page layout as per requirement.", 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('Text - Login - Register', 'framework'),
                '2' => __('Text - Login', 'framework'),
                '3' => __('Text - Register', 'framework'),
            ),
        ),       
    )
);
/* Redirect after Registration Agent Page  Options (Register Agent Meta Box 2)
========================================================= */
$meta_boxes[] = array(
    'id' => 'template-register2',
    'title' => __('Login/Register Redirect Options', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		//Layout options
            array(
            'name' => __('Login Redirect Option', 'framework'),
            'id' => $prefix . 'login_redirect_options',
            'desc' => __("Enter Login Redirect Url.", 'framework'),
            'type' => 'url',
            ), 
          array(
            'name' => __('Register Redirect Option', 'framework'),
            'id' => $prefix . 'register_redirect_options',
            'desc' => __("Enter Register Redirect Url.", 'framework'),
            'type' => 'url',
            ), 
    )
);
/* Contact Page Form Details (Contact Meta Box 1)
========================================================= */
$meta_boxes[] = array(
    'id' => 'template-contact1',
    'title' => __('Contact Form Meta Box', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
        //Email
        array(
            'name' => __('Email', 'framework'),
            'id' => $prefix . 'contact_email',
            'desc' => __("Enter Email to Use in contact Form in default admin email used.", 'framework'),
            'type' => 'text',
            'std' => get_option('admin_email')
        ),
        //Subject
        array(
            'name' => __('Subject', 'framework'),
            'id' => $prefix . 'contact_subject',
            'desc' => __("Enter Subject to Use in contact Page.", 'framework'),
            'type' => 'text',
        ),
    )
);
/* Contact Page Details (Contact Meta Box 2)
========================================================= */
$meta_boxes[] = array(
    'id' => 'template-contact2',
    'title' => __('Contact Details Meta Box', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
        //Our Location Text
        array(
            'name' => __('Our Location Address', 'framework'),
            'id' => $prefix . 'our_location_address',
            'desc' => __("Enter the Our Location Address to display on cotact page.", 'framework'),
            'type' => 'text',
			'std' => '',
        ),
        array(
             'id' => $prefix . 'contact_lat_long',
			'name' => __( 'Location', 'meta-box' ),
			'type' => 'map',
			'std' => '-6.233406,-35.049906,15', // 'latitude,longitude[,zoom]' (zoom is optional)
			'style' => 'width: 500px; height: 400px',
			'address_field' => 'imic_our_location_address', // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
			),
         // Contact Zoom
            array(
            'name' => __('Contact Zoom Option', 'framework'),
            'id' => $prefix . 'contact_zoom_option',
            'desc' => __('Enter the Zoom level  for Contact Map', 'framework'),
            'type' => 'text',
            ),
		//Email
        array(
            'name' => __('Email Us', 'framework'),
            'id' => $prefix . 'contact_email_us',
            'desc' => __("Enter Email to display under contact address for email us.", 'framework'),
            'type' => 'text',
            'std' => get_option('admin_email')
        ),
		//Call us
        array(
            'name' => __('Call Us', 'framework'),
            'id' => $prefix . 'contact_call_us',
            'desc' => __("Enter number to display under contact address for call us.", 'framework'),
            'type' => 'text',
            'std' => '080 378678 90',
        ),
    )
);
/* Our Agent Page Become an Agent Details (Our Agent Meta Box 1)
========================================================= */
$meta_boxes[] = array(
    'id' => 'template-our-agents1',
    'title' => __('Become an Agent Options', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
        //Button Text
        array(
            'name' => __('Become an Agent Button Text', 'framework'),
            'id' => $prefix . 'agent_become_agent_text',
            'desc' => __("Enter Become an Agent text to display on button.", 'framework'),
            'type' => 'text',
            'std' => 'Become an agent',
        ),
        //Button Link
        array(
            'name' => __('Become an Agent Button URL', 'framework'),
            'id' => $prefix . 'agent_become_agent_url',
            'desc' => __("Enter Become an Agent url to redirect.", 'framework'),
            'type' => 'url',
        ),
    )
);
/* Property Submit Template
========================================================= */
$meta_boxes[] = array(
    'id' => 'template-blog1',
    'title' => __('Blog Type', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
        //PROPERTY STATUS
        array(
            'name' => __('Blog Type', 'framework'),
            'id' => $prefix . 'blog_type',
            'desc' => __("Select type of blog.", 'framework'),
            'type' => 'select',
            'options' => array(
                'masonry' => __('Masonry', 'framework'),
                'timeline' => __('Timeline', 'framework'),
            ),
			'std' => 'masonry',
        ),
    )
);
/* Property Submit Template
========================================================= */
$meta_boxes[] = array(
    'id' => 'template-submit-property1',
    'title' => __('Property Status', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
        //PROPERTY STATUS
        array(
            'name' => __('Property Status', 'framework'),
            'id' => $prefix . 'property_status',
            'desc' => __("Select Status for Property.", 'framework'),
            'type' => 'select',
            'options' => array(
                'draft' => __('Pending Review', 'framework'),
                'publish' => __('Publish', 'framework'),
            ),
			'std' => 'draft',
        ),
    )
);
/* Slide Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'slide_meta_box',
    'title' => __('Properties', 'framework'),
    'pages' => array('slide'),
    'fields' => array(
			array(
			'name' => __( 'Property list', 'framework' ),
			'id' => $prefix . "property_listing",
			'type' => 'post',
			'post_type' => 'property',
			'field_type' => 'select_advanced',
			'query_args' => array(
			'post_status' => 'publish',
			'posts_per_page' => '-1',
			)
			),
    )
);
$meta_boxes[] = array(
    'id' => 'property_banner_meta_box',
    'title' => __('Property Banner Meta Box', 'framework'),
    'pages' => array('property'),
    'fields' => array(
        	array(
            'name' => __('Property Banner Type', 'framework'),
            'id' => $prefix . 'property_banner_type',
            'desc' => __('Select Banner Type.', 'framework'),
            'type' => 'select',
            'options' => array(
                'featured_image' => __('Featured Image', 'framework'),
                'map' => __('Map', 'framework'),
                'default_image' => __('Default Image', 'framework'),
            ),
			
        ),
      )
);
/* Property Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'slide_meta_box',
    'title' => __('Property Details', 'framework'),
    'pages' => array('property'),
    'fields' => array(
		array(
			'name' => __('Property ID', 'framework'),
			'id' => $prefix . 'property_site_id',
			'desc' => __("This field will automatically fill, do not edit until required.", 'framework'),
			'clone' => false,
			'type' => 'text',
			'std' => '',
			),
		array(
            'name' => __('Property Address', 'framework'),
            'id' => $prefix . 'property_site_address',
            'desc' => __("Enter the Property Address.", 'framework'),
            'clone' => false,
            'type' => 'text',
            'std' => '',
        ),
		array(
			'id' => $prefix . 'lat_long',
			'name' => __( 'Location', 'meta-box' ),
			'type' => 'map',
			'std' => '-6.233406,-35.049906,15', // 'latitude,longitude[,zoom]' (zoom is optional)
			'style' => 'width: 500px; height: 400px',
			'address_field' => 'imic_property_site_address', // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
			),
		array(
            'name' => __('Province', 'framework'),
            'id' => $prefix . 'property_site_city',
            'desc' => __('Select State/City for property.', 'framework'),
            'type' => 'select',
            'options' => imic_get_multiple_city()
            ),
        array(
            'name' => __('Property Value', 'framework'),
            'id' => $prefix . 'property_price',
            'desc' => __("Enter the Property Value.", 'framework'),
            'clone' => false,
            'type' => 'text',
            'std' => '',
        ),
        // AREA
        array(
            'name' => __('Property Area', 'framework'),
            'id' => $prefix . 'property_area',
            'desc' => __("Enter the Property Area.", 'framework'),
            'clone' => false,
            'type' => 'text',
            'std' => '',
        ),
        // BATHS
        array(
            'name' => __('Baths', 'framework'),
            'id' => $prefix . 'property_baths',
            'desc' => __("Enter the Number of Baths.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
        // BEDS
        array(
            'name' => __('Beds', 'framework'),
            'id' => $prefix . 'property_beds',
            'desc' => __("Enter the Number of Bedrooms.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
      // PARKING
         array(
            'name' => __('Parking', 'framework'),
            'id' => $prefix . 'property_parking',
            'desc' => __("Enter the Number of Parkings.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		// IMAGES
		array(
            'name' => __('Property Sights', 'framework'),
            'id' => $prefix . 'property_sights',
            'desc' => __("Upload Property sights.", 'framework'),
            'type' => 'image_advanced',
            'max_file_uploads' => 30
        ),
		// AMENITIES
         array(
            'name' => __('Amenities', 'framework'),
            'id' => $prefix . 'property_amenities',
            'desc' => __("Enter the Amenities of Parkings.", 'framework'),
            'type' => 'text',
			'clone' => true,
            'std' => '',
        ),
		// FEATURED
		array(
            'name' => __('Featured Property', 'framework'),
            'id' => $prefix . 'featured_property',
            'desc' => __('Select Yes to make this property featured.', 'framework'),
            'type' => 'select',
            'options' => array(
                '0' => __('No', 'framework'),
                '1' => __('Yes', 'framework'),
            ),
			'std' => 0,
        ),
		// Property Under Slider
		array(
            'name' => __('Property Slide', 'framework'),
            'id' => $prefix . 'slide_property',
            'desc' => __('Select Yes to display this property in homepage slider.', 'framework'),
            'type' => 'select',
            'options' => array(
                '0' => __('No', 'framework'),
                '1' => __('Yes', 'framework'),
            ),
			'std' => 0,
        ),
        // Property Pincode
            array(
            'name' => __('Property Pincode', 'framework'),
            'id' => $prefix . 'property_pincode',
            'desc' => __('Enter the Pincode of Property', 'framework'),
            'type' => 'text',
            ),
        // Property Custom City
            array(
            'name' => __('Property Custom City', 'framework'),
            'id' => $prefix . 'property_custom_city',
            'desc' => __('Do not Delete this field', 'framework'),
            'type' => 'hidden',
            ),
         // Property Email Status
          array(
            'name' => __('Property Email Status', 'framework'),
            'id' => $prefix . 'property_email_status',
            'desc' => __('Do not Delete this field', 'framework'),
            'type' => 'hidden',
            ),
        // Property Zoom
            array(
            'name' => __('Property Zoom Option', 'framework'),
            'id' => $prefix . 'property_zoom_option',
            'desc' => __('Enter the Zoom level  for Property Map', 'framework'),
            'type' => 'text',
            ),
        //Avnt Contact Email
          array(
            'name' => __('Contact email', 'framework'),
            'id' => $prefix . 'project_email',
            'desc' => __('Contact email for this project', 'framework'),
            'type' => 'text',
          ),
      )
);
/* Testimonial Meta Box
===================================================*/
$meta_boxes[] = array(
    'id' => 'testimonial_meta_box',
    'title' => __('Testimonial  Meta Box', 'framework'),
    'pages' => array('testimonials'),
    'fields' => array(
	//Company Name
		array(
            'name' => __('Company Name', 'framework'),
            'id' => $prefix . 'client_company',
            'desc' => __("Enter the Company for Client.", 'framework'),
            'type' => 'text',
			'clone' => false,
            'std' => '',
        ),
		 array(
            'name' => __('Client Url', 'framework'),
            'id' => $prefix . 'client_co_url',
            'desc' => __("Enter the Client URL.", 'framework'),
            'type' => 'url',
        ),
		));
/* * ** Gallery  Pagination Meta Box 1 *** */
$meta_boxes[] = array(
    'id' => 'template-gallery1',
    'title' => __('Gallery to show', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
		// Gallery Images
        array(
            'name' => __('Gallery Image', 'framework'),
            'id' => $prefix . 'gallery_images',
            'desc' => __("Enter Gallery Image.", 'framework'),
            'type' => 'image_advanced',
        ),
		array(
            'name' => __('Gallery Type', 'framework'),
            'id' => $prefix . 'gallery_type',
            'desc' => __('Select gallery type.', 'framework'),
            'type' => 'select',
            'options' => array(
                '0' => __('Grid', 'framework'),
                '1' => __('Masonry', 'framework'),
            ),
			'std' => 0,
        ),
        //Number of Gallery to show
        array(
            'name' => __('Number of Gallery to show.', 'framework'),
            'id' => $prefix . 'gallery_pagination_to_show_on',
            'desc' => __("Enter number of images to show on a page.", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
         array(
            'name' => __('Design Layout', 'framework'),
            'id' => $prefix . 'gallery_pagination_columns_layout',
            'desc' => __("Choose column layout.", 'framework'),
            'type' => 'select',
            'options' => array(
                '2' => __('2 Column', 'framework'),
                '3' => __('3 Column', 'framework'),
				'4' => __('4 Column', 'framework'),
            ),
			'std' => '3',
        ),
    )
);
/* Gallery Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'gallery_meta_box',
    'title' => __('Post Meta Box', 'framework'),
    'pages' => array('post'),
    'fields' => array(
        // Gallery Link Url
        array(
            'name' => __('Link Url', 'framework'),
            'id' => $prefix . 'gallery_link_url',
            'desc' => __("Enter the Link URL.", 'framework'),
            'type' => 'url',
        ),
        // Gallery Images
        array(
            'name' => __('Gallery Image', 'framework'),
            'id' => $prefix . 'gallery_images',
            'desc' => __("Enter Gallery Image.", 'framework'),
            'type' => 'image_advanced',
        ),
       array(
            'name' => __('Slider Pagination', 'framework'),
            'id' => $prefix . 'gallery_slider_pagination',
            'desc' => __("Enable to show pagination for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Enable', 'framework'),
                'no' => __('Disable', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Auto Slide', 'framework'),
            'id' => $prefix . 'gallery_slider_auto_slide',
            'desc' => __("Select Yes to slide automatically.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Direction Arrows', 'framework'),
            'id' => $prefix . 'gallery_slider_direction_arrows',
            'desc' => __("Select Yes to show slider direction arrows.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Effects', 'framework'),
            'id' => $prefix . 'gallery_slider_effects',
            'desc' => __("Select effects for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'fade' => __('Fade', 'framework'),
                'slide' => __('Slide', 'framework'),
            ),
        ),
    )
);
/* * ******************* META BOX REGISTERING ********************** */
/**
 * Register meta boxes
 *
 * @return void
 */
function imic_register_meta_boxes() {
    global $meta_boxes;
    // Make sure there's no errors when the plugin is deactivated or during upgrade
    if (class_exists('RW_Meta_Box')) {
        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
    }
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking Page template, categories, etc.
add_action('admin_init', 'imic_register_meta_boxes');
/* * ******************* META BOX CHECK ********************** */
/**
 * Check if meta boxes is included
 *
 * @return bool
 */
function rw_maybe_include($template_file) {
    // Include in back-end only
    if (!defined('WP_ADMIN') || !WP_ADMIN)
        return false;
    // Always include for ajax
    if (defined('DOING_AJAX') && DOING_AJAX)
        return true;
    // Check for post IDs
    $checked_post_IDs = array();
    if (isset($_GET['post']))
        $post_id = $_GET['post'];
    elseif (isset($_POST['post_ID']))
        $post_id = $_POST['post_ID'];
    else
        $post_id = false;
    $post_id = (int) $post_id;
    if (in_array($post_id, $checked_post_IDs))
        return true;
    // Check for Page template
    $checked_templates = array($template_file);
    $template = get_post_meta($post_id, '_wp_page_template', true);
    if (in_array($template, $checked_templates))
        return true;
// If no condition matched
    return false;
}
?>