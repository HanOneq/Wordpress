<?php get_header(); ?>

<div id="navigationmenu">
<?php wp_nav_menu( array( 'theme_location' => 'main_menu', 'depth' => 1) );  ?>
</div>

<div id="main">

<div id="content">

<?php if (have_posts()) : while (have_posts()) : the_post();?>

<h1>
	<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
</h1>

<p class="postmetadata">
	<?php _e('Posted on', 'greyround') ?> <?php the_time('F jS, Y') ?> <?php _e(' in', 'greyround') ?> <?php the_category( ', ' ); ?>
</p>

<br/>

<div class="postThumbnail">
	<?php if ( has_post_thumbnail() ) {the_post_thumbnail();}  ?>
</div>

<div <?php post_class(); ?>>
	<?php the_content( __('Read more...' ,'greyround') ); ?>
</div>

<br/>

<hr/>

<div <?php //comment_class(); ?>>
	<?php global $withcomments; $withcomments = 1; if ( ! post_password_required() ) { comments_template( '', true); } ?>
</div>

<p>
	<?php the_tags(); ?>
</p>

<br/>

<p class="previousNext">
	<?php the_posts_navigation(); ?>
	<div id="delimeter"></div>
</p>
	<?php wp_link_pages(); ?>
<hr/>

<?php endwhile; ?> <div class="previousNext"><?php posts_nav_link();?></div> <?php else: ?>

<p>
	<?php _e('Sorry, no posts matched your criteria.', 'greyround'); ?>
</p>

<?php endif; ?>

</div>
<?php get_sidebar(); ?>
</div>
<div id="delimiter">
</div>
<?php get_footer(); ?>