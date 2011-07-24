<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title(); ?> <?php bloginfo( 'name' ); ?></title>
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
<style type="text/css">
  #presentation div.slide{
    width: <?php echo htmlspecialchars(get_option('fathom_width')); ?>px;
    height: <?php echo htmlspecialchars(get_option('fathom_height')); ?>px;
  }

<?php if(false){ ?>  
  #presentation div.slide,li,p,td,th,div{
    font-size: <?php echo htmlspecialchars(get_option('fathom_body_font_size')); ?>px;
  }
<?php } ?>

</style>
</head>
<body <?php body_class() ?>>
<div id="presentation" class="<?php echo htmlspecialchars(((get_option('fathom_vertical_center') == 1) ? 'vertical_center' : '')); ?>">
<?php global $wp; ?>
	<?php $args = array( 'post_type' => 'slide', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => 0, 'slideshows' => $wp->query_vars['slideshows']); ?>
	<?php query_posts($args); ?>

  <?php while ( have_posts() ) : the_post(); ?>
	  <div class="slide">
  		<h1><?php echo htmlspecialchars(get_the_title()); ?></h1>
      <div class="slidecontent">
    		<?php the_content(); ?>
      </div>
  	</div>
	<?php endwhile; // end of the loop. ?>
</div>
</body>
<?php wp_footer(); ?>
</html>
