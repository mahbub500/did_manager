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