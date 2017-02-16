<?php

/**
 * Pootle Pagebuilder Business Pack Pro public class
 * @property string $token Plugin token
 * @property string $url Plugin root dir url
 * @property string $path Plugin root dir path
 * @property string $version Plugin version
 */
class Pootle_Pagebuilder_Business_Pack_Public {
	/**
	 * @var    Pootle_Pagebuilder_Business_Pack_Public Instance
	 * @access  private
	 * @since    1.0.0
	 */
	private static $_instance = null;

	/** @var stdClass Settings */
	protected $_sets = null;

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
		$this->token   = Pootle_Pagebuilder_Business_Pack::$token;
		$this->url     = Pootle_Pagebuilder_Business_Pack::$url;
		$this->path    = Pootle_Pagebuilder_Business_Pack::$path;
		$this->version = Pootle_Pagebuilder_Business_Pack::$version;
	} // End __construct()

	/**
	 * Adds front end stylesheet and js
	 * @action wp_enqueue_scripts
	 * @since 1.0.0
	 */
	public function enqueue() {
		$token = $this->token;
		$url   = $this->url;

		wp_enqueue_style( $token . '-css', $url . '/assets/front-end.css' );
		wp_enqueue_script( $token . '-js', $url . '/assets/front-end.js', array( 'jquery' ) );
	}

	private function get_properties( $settings ) {
		$pre         = $this->token . '-';
		$this->_sets = new stdClass();
		foreach ( $settings as $k => $v ) {
			if ( 0 === strpos( $k, $pre ) ) {
				$k               = str_replace( $pre, '', $k );
				$this->_sets->$k = $v;
			}
		}
	}

	/**
	 * Adds or modifies the row attributes
	 *
	 * @param array $attr Row html attributes
	 * @param array $settings Row settings
	 *
	 * @return array Row html attributes
	 * @filter pootlepb_row_style_attributes
	 * @since 1.0.0
	 */
	public function content_block( $info ) {
		$settings = json_decode( $info['info']['style'], true );
		$this->get_properties( $settings );
		if ( ! empty( $this->_sets->gmap_code ) ) {
			echo "<div id='ppb-biz-gmap'>{$this->_sets->gmap_code}</div>";
		}
		if ( ! empty( $this->_sets->tabs_accordion ) ) {
			$this->_sets->tabs_accordion_data = json_decode( $this->_sets->tabs_accordion_data, 'assoc_array' );
			$method = 'content_block_render_' . $this->_sets->tabs_accordion;
			if ( method_exists( $this, $method ) ) {
				echo '<div class="ppb-biz-module ppb-biz-' . $this->_sets->tabs_accordion . '">';
				$this->$method();
				echo '</div>';
			}
		}
	}

	protected function content_block_render_accordion() {
		foreach ( $this->_sets->tabs_accordion_data as $i => $item ) {
			echo
			"<a class='ppb-biz-link' href='#' onclick='ppbBizProContent.accordion(event, this, $i)'>$item[Title]<i class='fa fa-plus'></i></a>";
			echo wpautop( "<div class='ppb-biz-content' style='display: none;'>$item[Content]</div>" );
		}
	}

	protected function content_block_render_tabs() {
		$content = '';
		?>
		<div class="ppb-biz-links-wrap">
			<?php
			foreach ( $this->_sets->tabs_accordion_data as $i => $item ) {
				$class = $i ? '' : "active";
				echo
					"<a class='ppb-biz-link $class' href='#' onclick='ppbBizProContent.tabs(event, this, $i)'>$item[Title]</a>";
				$content .=
					wpautop( "<div class='ppb-biz-content $class'>$item[Content]</div>" );
			}
			?>
		</div>
		<?php
		echo "<div class='ppb-biz-content-wrap'>$content</div>";
	}
}