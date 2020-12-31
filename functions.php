<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

function loginWithUsername($user){

	$args = array(
		'meta_key'     => 'personalNumber',
		'meta_value'   => $user->personalNumber,
	);
	$userExist = get_users( $args );

	if(empty($userExist)){
		// kullanıcı yok
		$user_id = wp_create_user(
			$user->username,
			wp_generate_password( $length = 12, $include_standard_special_chars = false ),
			$user->email
		);

		update_user_meta($user_id,"personalNumber",$user->personalNumber);

	}else{
		//kullanıcı var
		$user_id = $userExist[0]->data->ID;
	}

	$wpUser = get_user_by('ID', $user_id );

	//var_dump($wpUser);

	if ( !is_wp_error( $wpUser ) )
	{

		clean_user_cache($wpUser->data->ID);
		wp_clear_auth_cookie();
		wp_set_current_user($wpUser->data->ID);
		wp_set_auth_cookie($wpUser->data->ID, true, false);
		update_user_caches($wpUser);
		return true;
	}

	return false;
}
