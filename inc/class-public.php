<?php

/**
 * Pootle Pagebuilder Business Pack Pro public class
 * @property string $token Plugin token
 * @property string $url Plugin root dir url
 * @property string $path Plugin root dir path
 * @property string $version Plugin version
 */
class Pootle_Pagebuilder_Business_Pack_Public{

	/**
	 * @var 	Pootle_Pagebuilder_Business_Pack_Public Instance
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * Main Pootle Pagebuilder Business Pack Pro Instance
	 * Ensures only one instance of Storefront_Extension_Boilerplate is loaded or can be loaded.
	 * @since 1.0.0
	 * @return Pootle_Pagebuilder_Business_Pack_Public instance
	 */
	public static function instance() {
		if ( null == self::$_instance ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Constructor function.
	 * @access  private
	 * @since   1.0.0
	 */
	private function __construct() {
		$this->token   =   Pootle_Pagebuilder_Business_Pack::$token;
		$this->url     =   Pootle_Pagebuilder_Business_Pack::$url;
		$this->path    =   Pootle_Pagebuilder_Business_Pack::$path;
		$this->version =   Pootle_Pagebuilder_Business_Pack::$version;
	} // End __construct()

	/**
	 * Adds front end stylesheet and js
	 * @action wp_enqueue_scripts
	 * @since 1.0.0
	 */
	public function enqueue() {
		$token = $this->token;
		$url = $this->url;

		wp_enqueue_style( $token . '-css', $url . '/assets/front-end.css' );
		wp_enqueue_script( $token . '-js', $url . '/assets/front-end.js', array( 'jquery' ) );
	}

	private function get_properties( $settings ) {
		$pre = $this->token . '-';
		foreach ( $settings as $k => $v ) {
			if ( 0 === strpos( $k, $pre ) ) {
				$k        = str_replace( $pre, '', $k );
				$this->$k = $v;
			}
		}
	}
	
	/**
	 * Adds or modifies the row attributes
	 * @param array $attr Row html attributes
	 * @param array $settings Row settings
	 * @return array Row html attributes
	 * @filter pootlepb_row_style_attributes
	 * @since 1.0.0
	 */
	public function content_block( $info ) {
		$settings = json_decode( $info['info']['style'], true );
		$this->get_properties( $settings );
		if ( ! empty( $this->gmap_code ) ) {
			echo "<div id='ppb-biz-gmap'>{$this->gmap_code}</div>";
		}
	}
}