<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.'); ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<!--<h3 id="comments">Comments</h3>-->

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
	<?php wp_list_comments( array( 'avatar_size' => 48 ) );?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		

	<?php endif; ?>
<?php endif; ?>


<?php if ( comments_open() ) : ?>

	<?php comment_form(); ?>

<?php else : // if you delete this the sky will fall on your head ?>
<p>
	Sorry, but commenting on this post is closed. I tend to close comments on 
	articles older that two weeks in order to avoid spam, however, if you still 
	wish to say something, you can always reach me at any time on Twitter:
</p>
<p>
	<a class="twitter-mention-button" href="https://twitter.com/intent/tweet?screen_name=kovshenin" data-related="kovshenin">Tweet to @kovshenin</a>
	<script type="text/javascript">// <![CDATA[
	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
	// ]]></script>
</p>
<p>
	Sorry for the inconvenience and thank you so much for your patience!
</p>
<?php endif; ?>
