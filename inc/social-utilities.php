<?php

namespace Athletics\Social_Utilities;

/**
 * Get username from URL
 *
 * @param string $url Social profile URL.
 * @param string $type 'facebook' or 'twitter'
 * @return false|string Username on success, false on failure.
 */
function get_username_from_url( $url, $type ) {

	switch ( $type ) {

		case 'facebook':
			$regex = '#https?\://(?:www\.)?facebook\.com/(\d+|[A-Za-z0-9\.]+)/?#';
			$index = 1;
			break;

		case 'twitter':
			$regex = '|https?://(www\.)?twitter\.com/(#!/)?@?([^/\?]*)|';
			$index = 3;
			break;

		default:
			return false;

	}

	if ( 1 !== preg_match( $regex, $url, $matches ) ) {
		return false;
	}

	if ( ! isset( $matches[ $index ] ) || empty( $matches[ $index ] ) ) {
		return false;
	}

	return $matches[ $index ];

}

/**
 * Get Facebook username from URL
 *
 * @param string $url Facebook profile URL.
 * @return false|string Facebook username on success, false on failure.
 */
function get_facebook_username( $url ) {

	return get_username_from_url( $url, 'facebook' );

}

/**
 * Get Twitter username from URL
 *
 * @param string $url Twitter profile URL.
 * @return false|string Twitter username on success, false on failure.
 */
function get_twitter_username( $url ) {

	return get_username_from_url( $url, 'twitter' );

}

/**
 * Facebook Follow Button
 *
 * @see https://developers.facebook.com/docs/plugins/follow-button
 * @param string $username Facebook URL to follow.
 * @param array $args Optional settings for the follow button.
 * @return string $button Follow button markup.
 */
function facebook_follow_button( $username, $args = array() ) {

	$defaults = array(
		// 'light' or 'dark'
		'color_scheme' => 'light',
		// 'standard', 'button_count', 'button', or 'box_count'
		'layout' => 'button_count',
		// 'true' or 'false'
		'show_faces' => 'false',
	);

	$args = wp_parse_args( $args, $defaults );
	$args = array_map( 'esc_attr', $args );

	$username = esc_attr( $username );

	$button = <<<EOT
<div class="fb-follow" data-href="https://www.facebook.com/{$username}" data-colorscheme="{$args['color_scheme']}" data-layout="{$args['layout']}" data-show-faces="{$args['show_faces']}"></div>
EOT;

	return $button;

}

/**
 * Facebook Like Button
 *
 * @see https://developers.facebook.com/docs/plugins/like-button
 * @param string $url The URL to like.
 * @param array $args Optional settings for the like button.
 * @return string $button Like button markup.
 */
function facebook_like_button( $url, $args = array() ) {

	$defaults = array(
		// 'like' or 'recommend'
		'action' => 'like',
		// 'light' or 'dark'
		'color_scheme' => 'light',
		// 'standard', 'button_count', 'button', or 'box_count'
		'layout' => 'button_count',
		// 'true' or 'false'
		'show_faces' => 'false',
	);

	$args = wp_parse_args( $args, $defaults );
	$args = array_map( 'esc_attr', $args );

	$url = esc_attr( $url );

	$button = <<<EOT
<div class="fb-like" data-href="{$url}" data-action="{$args['action']}" data-colorscheme="{$args['color_scheme']}" data-layout="{$args['layout']}" data-show-faces="{$args['show_faces']}"></div>
EOT;

	return $button;

}

/**
 * Facebook Page Plugin
 *
 * @see https://developers.facebook.com/docs/plugins/page-plugin
 * @since 0.2.2
 * @param string $page_url The Facebook page URL.
 * @param array $args Optional settings.
 * @return string $embed Page plugin markup.
 */
function facebook_page_plugin( $page_url, $args = array() ) {

	$defaults = array(
		// min '280', max '500'
		'width' => 340,
		// min '130'
		'height' => 500,
		// 'true' or 'false'
		'hide_cover' => 'false',
		// 'true' or 'false'
		'show_facepile' => 'true',
		// 'true' or 'false'
		'show_posts' => 'false',
	);

	$args = wp_parse_args( $args, $defaults );
	$args = array_map( 'esc_attr', $args );

	$page_url = esc_attr( $page_url );

	$embed = <<<EOT
<div class="fb-page" data-href="{$page_url}" data-width="{$args['width']}" data-height="{$args['height']}" data-hide-cover="{$args['hide_cover']}" data-show-facepile="{$args['show_facepile']}" data-show-posts="{$args['show_posts']}"></div>
EOT;

	return $embed;

}

/**
 * Google+ Follow Button
 *
 * @see https://developers.google.com/+/web/follow/
 * @param string $page_id Google+ page ID to follow.
 * @param array $args Optional settings for the follow button.
 * @return string $button Follow button markup.
 */
function google_plus_follow_button( $page_id, $args = array() ) {

	$defaults = array(
		// 'none', 'bubble', or 'vertical-bubble'
		'annotation' => 'bubble',
		// '15', '20', or '24'
		'height' => '20',
		// 'author' or 'publisher'
		'rel' => 'author',
	);

	$args = wp_parse_args( $args, $defaults );
	$args = array_map( 'esc_attr', $args );

	$page_id = esc_attr( $page_id );

	$button = <<<EOT
<div class="g-follow" data-href="https://plus.google.com/{$page_id}" data-annotation="{$args['annotation']}" data-height="{$args['height']}" data-rel="{$args['rel']}"></div>
EOT;

	return $button;

}

/**
 * Twitter Follow Button
 *
 * @see https://dev.twitter.com/docs/follow-button
 * @param string $username Twitter user to follow.
 * @param array $args Optional settings for the follow button.
 * @return string $button Follow button markup.
 */
function twitter_follow_button( $username, $args = array() ) {

	$defaults = array(
		// 'true' or 'false'
		'show_screen_name' => 'true',
		// 'true' or 'false'
		'show_count' => 'true',
		// 'medium' or 'large'
		'size' => 'medium',
		// 'en', 'fr', 'de', 'it', 'es', 'ko', or 'ja'
		'lang' => 'en',
		// 'true' or 'false'
		'opt_out' => 'true',
	);

	$args = wp_parse_args( $args, $defaults );
	$args = array_map( 'esc_attr', $args );

	$username = str_replace( '@', '', $username );
	$username = esc_attr( $username );

	$button = <<<EOT
<a href="https://twitter.com/{$username}" class="twitter-follow-button" data-show-screen-name="{$args['show_screen_name']}" data-show-count="{$args['show_count']}" data-size="{$args['size']}" data-lang="{$args['lang']}" data-dnt="{$args['opt_out']}">Follow @{$username}</a>
EOT;

	return $button;

}