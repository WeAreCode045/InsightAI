<?php

// Dashboard functions

// show a section in the dashboard with the user's name

function insightai_dashboard(): void
{
	$user = wp_get_current_user();
	?>
	<div class="wrap">
		<h1>InsightAI Dashboard</h1>
		<p>Welcome, <?php echo $user->display_name; ?>!</p>
	</div>
	<?php
}

// show a function with a table of the latest 10 users

function insightai_dashboard_users(): void
{
	$users = get_users([
		'number' => 10,
		'orderby' => 'registered',
		'order' => 'DESC',
	]);
	?>
	<div class="wrap">
		<h1>InsightAI Dashboard</h1>
		<h2>Latest Users</h2>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Registered</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user) : ?>
					<tr>
						<td><?php echo $user->display_name; ?></td>
						<td><?php echo $user->user_email; ?></td>
						<td><?php echo $user->user_registered; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

// show a function with a table of the latest 10 posts

function insightai_dashboard_posts(): void
{
	$posts = get_posts([
		'numberposts' => 10,
		'orderby' => 'post_date',
		'order' => 'DESC',
	]);
	?>
	<div class="wrap">
		<h1>InsightAI Dashboard</h1>
		<h2>Latest Posts</h2>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Author</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($posts as $post) : ?>
					<tr>
						<td><?php echo $post->post_title; ?></td>
						<td><?php echo get_the_author_meta('display_name', $post->post_author); ?></td>
						<td><?php echo $post->post_date; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

// show a function with a table of the latest 10 comments

function insightai_dashboard_comments(): void
{
	$comments = get_comments([
		'number' => 10,
		'orderby' => 'comment_date',
		'order' => 'DESC',
	]);
	?>
	<div class="wrap">
		<h1>InsightAI Dashboard</h1>
		<h2>Latest Comments</h2>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th>Comment</th>
					<th>Author</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($comments as $comment) : ?>
					<tr>
						<td><?php echo $comment->comment_content; ?></td>
						<td><?php echo $comment->comment_author; ?></td>
						<td><?php echo $comment->comment_date; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

// show a function with a table of the latest 10 orders

function insightai_dashboard_orders(): void
{
	$orders = wc_get_orders([
		'limit' => 10,
		'orderby' => 'date',
		'order' => 'DESC',
	]);
	?>
	<div class="wrap">
		<h1>InsightAI Dashboard</h1>
		<h2>Latest Orders</h2>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th>Order</th>
					<th>Customer</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($orders as $order) : ?>
					<tr>
						<td><?php echo $order->get_order_number(); ?></td>
						<td><?php echo $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(); ?></td>
						<td><?php echo $order->get_date_created(); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

// organise the dashboard functions into an array

$insightai_dashboard_functions = [
	'insightai_dashboard' => 'Dashboard',
	'insightai_dashboard_users' => 'Users',
	'insightai_dashboard_posts' => 'Posts',
	'insightai_dashboard_comments' => 'Comments',
	'insightai_dashboard_orders' => 'Orders',
];

// organise the array in a view for the dashboard

function insightai_dashboard_page(): void
{
	global $insightai_dashboard_functions;
	?>
	<div class="wrap">
		<h1>InsightAI Dashboard</h1>
		<nav class="nav-tab-wrapper">
			<?php foreach ($insightai_dashboard_functions as $function => $title) : ?>
				<a href="?page=insightai-dashboard&function=<?php echo $function; ?>" class="nav-tab"><?php echo $title; ?></a>
			<?php endforeach; ?>
		</nav>
		<?php
		$function = $_GET['function'] ?? 'insightai_dashboard';
		if (array_key_exists($function, $insightai_dashboard_functions)) {
			call_user_func($function);
		}
		?>
	</div>
	<?php
}

// add the dashboard page to the admin menu

function insightai_menu(): void
{
	add_menu_page('InsightAI', 'InsightAI', 'manage_options', 'insightai-dashboard', 'insightai_dashboard_page');
}




