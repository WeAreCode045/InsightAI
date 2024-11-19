<?php

// show the verenigingen table for the user
function user_verenigingen_table() {
	// get the current user
	$user = wp_get_current_user();
	// get the user's verenigingen
	$verenigingen = get_user_meta($user->ID, 'verenigingen', true);
	// if the user has no verenigingen, show a message
	if (empty($verenigingen)) {
		return '<p>Je hebt nog geen verenigingen toegevoegd.</p>';
	}
	// get the verenigingen table
	$table = '<table class="table">';
	$table .= '<thead>';
	$table .= '<tr>';
	$table .= '<th>Naam</th>';
	$table .= '<th>Plaats</th>';
	$table .= '<th>Website</th>';
	$table .= '</tr>';
	$table .= '</thead>';
	$table .= '<tbody>';
	foreach ($verenigingen as $vereniging) {
		$table .= '<tr>';
		$table .= '<td>' . $vereniging['naam'] . '</td>';
		$table .= '<td>' . $vereniging['plaats'] . '</td>';
		$table .= '<td>' . $vereniging['website'] . '</td>';
		$table .= '</tr>';
	}
	$table .= '</tbody>';
	$table .= '</table>';
	return $table;
}

