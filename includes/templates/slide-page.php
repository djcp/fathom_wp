<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title(); ?> <?php bloginfo( 'name' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>
<body <?php body_class() ?>>
<div id="presentation">
  <?php while ( have_posts() ) : the_post(); ?>
	  <div class="slide">
  		<h1><?php the_title() ?></h1>
  		<?php the_content(); ?>
  	</div>
	<?php endwhile; // end of the loop. ?>
</div>
</body>
<?php wp_footer(); ?>
</html>
