<?php
if( ! function_exists( 'get_plugin_data' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

/**
 * Gets the site's base URL
 * 
 * @uses get_bloginfo()
 * 
 * @return string $url the site URL
 */
if( ! function_exists( 'dm_site_url' ) ) :
function dm_site_url() {
	$url = get_bloginfo( 'url' );

	return $url;
}
endif;

/**
 * Noakhlai Upozila list
 */
if( ! function_exists( 'all_upozila_list' ) ) :
function all_upozila_list() {
	$upazila_areas = [
	    'Subarna_Char' => [
	        'Char Amanullah',
	        'Char Bata',
	        'Char Jubaly',
	        'Char Clerk',
	        'Char Jabbar',
	        'Char Wapda'
	    ],
	    'Kabir_Hat' => [
	        'Batya',
	        'Chaprashirhat',
	        'Ghoshbag',
	        'Narottampur',
	        'Sundalpur'
	    ],
	    'Sonaimuri' => [
	        'Ambarnagar',
	        'Amisha Para',
	        'Bazra',
	        'Deoti',
	        'Jayag',
	        'Nadana',
	        'Nateshwar',
	        'Sonaimuri',
	        'Sonapur',
	        'Baragaon',
	        'Chashir Hat (Old Sonaimuri)'
	    ],
	    'Noakhali_sadar' => [
	        'Ashwadia',
	        'Batya',
	        'Binodpur',
	        'Char Matua',
	        'Dadpur',
	        'Ewazbalia',
	        'Ghoshbag',
	        'Kadir Hanif',
	        'Kaladarap',
	        'Narottampur',
	        'Noazpur',
	        'Noakhali',
	        'Noannai',
	        'Sundalpur'
	    ],
	    'Chatkhil' => [
	        'Badalkut',
	        'Hatpukoria',
	        'Khil Para',
	        'Mohammadpur',
	        'Nayakhola',
	        'Panchgaon',
	        'Parkote',
	        'Ramnarayanpur',
	        'Sahapur'
	    ],
	    'Begumganj' => [
	        'Alyarpur',
	        'Amanullapur',
	        'Begumganj',
	        'Chhayani',
	        'Durgapur',
	        'Eklashpur',
	        'Gopalpur',
	        'Narottampur',
	        'Hajipur',
	        'Jirtali',
	        'Kadirpur',
	        'Kutubpur',
	        'Mir Warishpur',
	        'Rajganj',
	        'Rasulpur',
	        'Sharifpur'
	    ],
	    'Companiganj' => [
	        'Char Elahi',
	        'Char Fakira',
	        'Char Hazari',
	        'Char Kakra',
	        'Char Parbati',
	        'Musapur',
	        'Rampur',
	        'Sirajpur'
	    ],
	    'Hatiya' => [
	        'Burir Char',
	        'Char Ishwar',
	        'Char King',
	        'Harni Chanandi',
	        'Jahajmara',
	        'Nalchira',
	        'Sonadia',
	        'Sukh Char',
	        'Tamaruddin',
	        'Nijhumdip'
	    ],
	    'Senbag' => [
	        'Arjuntala',
	        'Bijbagh',
	        'Chhatarpaia',
	        'Dumuria',
	        'Kabilpur',
	        'Kadra',
	        'Kesharpar',
	        'Mohammadpur',
	        'Nabipur'
	    ]
	];


	return $upazila_areas;
}



endif;

/**
 * Upload multiple image 
 */
if( ! function_exists( 'handle_image_upload' ) ) :
function handle_image_upload($file_key, $nid_number, $suffix = '') {
    if (!empty($_FILES[$file_key]['name'])) {
        $uploaded_file = $_FILES[$file_key];
        $file_name = sanitize_file_name($nid_number . $suffix . '-' . $uploaded_file['name']);
        $upload_overrides = [
            'test_form' => false, 
            'unique_filename_callback' => function($dir, $name, $ext) use ($file_name) {
                return $file_name;
            }
        ];

        $upload = wp_handle_upload($uploaded_file, $upload_overrides);

        if ($upload && !isset($upload['error'])) {
            $attachment_data = [
                'guid'           => $upload['url'],
                'post_mime_type' => $upload['type'],
                'post_title'     => sanitize_file_name($file_name),
                'post_content'   => '',
                'post_status'    => 'inherit',
            ];

            $attachment_id = wp_insert_attachment($attachment_data, $upload['file']);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attachment_metadata = wp_generate_attachment_metadata($attachment_id, $upload['file']);
            wp_update_attachment_metadata($attachment_id, $attachment_metadata);

            return $attachment_id; // Return attachment ID if needed
        } else {
            wp_send_json_error('Failed to upload ' . $file_key . ': ' . $upload['error']);
        }
    }
    return false;
}

endif;


