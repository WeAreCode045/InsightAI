<?php

// create a form to chat with the ai assistant with the following fields:
// - select box to choose a post with the title "Select a document" and a placeholder "Select a document" and the options are the titles of the posts with the post type "document" but show only the current user's posts
// - textarea to write the message with the placeholder "Write your message here"
// - submit button with the text "Send"

function document_chat_form() {
	ob_start();
	?>
	<form action="" method="post">
		<label for="document">Select a document</label>
		<select name="document" id="document">
			<option value="">Select a document</option>
			<?php
			$current_user = wp_get_current_user();
			$args = array(
				'post_type' => 'document',
				'author' => $current_user->ID,
			);
			$documents = get_posts($args);
			foreach ($documents as $document) {
				?>
				<option value="<?php echo $document->ID; ?>"><?php echo $document->post_title; ?></option>
				<?php
			}
			?>
		</select>
		<label for="message">Write your message here</label>
		<textarea name="message" id="message" placeholder="Write your message here"></textarea>
		<input type="submit" value="Send">
	</form>
	<?php
	return ob_get_clean();
}
