<?php

define ('PEEPSO_GROUP_DIR', ABSPATH . 'wp-content/plugins/peepso-groups/');

// Hook into the action when a team is created


add_action( 'wc_memberships_for_teams_team_created', function( $team ) {

    $name = $team->get_name();
    $team_id = $team->get_id();

        // Create a new post in the vereniging CPT
        $post_id = wp_insert_post(array(
            'post_title' => $name,
			'slug' => $name,
            'post_content' => '',
            'post_type' => 'vereniging',
            'post_status' => 'publish',
        ));

        if ($post_id) {
            // Store the team ID in the post meta
            update_post_meta($post_id, '_team_id', $team_id);

            // Store the post ID in the team meta
            update_post_meta($team_id, '_vereniging_post_id', $post_id);
        }

		// Create a new Peepso group by calling the peepso_group_create function in the class file in the peepso-groups plugin
	// The group name is the team name and the owner is the team owner
	// Store the group ID in the team meta and the team ID in the group meta
	// Add the owner to the group

	require_once(PEEPSO_GROUP_DIR . 'classes/models/group.php');

	$group = new PeepSoGroup();
	$group->set_name($name);
	$group->set_owner($team->get_owner_id());
	$group->set_description('');
	$group->set_visibility('public');
	$group->set_status('active');
	$group->set_type('team');
	$group->set_parent_id(0);
	$group->set_parent_type('');
	$group->set_parent_id(0);
	$group->set_parent_type('');
	$group->set_avatar('');
	$group->set_cover('');
	$group->set_date_created(current_time('mysql'));
	$group->set_date_modified(current_time('mysql'));
	$group->set_date_last_activity(current_time('mysql'));
	$group->set_date_last_member_activity(current_time('mysql'));
	$group->set_member_count(1);
	$group->set_post_count(0);
	$group->set_comment_count(0);
	$group->set_like_count(0);
	$group->set_view_count(0);
	$group->set_order(0);
	$group->set_meta(array());
	$group->set_meta('team_id', $team_id);

	$group_id = $group->save();

	update_post_meta($team_id, '_peepso_group_id', $group_id);
	update_post_meta($group_id, '_team_id', $team_id);

	peepso_group_add_member($group_id, $team->get_owner_id());

	// Add the team members to the group
	$team_members = $team->get_members();









});

// Hook into the action when a team is deleted

add_action( 'wc_memberships_for_teams_team_deleted', function( $team ) {

    $team_id = $team->get_id();

    // Get the post ID from the team meta
    $post_id = get_post_meta($team_id, '_vereniging_post_id', true);

    // Delete the post
    wp_delete_post($post_id, true);

	// Delete the Peepso group
	$group_id = get_post_meta($team_id, '_peepso_group_id', true);
	peepso_group_delete($group_id);

	// Delete the team meta
	delete_post_meta($team_id, '_vereniging_post_id');
	delete_post_meta($team_id, '_peepso_group_id');

	// Delete the group meta
	delete_post_meta($group_id, '_team_id');

	//Delete the post meta
	delete_post_meta($post_id, '_team_id');

	//Delete user accounts but not the owner account
	$team_members = $team->get_members();
	foreach ($team_members as $member) {
		if ($member->get_id() != $team->get_owner_id()) {
			wp_delete_user($member->get_id());
		}
	}

	//Delete the team
	wp_delete_post($team_id, true);


});

// Hook into the action when a team is updated

add_action( 'wc_memberships_for_teams_team_updated', function( $team ) {

    $name = $team->get_name();
    $team_id = $team->get_id();

    // Get the post ID from the team meta
    $post_id = get_post_meta($team_id, '_vereniging_post_id', true);

    // Update the post title
    wp_update_post(array(
        'ID' => $post_id,
        'post_title' => $name,
    ));

	// Update the Peepso group name
	$group_id = get_post_meta($team_id, '_peepso_group_id', true);
	peepso_group_update($group_id, $name);


});

// Hook into the action when a team is added to a user

add_action( 'wc_memberships_for_teams_team_added_to_user', function( $team, $user_id ) {

    $team_id = $team->get_id();

    // Get the post ID from the team meta
    $post_id = get_post_meta($team_id, '_vereniging_post_id', true);

    // Add the user to the post
    wp_set_post_terms($post_id, $user_id, 'vereniging_user');

}, 10, 2 );

// Hook into the action when a team is removed from a user

add_action( 'wc_memberships_for_teams_team_removed_from_user', function( $team, $user_id ) {

    $team_id = $team->get_id();

    // Get the post ID from the team meta
    $post_id = get_post_meta($team_id, '_vereniging_post_id', true);

    // Remove the user from the post
    wp_remove_object_terms($post_id, $user_id, 'vereniging_user');

}, 10, 2 );



