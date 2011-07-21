<?php
class Fathom{
  var $wpdb = '';
  var $editable_options = array(

  );

  public function __construct(&$wpdb){
    $this->wpdb = $wpdb; 

  }

  public function fathom_install(){
    
  }

  public function fathom_deactivate(){
    
  }

  public function register_slide_custom_type(){
    register_post_type( 'slide',
      array(
        'labels' => array(
          'name' => __( 'Slides' ),
          'singular_name' => __( 'Slide' )
        ),
        'taxonomies' => array('slide'),
        'supports' => array(
          'title',
          'editor',
          'page-attributes',
          'custom-fields'
        ),
        'public' => true,
        'has_archive' => true,
      )
    );
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
