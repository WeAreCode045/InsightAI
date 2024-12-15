<?php

require_once  WP_PLUGIN_DIR . '/ai-services/ai-services.php';

$current_user = wp_get_current_user();

use Felix_Arntz\AI_Services\Services\API\Enums\AI_Capability;
use Felix_Arntz\AI_Services\Services\API\Helpers;

// add a form to send the message
echo '<form method="post" action="">';
echo '<input type="text" name="message" placeholder="Type your message here" />';
echo '<input type="submit" value="Send" />';
echo '</form>';


if ( ai_services()->has_available_services() ) {
	$service = ai_services()->get_available_service();
	try {
		$candidates = $service
			->get_model(
				array(
					'feature'      => 'my-test-feature',
					'capabilities' => array( AI_Capability::TEXT_GENERATION ),
				)
			)
            // get the text from the form
			->generate_text(' ' . $_POST['message'] . ' ');
		$text = Helpers::get_text_from_contents(
			Helpers::get_candidate_contents( $candidates )
		);

		echo $text;
	} catch ( Exception $e ) {
		// Handle the exception.
	}
}