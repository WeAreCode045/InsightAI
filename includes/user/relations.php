<?php

// ALL USER RELATIONS

add_action('wc_membership_created', 'add_buddypress_group_member', 10, 2);

function add_buddypress_group_member($team_id, $team_member_id): void
{
	$team = get_team($team_id);
	$team_member = get_userdata($team_member_id);

	$group_id = groups_get_id(array('name' => $team->name));

	groups_accept_invite($team_member_id, $group_id);
}

// When a Team Member is removed from a Team in the Teams for WooCommerce Memberships plugin, the Team Member from the BuddyPress Group with the same name

add_action('team_member_removed', 'remove_buddypress_group_member', 10, 2);

function remove_buddypress_group_member($team_id, $team_member_id): void
{
	$team = get_team($team_id);
	$team_member = get_userdata($team_member_id);

	$group_id = groups_get_id(array('name' => $team->name));

	groups_remove_member($team_member_id, $group_id);
}

// When a Team Member is promoted to Team Owner in the Teams for WooCommerce Memberships plugin, Promote the Team Member to Group admin in the BuddyPress Group with the same name

add_action('team_member_promoted', 'promote_buddypress_group_admin', 10, 2);

function promote_buddypress_group_admin($team_id, $team_member_id): void
{
	$team = get_team($team_id);
	$team_member = get_userdata($team_member_id);

	$group_id = groups_get_id(array('name' => $team->name));

	groups_promote_member($team_member_id, $group_id, 'admin');
}

// When a Team Member is demoted from Team Owner in the Teams for WooCommerce Memberships plugin, Demote the Team Member from Group admin in the BuddyPress Group with the same name

add_action('team_member_demoted', 'demote_buddypress_group_admin', 10, 2);

function demote_buddypress_group_admin($team_id, $team_member_id): void
{
	$team = get_team($team_id);
	$team_member = get_userdata($team_member_id);

	$group_id = groups_get_id(array('name' => $team->name));

	groups_demote_member($team_member_id, $group_id, 'admin');
}
