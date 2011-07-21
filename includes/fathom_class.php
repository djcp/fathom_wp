<?php
class Fathom{
  var $wpdb = '';
  var $editable_options = array(

  );

  public function __construct(&$wpdb){
    $this->wpdb = $wpdb; 
		wp_register_style('admin.css',plugins_url('/stylesheets/admin.css',dirname(__FILE__)));
		wp_register_style('fathom_wp.css',plugins_url('/stylesheets/fathom_wp.css',dirname(__FILE__)));
		wp_register_script('fathom.min.js',plugins_url('/javascripts/fathom.min.js',dirname(__FILE__)));
		wp_register_script('fathom_wp.js',plugins_url('/javascripts/fathom_wp.js',dirname(__FILE__)));

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
			wp_enqueue_script('jquery');
			wp_enqueue_script('fathom.min.js');
			wp_enqueue_script('fathom_wp.js');
	}	

	public function custom_slide_page_template(){
		global $wp;
		$plugindir = dirname( __FILE__ );
		if ( $wp->query_vars['post_type'] == 'slide') {
			$this->init_slide_resources();
			// Rendering a slide
			$templatefilename = 'slide-page.php';
			if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
				$return_template = TEMPLATEPATH . '/' . $templatefilename;
			} else {
				$return_template = $plugindir . '/templates/' . $templatefilename;
			}
			$this->return_custom_template($return_template);
		} elseif( isset($wp->query_vars['slideshows'])){
			$this->init_slide_resources();
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
				$this->{$opt} = stripslashes($_POST['cat_sub_' . $opt]);
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
    <th><label for="cat_sub_max_batch"><?php _e('Maximum outgoing email batch size');  ?></label></th>
      <td>
      <input type="text" name="cat_sub_max_batch" value="<?php echo esc_attr($this->max_batch); ?>" size="10" /><br />
        <span class="description"><?php _e('How many emails should we send per cron run?') ?></span>
      </td>
    </tr>
  </table>
  <p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Update Options'); ?>"  /></p> 
  </form>

</div>

<?php 

  }

} // Fathom class end
