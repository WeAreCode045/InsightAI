<?php

// When a Team is created in the Teams for WooCommerce Memberships plugin, Create a Group in BuddyPress with the same name and add the team owner as the Group admin

add_action('wc_memberships_for_teams_team_created', 'create_buddypress_group_from_team', 10, 2);

function create_buddypress_group_from_team($team_id, $team_owner_id): void
{
	$team = get_team($team_id);
	$team_owner = get_userdata($team_owner_id);

	$group_id = groups_create_group([
		'creator_id' => $team_owner_id,
		'name' => $team->name,
		'description' => $team->description,
		'status' => 'public',
	]);

	groups_update_groupmeta($group_id, 'team_id', $team_id);
	groups_update_groupmeta($group_id, 'team_owner_id', $team_owner_id);
}

// When a Team is deleted in the Teams for WooCommerce Memberships plugin, Delete the BuddyPress Group with the same name

add_action('wc_memberships_for_teams_team_deleted', 'delete_buddypress_group_from_team', 10, 2);

function delete_buddypress_group_from_team($team_id, $team_owner_id): void
{
	$team = get_team($team_id);
	$team_owner = get_userdata($team_owner_id);

	$group_id = groups_get_id(array('name' => $team->name));

	groups_delete_group($group_id);
}

// When a Team is updated in the Teams for WooCommerce Memberships plugin, Update the BuddyPress Group with the same name

add_action('wc_memberships_for_teams_team_updated', 'update_buddypress_group_from_team', 10, 2);

function update_buddypress_group_from_team($team_id, $team_owner_id): void
{
	$team = get_team($team_id);
	$team_owner = get_userdata($team_owner_id);

	$group_id = groups_get_id(array('name' => $team->name));

	groups_update_groupmeta($group_id, 'team_id', $team_id);
	groups_update_groupmeta($group_id, 'team_owner_id', $team_owner_id);
}

