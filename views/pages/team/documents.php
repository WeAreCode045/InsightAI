<?php
/*
Template Name: vereniging Documents Template
*/

get_header();

// Handle document upload process
if (isset($_POST['upload_document'])) {
    $uploaded_file = $_FILES['document'];
    $selected_team = $_POST['team']; // Get the selected team ID

    // Check if a file was uploaded
    if ($uploaded_file['error'] === UPLOAD_ERR_OK) {
        $upload_dir = wp_upload_dir();
        $file_name = basename($uploaded_file['name']);
        $file_path = $upload_dir['path'] . '/' . $file_name;

        // Move the uploaded file to the uploads directory
        move_uploaded_file($uploaded_file['tmp_name'], $file_path);

        // Save the file path and team association or perform any other necessary actions
        $document_data = array(
            'name' => $file_name,
            'url' => $file_path,
            'team_id' => $selected_team
        );
        // Save $document_data to the database
    }
}

// Get the current user's WooCommerce membership teams
$current_user = wp_get_current_user();
$user_teams = wc_memberships_get_user_memberships($current_user->ID);

?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <h1>Team Documents</h1>

        <!-- Document Upload Form -->
        <form method="post" enctype="multipart/form-data">
            <label for="document">Select Document:</label>
            <input type="file" name="document" id="document">

            <!-- Select vereniging -->
            <label for="team">Select Team:</label>
            <select name="team" id="team">
                <?php foreach ($user_teams as $team) : ?>
                    <option value="<?php echo $team->get_id(); ?>"><?php echo $team->get_name(); ?></option>
                <?php endforeach; ?>
            </select>

            <input type="submit" name="upload_document" value="Upload Document">
        </form>
<?php
// Display Uploaded Documents for the Current vereniging
$current_team_id = $selected_team; // Get the selected team ID

$args = array(
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'meta_query' => array(
        array(
            'key' => 'team_id', // Assuming 'team_id' is the meta key for team association
            'value' => $current_team_id,
            'compare' => '='
        )
    )
);

$uploaded_documents_query = new WP_Query($args);

if ($uploaded_documents_query->have_posts()) {
    ?>
    <h2>Uploaded Documents</h2>
    <table>
        <thead>
            <tr>
                <th>Document Name</th>
                <th>Download Link</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($uploaded_documents_query->have_posts()) : $uploaded_documents_query->the_post(); ?>
                <tr>
                    <td><?php echo get_the_title(); ?></td>
                    <td><a href="<?php echo wp_get_attachment_url(get_the_ID()); ?>" target="_blank">Download</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php
} else {
    echo 'No documents uploaded for this team.';
}

wp_reset_postdata();
?>

        <!-- Display Uploaded Documents for the Current vereniging -->
        <!-- Add code to display uploaded documents -->

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
