<?php

// some variables you're supposed to use according to: http://codex.wordpress.org/Function_Reference/comment_form

$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );

$comments_args = array(
        // change the title of send button
        'label_submit'=> __('Send', 'greyround'),
        // change the title of the reply section
        'title_reply'=> __('Got something to say?', 'greyround'),
		// remove the 'your email address will not be published etc'
		'comment_notes_before' => '',
        // remove "Text or HTML to be displayed after the set of comment fields"
        'comment_notes_after' => '',
        // redefine your own textarea (the comment body)
        'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Your thoughts', 'noun', 'greyround' ) . '</label><br /><textarea id="comment" name="comment" aria-required="true"></textarea></p>',

		'fields' => apply_filters( 'comment_form_default_fields', array(

		'author' =>
		'<p class="comment-form-author">' .
		'<label for="author">' . __( 'Your name', 'greyround' ) . '</label> ' .
		( $req ? '<span class="required">(required)</span>' : '' ) .
		'<br /><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		'" size="30"' . $aria_req . ' /></p>',

		'email' =>
		'<p class="comment-form-email"><label for="email">' . __( 'Your email address', 'greyround' ) . '</label> ' .
		( $req ? '<span class="required">(required)</span>' : '' ) .
		'<br /><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		'" size="30"' . $aria_req . ' /></p>',

		'url' =>
		'<p class="comment-form-url"><label for="url">' .
		__( 'Your website/blog if you have one', 'greyround' ) . '</label>' .
		'<br /><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
		'" size="30" /></p>'
		)
	),
		
);

$args = array (
	'style' => 'div', // I found that doing this removes the bullets from comments
);
comment_form($comments_args);

?>

 <div class="navigation">
  <?php paginate_comments_links(); ?> 
 </div>
 
 <ol class="commentlist">
  <?php wp_list_comments($args); ?>
 </ol>
 
 <div class="navigation">
  <?php paginate_comments_links(); ?> 
 </div>