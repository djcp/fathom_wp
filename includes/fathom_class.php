<?php
class Fathom{
  var $wpdb = '';
  var $height = 650;
  var $width = 900;
  var $vertical_center = '';
  var $body_font_size = 32; 

  var $editable_options = array(
    'width',
    'height',
    'body_font_size',
    'vertical_center'
  );

  public function __construct(&$wpdb){
    $this->wpdb = $wpdb; 
    wp_register_style('admin.css',plugins_url('/stylesheets/admin.css',dirname(__FILE__)));
    wp_register_style('fathom_wp.css',plugins_url('/stylesheets/fathom_wp.css',dirname(__FILE__)));
    wp_register_script('fathom.min.js',plugins_url('/javascripts/fathom.min.js',dirname(__FILE__)));
    wp_register_script('fathom_wp.js',plugins_url('/javascripts/fathom_wp.js',dirname(__FILE__)));
    foreach($this->editable_options as $opt){
      if(get_option('fathom_' . $opt)){
        $this->{$opt} = get_option('fathom_' . $opt);
      }
    }
  }

  public function fathom_install(){

  }

  public function fathom_deactivate(){

  }

  public function register_slide_custom_type(){
    register_taxonomy(
      'slideshows',
      'slide',
      array(
        'label' => __( 'Slideshows' ),
        'sort' => true,
        'args' => array( 'orderby' => 'term_order' ),
        'rewrite' => array( 'slug' => 'slideshow' )
      )
    );
    register_post_type( 'slide',
      array(
        'labels' => array(
          'name' => __( 'Slides' ),
          'singular_name' => __( 'Slide' )
        ),
        'taxonomies' => array('slideshows'),
        'supports' => array(
          'title',
          'editor',
          'page-attributes',
          'custom-fields'
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'slide' )
      )
    );
  }

  private function init_slide_resources(){
    wp_enqueue_style('fathom_wp.css');
    if (file_exists(TEMPLATEPATH . '/fathom_custom.css')) {
      wp_register_style('fathom_custom.css',get_template_directory_uri() . '/fathom_custom.css');
      wp_enqueue_style('fathom_custom.css');
    }
    wp_enqueue_script('jquery');
    wp_enqueue_script('fathom.min.js');
    wp_enqueue_script('fathom_wp.js');
  }	

  public function custom_slide_page_template(){
    global $wp;
    $plugindir = dirname( __FILE__ );
    if ( $wp->query_vars['post_type'] == 'slide') {
      // Rendering a slide
      $templatefilename = 'slide-page.php';
      if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
        $return_template = TEMPLATEPATH . '/' . $templatefilename;
      } else {
        $return_template = $plugindir . '/templates/' . $templatefilename;
      }
      $this->return_custom_template($return_template);
    } elseif( isset($wp->query_vars['slideshows'])){
      // Rendering a slide
      $templatefilename = 'slideshow-page.php';
      if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
        $return_template = TEMPLATEPATH . '/' . $templatefilename;
      } else {
        $return_template = $plugindir . '/templates/' . $templatefilename;
      }
      $this->return_custom_template($return_template);
    }
  }

  public function return_custom_template($return_template){
    global $post, $wp_query;
    if (have_posts()) {
      $this->init_slide_resources();
      include($return_template);
      die();
    } else {
      $wp_query->is_404 = true;
    }
  }

  public function admin_menu(){
    wp_enqueue_style('admin.css');
    wp_enqueue_script('jquery.cookie.js');
    wp_enqueue_script('admin.js');
    add_submenu_page('options-general.php', __('Fathom Config'), __('Fathom'), 'manage_options', 'fathom-config', array($this,'config'));
  }

  public function config(){
    $updated = false;
    if ( isset($_POST['submit']) ) {
      if ( function_exists('current_user_can') && !current_user_can('manage_options') ){
        die(__('how about no?'));
      };
      // Save options

      $updated = true;
      foreach($this->editable_options as $opt){
        $this->{$opt} = stripslashes($_POST['fathom_' . $opt]);
        update_option('fathom_'. $opt, $this->{$opt});
      }
    }
    // emit form
    if($updated){ 
      echo "<div id='message' class='updated'><p><strong>" . __('Saved options.') ."</strong></p></div>";
    }
?>

<div class="wrap">
  <form action="" method="post">
  <h2><?php _e('Configure Fathom'); ?></h2>
  <table class="form-table">
    <tr>
    <th><label for="fathom_height"><?php _e('Slideshow Height');  ?></label></th>
      <td>
      <input type="text" name="fathom_height" value="<?php echo esc_attr($this->height); ?>" size="10" />px<br />
        <span class="description"><?php _e('Height of a Fathom slideshow, in pixels. Defaults to 650px.') ?></span>
      </td>
    </tr>
    <tr>
    <th><label for="fathom_width"><?php _e('Slideshow Width');  ?></label></th>
      <td>
      <input type="text" name="fathom_width" value="<?php echo esc_attr($this->width); ?>" size="10" />px<br />
        <span class="description"><?php _e('Width of a Fathom slideshow, in pixels. Defaults to 900px.') ?></span>
      </td>
    </tr>
    <tr>
    <th><label for="fathom_vertical_center"><?php _e('Center content vertically?');  ?></label></th>
      <td>
      <input type="checkbox" name="fathom_vertical_center" value="1" <?php echo (($this->vertical_center == 1) ? 'checked="checked"' : ''); ?> /><br />
        <span class="description"><?php _e('If checked, we\'ll center the slide content as best we can vertically in the center of the slide body.') ?></span>
      </td>
    </tr>


    <tr>
    <th><label for="fathom_body_font_size"><?php _e('Slide content font size');  ?></label></th>
      <td>
      <input type="text" name="fathom_body_font_size" value="<?php echo esc_attr($this->body_font_size); ?>" size="10" />px<br />
        <span class="description"><?php _e('The slide content font size, in pixels. 32px by default.') ?></span>
      </td>
    </tr>


  </table>
  <p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Update Options'); ?>"  /></p> 
  </form>
</div>

<?php 

  }

} // Fathom class end
