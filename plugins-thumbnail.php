<?php
/*
Plugin Name: Plugins Thumbnail
Plugin URI:
Description: プラグイン一覧画面にサムネイルを追加
Author: PRESSMAN
Author URI: https://www.pressman.ne.jp/
Text Domain: plugin-thumbnail
License: GNU GPL v2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
  die();
}

class PluginThumbnail {

	private static $instance;

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		add_filter( 'manage_plugins_columns', array( $this, 'add_column') );
		add_action( 'manage_plugins_custom_column', array( $this, 'add_column_value' ), 10, 3 );
	}

	public function add_column( $columns ) {
		$add_column = array( 'thumbnail'=>'Thumbnail' );
		$columns = $add_column + $columns;
		return $columns;
	}

	public function add_column_value( $column_name, $plugin_file, $plugin_data ) {
		if ( 'thumbnail' === $column_name ) {
			$plugin_thumbnail_path = $this->get_plugin_image( $plugin_file );
			$dummy_thumbnail_path = 'https://placehold.jp/128x128.png';

			// $options = stream_context_create(array('ssl' => array(
			// 	'ssl' => array(
			// 		'verify_peer'      => false,
		// 	'verify_peer_name' => false)
			// )));
			// $response = file_get_contents($plugin_thumbnail_path, false, $options, 0, 1);

			// if ( $response ) {
			// 	echo '<img src="'. $plugin_thumbnail_path .'"';
			// } else {
			// 	echo '<img src="'. $dummy_thumbnail_path .'"';
			// }
			if ( $plugin_thumbnail_path ) {
				echo '<img src="'. $plugin_thumbnail_path .'"';
			} else {
				echo '<img src="'. $dummy_thumbnail_path .'"';
			}
		}
	}

	public function get_plugin_image( $plugin_file ) {
		$plugin_name = mb_strstr( $plugin_file, '/', true );
		$path_to_image = 'https://ps.w.org/' . $plugin_name . '/assets/icon-128x128.png';
		return $path_to_image;
	}
}

PluginThumbnail::get_instance();

// 公開プラグインじゃない場合
// 公開プラグインだけど画像取得できなかった場合