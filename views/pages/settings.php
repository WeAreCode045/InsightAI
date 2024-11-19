

<?php

// create the form using the form class to save the OpenAI API key
$form = new Form( 'openai-settings' );
$form->addText( 'openai-api-key', 'OpenAI API Key' );
$form->addSubmit( 'submit', 'Save' );
if ( $form->isSubmitted() ) {
	// save the OpenAI API key
	update_option( 'openai-api-key', $form->getValue( 'openai-api-key' ) );
}
