<?php

/*
Plugin Name: torvicvSlide_plugin
Description: Plugin for sliding pictures
Author: Victor Cabral Vida
Version: 0.1
Text Domain: torvicvSlide-plugin-widget-master
Domain Path: /languages
*/

add_action('wp_print_scripts', 'np_register_scripts');
add_action('wp_print_styles', 'np_register_styles');
add_action( 'admin_enqueue_scripts', 'np_admin_register_script' );


function np_register_scripts(){
    wp_enqueue_script("torvicSlidePluginJs", plugins_url().'/torvicvSlide-plugin-widget-master/torvicvSlide_plugin.js', array('jquery'), time(),true);
    wp_enqueue_script("torvicSlideWidgetJs", plugins_url().'/torvicvSlide-plugin-widget-master/torvicvSlide_widget.js', array('jquery'), time(),true);    
}
function np_register_styles(){
    wp_enqueue_style("torvicSlideCss", plugins_url('torvicvSlide-plugin-widget-master/torvicvSlide.css'),array(), time());
    wp_enqueue_style("w3schoolsCss", plugins_url('torvicvSlide-plugin-widget-master/w3schools.css'),array(), time());
}
function np_admin_register_script(){
    wp_enqueue_script("mediaPlugin", plugins_url().'/torvicvSlide-plugin-widget-master/scriptMediaWidget.js', array('jquery'), time(), true);
}
//cambiando el nombre de la clase MySettingsPage por TorvicvSlidePlugin
class TorvicvSlidePlugin
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_shortcode( 'torvicvSlide', array( $this, 'show_slide' ) );
        //add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action('admin_menu', array ($this,'torvicvSlide_plugin_setup_menu'));
        add_action( 'admin_init', array( $this, 'page_init' ) );
        add_action('init', array( $this,'wan_load_textdomain'));

    }
    public function wan_load_textdomain() {
	load_plugin_textdomain( 'torvicvSlide-plugin-widget-master', false,basename( dirname( __FILE__ ) ) .'/languages' );

    }
    /**
     * Add options page
     */
    public function torvicvSlide_plugin_setup_menu(){
        add_menu_page( 'TorvicvSlide Plugin Page', 'TorvicvSlide settings', 'manage_options', 'torvicvSlide-plugin', array( $this, 'create_admin_page') );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        $other_attributes = array('disabled'=> true);
        ?>
        <div class="wrap">
            <h1>TorvicvSlide settings</h1>
            <form method="post" action="<?php echo htmlspecialchars('options.php'); ?>">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'torvicvSlide-plugin' );
                submit_button();                
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            __('Configuracion personalizada','torvicvSlide-plugin-widget-master'), // Title
            array( $this, 'print_section_info' ), // Callback
            'torvicvSlide-plugin' // Page
        );  

        add_settings_field(
            'ruta1', // ID
            __('Ruta 1:', 'torvicvSlide-plugin-widget-master'), // Title 
            array( $this, 'ruta1_callback' ), // Callback
            'torvicvSlide-plugin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'ruta2', 
            __('Ruta 2:', 'torvicvSlide-plugin-widget-master'), 
            array( $this, 'ruta2_callback' ), 
            'torvicvSlide-plugin', 
            'setting_section_id'
        );
        
        add_settings_field(
            'ruta3', // ID
            __('Ruta 3:', 'torvicvSlide-plugin-widget-master'), // Title 
            array( $this, 'ruta3_callback' ), // Callback
            'torvicvSlide-plugin', // Page
            'setting_section_id' // Section           
        );
        
        add_settings_field(
            'ruta4', // ID
            __('Ruta 4:', 'torvicvSlide-plugin-widget-master'), // Title 
            array( $this, 'ruta4_callback' ), // Callback
            'torvicvSlide-plugin', // Page
            'setting_section_id' // Section           
        );
        
        add_settings_field(
            'ruta5', // ID
            __('Ruta 5:', 'torvicvSlide-plugin-widget-master'), // Title 
            array( $this, 'ruta5_callback' ), // Callback
            'torvicvSlide-plugin', // Page
            'setting_section_id' // Section           
        );
        
        add_settings_field(
            'ruta6', // ID
            __('Ruta 6:', 'torvicvSlide-plugin-widget-master'), // Title 
            array( $this, 'ruta6_callback' ), // Callback
            'torvicvSlide-plugin', // Page
            'setting_section_id' // Section           
        );
        
        add_settings_field(
            'required1',
            NULL,
            NULL, 
            'torvicvSlide-plugin',
            'setting_section_id'
        );
        
        add_settings_field(
            'required2',
            NULL,
            NULL, 
            'torvicvSlide-plugin',
            'setting_section_id'
        );
        
        add_settings_field(
            'required3',
            NULL,
            NULL, 
            'torvicvSlide-plugin',
            'setting_section_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input ){
        $new_input = array();
        if( !empty( $input['ruta1'] ) ){
            $new_input['ruta1'] = sanitize_text_field( $input['ruta1'] );
        }else{
            $new_input['required1'] = __('Seleccione una imagen', 'torvicvSlide-plugin-widget-master');
        }
        if( !empty( $input['ruta2'] ) ){
            $new_input['ruta2'] = sanitize_text_field( $input['ruta2'] );
        }else{
            $new_input['required2'] = __('Seleccione una imagen', 'torvicvSlide-plugin-widget-master');
        }
        if( !empty( $input['ruta3'] ) ){
            $new_input['ruta3'] = sanitize_text_field( $input['ruta3'] );
        }else{
            $new_input['required3'] = __('Seleccione una imagen', 'torvicvSlide-plugin-widget-master');
        }
        if( isset( $input['ruta4'] ) ){
            $new_input['ruta4'] = sanitize_text_field( $input['ruta4'] );
        }
        if( isset( $input['ruta5'] ) ){
            $new_input['ruta5'] = sanitize_text_field( $input['ruta5'] );
        }
        if( isset( $input['ruta6'] ) ){
            $new_input['ruta6'] = sanitize_text_field( $input['ruta6'] );
        }
            return $new_input;       
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print __('Introduzca sus configuraciones abajo:', 'torvicvSlide-plugin-widget-master');
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function ruta1_callback()
    {
        printf(
            '<input type="url" id="ruta1" class="upload_image_input" name="my_option_name[ruta1]" value="%s" />'
                . '<button class="upload_image_button">'.__('Seleccionar imagen', 'torvicvSlide-plugin-widget-master').'</button>'
                . '<span> %s</span>',
            !empty( $this->options['ruta1'] ) ? esc_attr( $this->options['ruta1']) : 'Required', $this->options['required1']);
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function ruta2_callback()
    {
        printf(
            '<input type="url" id="ruta2" class="upload_image_input" name="my_option_name[ruta2]" value="%s" />'
                . '<button class="upload_image_button">'.__('Seleccionar imagen', 'torvicvSlide-plugin-widget-master').'</button>'
                . '<span> %s</span>',
            !empty( $this->options['ruta2'] ) ? esc_attr( $this->options['ruta2']) : 'Required', $this->options['required2']
        );
    }
    
    public function ruta3_callback()
    {
        printf(
            '<input type="url" id="ruta3" class="upload_image_input" name="my_option_name[ruta3]" value="%s" />'
                . '<button class="upload_image_button">'.__('Seleccionar imagen', 'torvicvSlide-plugin-widget-master').'</button>'
                . '<span> %s</span>',
            !empty( $this->options['ruta3'] ) ? esc_attr( $this->options['ruta3']) : 'Required', $this->options['required3']
        );
    }
    
    public function ruta4_callback()
    {
        printf(
            '<input type="url" id="ruta4" class="upload_image_input" name="my_option_name[ruta4]" value="%s" />'
                . '<button class="upload_image_button">'.__('Seleccionar imagen', 'torvicvSlide-plugin-widget-master').'</button>',
            isset( $this->options['ruta4'] ) ? esc_attr( $this->options['ruta4']) : ''
        );
    }
    
    public function ruta5_callback()
    {
        printf(
            '<input type="url" id="ruta5" class="upload_image_input" name="my_option_name[ruta5]" value="%s" />'
                . '<button class="upload_image_button">'.__('Seleccionar imagen', 'torvicvSlide-plugin-widget-master').'</button>',
            isset( $this->options['ruta5'] ) ? esc_attr( $this->options['ruta5']) : ''
        );
    }
    
    public function ruta6_callback()
    {
        printf(
            '<input type="url" id="ruta6" class="upload_image_input" name="my_option_name[ruta6]" value="%s" />'
                . '<button class="upload_image_button">'.__('Seleccionar imagen', 'torvicvSlide-plugin-widget-master').'</button>',
            isset( $this->options['ruta6'] ) ? esc_attr( $this->options['ruta6']) : ''
        );
    }
    public function show_slide(){
        $myField1 = get_option( 'my_option_name' )['ruta1'];
        $myField2 = get_option( 'my_option_name' )['ruta2'];
        $myField3 = get_option( 'my_option_name' )['ruta3'];
        $myField4 = get_option( 'my_option_name' )['ruta4'];
        $myField5 = get_option( 'my_option_name' )['ruta5'];
        $myField6 = get_option( 'my_option_name' )['ruta6'];
        
        $ruta1 = esc_attr( $myField1 );
        $ruta2 = esc_attr( $myField2 );
        $ruta3 = esc_attr( $myField3 );
        $ruta4 = esc_attr( $myField4 );
        $ruta5 = esc_attr( $myField5 );
        $ruta6 = esc_attr( $myField6 );
        
        $formato = '<div class="w3-content-plugin w3-display-container">
                <img class="mySlides_plugin" style="order: 0;" src=" %s " />
                <img class="mySlides_plugin class2" style="order: 1;" src=" %s " />
                <img class="mySlides_plugin" style="order: 2;" src=" %s " />';
    if(!empty($ruta4)){
        $formato .= '<img class="mySlides_plugin" style="order: 3;" src=" %s " />';
    }
    if(!empty($ruta5)){
        $formato .= '<img class="mySlides_plugin" style="order: 4;" src=" %s " />';
    }
    if(!empty($ruta6)){
        $formato .= '<img class="mySlides_plugin" style="order: 5;" src=" %s " />';
    }
        $formato .= '<button class="w3-button w3-black w3-display-left">&#10094;</button>
                <button class="w3-button w3-black w3-display-right">&#10095;</button>
                </div>';
        

        $mostrar = sprintf($formato, $ruta1, $ruta2, $ruta3, $ruta4, $ruta5, $ruta6);
        return $mostrar;
        
    }
}

if( is_admin() ){
    $my_settings_page = new TorvicvSlidePlugin();
}else{
    $my_settings_page = new TorvicvSlidePlugin();
}

