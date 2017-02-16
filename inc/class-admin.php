<?php
/**
 * Pootle Pagebuilder Business Pack Pro Admin class
 * @property string token Plugin token
 * @property string $url Plugin root dir url
 * @property string $path Plugin root dir path
 * @property string $version Plugin version
 */
class Pootle_Pagebuilder_Business_Pack_Admin{

	/**
	 * @var 	Pootle_Pagebuilder_Business_Pack_Admin Instance
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * Main Pootle Pagebuilder Business Pack Pro Instance
	 * Ensures only one instance of Storefront_Extension_Boilerplate is loaded or can be loaded.
	 * @return Pootle_Pagebuilder_Business_Pack_Admin instance
	 * @since 	1.0.0
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
	 * @since 	1.0.0
	 */
	private function __construct() {
		$this->token   =   Pootle_Pagebuilder_Business_Pack::$token;
		$this->url     =   Pootle_Pagebuilder_Business_Pack::$url;
		$this->path    =   Pootle_Pagebuilder_Business_Pack::$path;
		$this->version =   Pootle_Pagebuilder_Business_Pack::$version;
	} // End __construct()

	/**
	 * Adds row settings panel tab
	 * @param array $tabs The array of tabs
	 * @return array Tabs
	 * @filter pootlepb_row_settings_tabs
	 * @since 	1.0.0
	 */
	public function row_settings_tabs( $tabs ) {
		$tabs[ $this->token ] = array(
			'label' => 'Sample Tab',
			'priority' => 5,
		);
		return $tabs;
	}

	/**
	 * Adds front end stylesheet and js
	 * @param string $id
	 * @param array $args
	 * @action pootlepb_content_block_custom_field_{Pootle_Pagebuilder_Business_Pack::$token}
	 * @since 1.0.0
	 */
	public function custom_field( $id, $args = array() ) {
		?>
		<input type="hidden"
		       dialog-field='<?php echo $id ?>_data'
		       class="content-block-<?php echo $id ?>_data"
		       data-style-field-type='multi-setting'>
		<?php
		$args = wp_parse_args( $args, array(
			'fields' => 'Content:textarea',
			'callback' => 'ppbBizProCustomField',
			'button' => 'Add Section',
		) );
		$fs = explode( '|', $args['fields'] );

		$radio_attrs =
			"name='panelsStyle[$id]' class='content-block-$id'" .
			"dialog-field='$id' data-style-field-type='radio'";
		?>
		</span>
		<span style="width: 100%;max-width: 100%;">

		<input type="radio" value="" id="ppb-biz-ta-none" <?php echo $radio_attrs ?>>
		<label for="ppb-biz-ta-none">		None		</label>

		<input type="radio" value="tabs" class="ppb-biz-ta" id="ppb-biz-ta-tabs" <?php echo $radio_attrs ?>>
		<label for="ppb-biz-ta-tabs">		Tabs		</label>

		<input type="radio" value="accordion" class="ppb-biz-ta" id="ppb-biz-ta-accordion" <?php echo $radio_attrs ?>>
		<label for="ppb-biz-ta-accordion">	Accordion	</label>

		<div class="ui-section-ref" style="display:none" >
			<i class="fa fa-minus-circle" onclick="jQuery(this).parent().remove()"></i>
			<?php
			foreach( $fs as $f ) {
				$field = explode( ':', $f );
				if ( $field[1] == 'textarea' ) {
					echo "<textarea class='ppb-biz-multi-setting-field' style='width:100%' placeholder='{$field[0]}'></textarea>";
				} else {
					echo "<input class='ppb-biz-multi-setting-field' style='width:100%' placeholder='{$field[0]}' type='{$field[1]}'>";
				}
			}
			?>
		</div>
		<section class="ppb-biz-ta-section-fields">
			<button onclick='ppbBizProCustomField(this)'><?php echo $args['button'] ?></button>
		</section>
		<?php
	}

	/**
	 * Adds front end stylesheet and js
	 * @action wp_enqueue_scripts
	 * @since 1.0.0
	 */
	public function enqueue() {
		$token = $this->token;
		$url = $this->url;

		wp_enqueue_style( $token . '-admin-css', $url . '/assets/admin.css' );
		wp_enqueue_script( $token . '-admin-js', $url . '/assets/admin.js', array( 'jquery' ) );
	}

	/**
	 * Adds editor panel tab
	 * @param array $tabs The array of tabs
	 * @return array Tabs
	 * @filter pootlepb_content_block_tabs
	 * @since 	1.0.0
	 */
	public function content_block_tabs( $tabs ) {
		$tabs[ $this->token ] = array(
			'label' => 'Business Pack',
			'priority' => 5,
		);
		$tabs[ $this->token . '-ta' ] = array(
			'label' => 'Tabs/Accordion',
			'priority' => 5,
		);
		return $tabs;
	}

	/**
	 * Adds content block panel fields
	 * @param array $fields Fields to output in content block panel
	 * @return array Tabs
	 * @filter pootlepb_content_block_fields
	 * @since 	1.0.0
	 */
	public function content_block_fields( $fields ) {
		$priority = 10;

		// Google map fields
		$fields[ $this->token . '-gmap_code' ] = array(
			'name'     => 'Paste your Google Map code',
			'type'     => 'textarea',
			'tab'      => $this->token,
			'priority' => ++$priority,
		);

		// Tabs fields
		$fields[ $this->token . '-tabs_accordion' ] = array(
			'name'     => 'Accordion',
			'fields'     => 'Title:text|Content:textarea',
			'type'     => $this->token, // Custom field
			'tab'      => $this->token . '-ta',
			'priority' => ++$priority,
		);

		return $fields;
	}

	/**
	 * Adds content block panel fields
	 * @param array $modules Modules data
	 * @return array Tabs
	 * @filter pootlepb_modules
	 * @since 	1.0.0
	 */
	function modules( $modules ) {
		$modules['ppb-biz-testimonial'] = array(
			'label'       => 'Testimonial',
			'icon_class'  => 'dashicons dashicons-testimonial',
			'ActiveClass' => 'Pootle_Pagebuilder_Business_Pack',
			'callback'    => 'ppbBizTestimonial',
			'priority'    => 10,
		);
		$modules['ppb-biz-number'] = array(
			'label'       => 'Number counter',
			'icon_class'  => 'fa fa-sort-numeric-asc',
			'ActiveClass' => 'Pootle_Pagebuilder_Business_Pack',
			'callback'    => 'ppbBizNumber',
			'priority'    => 10,
		);
		$modules['ppb-biz-gmap'] = array(
			'label'       => 'Google map',
			'icon_class'  => 'fa fa-map',
			'ActiveClass' => 'Pootle_Pagebuilder_Business_Pack',
			'tab'    => '#pootle-' . $this->token . '-tab',
			'priority'    => 10,
		);
		return $modules;
	}
}
