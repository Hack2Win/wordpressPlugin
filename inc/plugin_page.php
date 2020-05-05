<?php
class CyrLatConverter {
	private $cyrlatconverter_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'cyrlatconverter_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'cyrlatconverter_page_init' ) );
	}

	public function cyrlatconverter_add_plugin_page() {
		add_menu_page(
			'CyrLatConverter', // page_title
			'CyrLatConverter', // menu_title
			'manage_options', // capability
			'cyrlatconverter', // menu_slug
			array( $this, 'cyrlatconverter_create_admin_page' ), // function
			'dashicons-admin-generic', // icon_url
			3 // position
		);
	}

	public function cyrlatconverter_create_admin_page() {
		$this->cyrlatconverter_options = get_option( 'cyrlatconverter_option_name' ); ?>

        <div class="wrap">
            <h2>CyrLatConverter</h2>
            <p>CyrLatConverter Admin Page</p>
			<?php settings_errors(); ?>

            <form method="post" action="options.php">
				<?php
				settings_fields( 'cyrlatconverter_option_group' );
				do_settings_sections( 'cyrlatconverter-admin' );
				submit_button();
				?>
            </form>
        </div>
	<?php }

	public function cyrlatconverter_page_init() {
		register_setting(
			'cyrlatconverter_option_group', // option_group
			'cyrlatconverter_option_name', // option_name
			array( $this, 'cyrlatconverter_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'cyrlatconverter_setting_section', // id
			'Settings', // title
			array( $this, 'cyrlatconverter_section_info' ), // callback
			'cyrlatconverter-admin' // page
		);

		add_settings_field(
			'button_selector_for_cyr', // id
			'Button Selector for Cyr', // title
			array( $this, 'button_selector_for_cyr_callback' ), // callback
			'cyrlatconverter-admin', // page
			'cyrlatconverter_setting_section' // section
		);

		add_settings_field(
			'button_selector_for_lat', // id
			'Button Selector for Lat', // title
			array( $this, 'button_selector_for_lat_callback' ), // callback
			'cyrlatconverter-admin', // page
			'cyrlatconverter_setting_section' // section
		);

		add_settings_field(
			'button_selector_for_default', // id
			'Button Selector for Default', // title
			array( $this, 'button_selector_for_default_callback' ), // callback
			'cyrlatconverter-admin', // page
			'cyrlatconverter_setting_section' // section
		);

		add_settings_field(
			'permalink_hash', // id
			'Permalink Hash', // title
			array( $this, 'permalink_hash_callback' ), // callback
			'cyrlatconverter-admin', // page
			'cyrlatconverter_setting_section' // section
		);

//		add_settings_field(
//			'ignore_classes', // id
//			'Ignore Classes', // title
//			array( $this, 'ignore_classes_callback' ), // callback
//			'cyrlatconverter-admin', // page
//			'cyrlatconverter_setting_section' // section
//		);
		add_settings_field(
			'enable_header', // id
			'Enable Header', // title
			array( $this, 'enable_header_callback' ), // callback
			'cyrlatconverter-admin', // page
			'cyrlatconverter_setting_section' // section
		);

	}

	public function cyrlatconverter_sanitize( $input ) {
		$sanitary_values = array();
		if ( isset( $input['button_selector_for_cyr'] ) ) {
			$sanitary_values['button_selector_for_cyr'] = sanitize_text_field( $input['button_selector_for_cyr'] );
		}

		if ( isset( $input['button_selector_for_lat'] ) ) {
			$sanitary_values['button_selector_for_lat'] = sanitize_text_field( $input['button_selector_for_lat'] );
		}

		if ( isset( $input['button_selector_for_default'] ) ) {
			$sanitary_values['button_selector_for_default'] = sanitize_text_field( $input['button_selector_for_default'] );
		}

		if ( isset( $input['permalink_hash'] ) ) {
			$sanitary_values['permalink_hash'] = $input['permalink_hash'];
		}

		if ( isset( $input['ignore_classes'] ) ) {
			$sanitary_values['ignore_classes'] = esc_textarea( $input['ignore_classes'] );
		}
		if ( isset( $input['enable_header'] ) ) {
			$sanitary_values['enable_header'] = esc_textarea( $input['enable_header'] );
		}

		return $sanitary_values;
	}

	public function cyrlatconverter_section_info() {
	}
	public function button_selector_for_cyr_callback() {
		printf(
			'<input class="regular-text" type="text" name="cyrlatconverter_option_name[button_selector_for_cyr]" id="button_selector_for_cyr" value="%s">',
			isset( $this->cyrlatconverter_options['button_selector_for_cyr'] ) ? esc_attr( $this->cyrlatconverter_options['button_selector_for_cyr'] ) : ''
		);
	}

	public function button_selector_for_lat_callback() {
		printf(
			'<input class="regular-text" type="text" name="cyrlatconverter_option_name[button_selector_for_lat]" id="button_selector_for_lat" value="%s">',
			isset( $this->cyrlatconverter_options['button_selector_for_lat'] ) ? esc_attr( $this->cyrlatconverter_options['button_selector_for_lat'] ) : ''
		);
	}
	public function button_selector_for_default_callback() {
		printf(
			'<input class="regular-text" type="text" name="cyrlatconverter_option_name[button_selector_for_default]" id="button_selector_for_default" value="%s">',
			isset( $this->cyrlatconverter_options['button_selector_for_default'] ) ? esc_attr( $this->cyrlatconverter_options['button_selector_for_default'] ) : ''
		);
	}

	public function permalink_hash_callback() {
		printf(
			'<input type="checkbox" name="cyrlatconverter_option_name[permalink_hash]" id="permalink_hash" value="permalink_hash" %s> <label for="permalink_hash">Moguće vrednosti su true i false. Omogućava izbor da li će se transliteracija pozivati postavljanjem hash taga, ili ne. Podrazumevana vrednost je false.</label>',
			( isset( $this->cyrlatconverter_options['permalink_hash'] ) && $this->cyrlatconverter_options['permalink_hash'] === 'permalink_hash' ) ? 'checked' : ''
		);
	}

	public function ignore_classes_callback() {
		printf(
			'<textarea class="large-text" rows="5" name="cyrlatconverter_option_name[ignore_classes]" id="ignore_classes">%s</textarea>',
			isset( $this->cyrlatconverter_options['ignore_classes'] ) ? esc_attr( $this->cyrlatconverter_options['ignore_classes'] ) : ''
		);
	}
	public function enable_header_callback() {
		printf(
			'<input type="checkbox" name="cyrlatconverter_option_name[enable_header]" id="enable_header" value="enable_header" %s> <label for="enable_header">Omogućava izbor da li će se prikazivati traka za converziju strane, ili ne</label>',
			( isset( $this->cyrlatconverter_options['enable_header'] ) && $this->cyrlatconverter_options['enable_header'] === 'enable_header' ) ? 'checked' : ''
		);
	}

}

if ( is_admin() ) {
	$cyrlatconverter = new CyrLatConverter();
}

/*
  $cyrlatconverter_options = get_option( 'cyrlatconverter_option_name' );
  $button_selector_for_cyr = $cyrlatconverter_options['button_selector_for_cyr'];
  $button_selector_for_lat = $cyrlatconverter_options['button_selector_for_lat'];
  $button_selector_for_default = $cyrlatconverter_options['button_selector_for_default'];
  $permalink_hash = $cyrlatconverter_options['permalink_hash'];
  $ignore_classes = $cyrlatconverter_options['ignore_classes'];
  $benchmark_5 = $cyrlatconverter_options['benchmark_5'];
 */
