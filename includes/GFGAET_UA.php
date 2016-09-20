<?php
GFForms::include_addon_framework();
class GFGAET_UA extends GFAddOn {
	protected $_version = '2.0'; 
	protected $_min_gravityforms_version = '1.8.20';
	protected $_slug = 'GFGAET_UA';
	protected $_path = 'gravity-forms-google-analytics-event-tracking/gravity-forms-event-tracking.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Gravity Forms Google Analytics Event Tracking';
	protected $_short_title = 'Event Tracking';
	
	private static $_instance = null;

	/**
	 * Returns an instance of this class, and stores it in the $_instance property.
	 *
	 * @return object $_instance An instance of this class.
	 */
	public static function get_instance() {
	    if ( self::$_instance == null ) {
	        self::$_instance = new self();
	    }
	
	    return self::$_instance;
	}
	
	public function init() {
		parent::init();
		
		// Migrate old GA Code over to new add-on
		$ga_options = get_option( 'gravityformsaddon_GFGAET_UA_settings', false );
		if ( ! $ga_options ) {
			$old_ga_option = get_option( 'gravityformsaddon_gravity-forms-event-tracking_settings', false );
			if ( $old_ga_option ) {
				update_option( 'gravityformsaddon_GFGAET_UA_settings', $old_ga_option );
			}
		}
		
	}
	
	/**
	 * Plugin settings fields
	 * 
	 * @return array Array of plugin settings
	 */
	public function plugin_settings_fields() {
		return array(
			array(
				'title'       => __( 'Google Analytics', 'gravity-forms-google-analytics-event-tracking' ),
				'fields'      => array(
					array(
						'name'              => 'gravity_forms_event_tracking_ua',
						'tooltip' 			=> __( 'Enter your UA code (UA-XXXX-Y) Find it <a href="https://support.google.com/analytics/answer/1032385" target="_blank">using this guide</a>.', 'gravity-forms-google-analytics-event-tracking' ),
						'label'             => __( 'UA Tracking ID', 'gravity-forms-google-analytics-event-tracking' ),
						'type'              => 'text',
						'class'             => 'small',
						
					),
				)
			),
			array(
				'title' => __( 'Advanced', 'gravity-forms-google-analytics-event-tracking' ),
				'description' => 'By default, events are sent server side. You can choose Client Side, but all forms must be Ajax-enabled for JS events to work.',
				'fields'      => array(
					array(
					    'type'          => 'radio',
					    'name'          => 'js_only',
					    'horizontal'    => false,
					    'default_value' => 'off',
					    'label' => 'How would you like to send events?',
					    'choices'       => array(
					        array(
					            'name'    => 'js_on',
					            'tooltip' => esc_html__( 'Forms must be Ajax only', 'sometextdomain' ),
					            'label'   => esc_html__( 'Client Side', 'gravity-forms-google-analytics-event-tracking' ),
					            'value'   => 'on'
					        ),
					        array(
					            'name'    => 'js_off',
					            'tooltip' => esc_html__( 'Events will be sent using the measurement protocol.', 'sometextdomain' ),
					            'label'   => esc_html__( 'Server Side (Default)', 'gravity-forms-google-analytics-event-tracking' ),
					            'value' => 'off'
					        ),
					    ),
					),
					array(
					    'type'          => 'radio',
					    'name'          => 'ajax_only',
					    'horizontal'    => false,
					    'default_value' => 'off',
					    'label' => 'Make all forms Ajax only?',
					    'choices'       => array(
					        array(
					            'name'    => 'ajax_on',
					            'label'   => esc_html__( 'Ajax only', 'gravity-forms-google-analytics-event-tracking' ),
					            'value'   => 'on'
					        ),
					        array(
					            'name'    => 'ajax_off',
					            'label'   => esc_html__( 'Default', 'gravity-forms-google-analytics-event-tracking' ),
					            'value' => 'off'
					        ),
					    ),
					),
					),
			)
		);
	}
}