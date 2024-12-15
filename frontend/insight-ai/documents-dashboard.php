<?php

function custom_upload_dir($uploads) {
	$current_group_id = bp_get_current_group_id();
	$group_dir = '/group-docs/group-' . $current_group_id;

	$uploads['path'] = $uploads['basedir'] . $group_dir;
	$uploads['url'] = $uploads['baseurl'] . $group_dir;
	$uploads['subdir'] = $group_dir;

	// Create the directory if it doesn't exist
	if (!wp_mkdir_p($uploads['path'])) {
		return new WP_Error('upload_dir_error', 'Unable to create directory.');
	}

	return $uploads;
}

// Get the current user ID
$user_id = get_current_user_id();
$groups = groups_get_user_groups($user_id);

if (empty($groups)) {
	echo 'You are not a member of any groups.';
} else {
	// Assume the user is viewing a specific group page and get the current group ID
	$current_group_id = bp_get_current_group_id();

	// Display the form to upload documents
	echo '<form method="post" enctype="multipart/form-data">';
	echo '<input type="file" name="file" />';
	echo '<button type="submit" name="upload_document">Upload</button>';
	echo '</form>';

	// Handle the form submission
	if (isset($_POST['upload_document'])) {
		add_filter('upload_dir', 'custom_upload_dir'); // Apply the filter before handling the upload
		$file = $_FILES['file'];
		$attachment_id = media_handle_upload('file', 0);
		remove_filter('upload_dir', 'custom_upload_dir'); // Remove the filter after handling the upload

		if (is_wp_error($attachment_id)) {
			echo 'There was an error uploading the file.';
		} else {
			update_post_meta($attachment_id, 'group_id', $current_group_id);
			echo 'The file was uploaded successfully.';
		}
	}

	// Handle document deletion
	if (isset($_POST['delete_document'])) {
		$attachment_id = absint($_POST['attachment_id']);
		if (wp_delete_attachment($attachment_id, true)) {
			echo 'The file was deleted successfully.';
		} else {
			echo 'There was an error deleting the file.';
		}
	}

	// Display the table with group documents
	echo '<h2>Group Documents</h2>';
	echo '<table>';
	echo '<tr>';
	echo '<th>Document</th>';
	echo '<th>Action</th>';
	echo '</tr>';
	$args = array(
		'post_type' => 'attachment',
		'meta_key' => 'group_id',
		'meta_value' => $current_group_id,
		'orderby' => 'date',
		'order' => 'DESC',
	);
	$documents = get_posts($args);
	if (!empty($documents)) {
		foreach ($documents as $document) {
			$file_url = wp_get_attachment_url($document->ID);
			echo '<tr>';
			echo '<td>' . esc_html($document->post_title) . '</td>';
			echo '<td>';
			echo '<form method="post" style="display:inline;">';
			echo '<input type="hidden" name="attachment_id" value="' . esc_attr($document->ID) . '">';
			echo '<button type="submit" name="delete_document">Delete</button>';
			echo '</form>';
			echo '<button onclick="previewDocument(\'' . esc_url($file_url) . '\')">Preview</button>';
			echo '</td>';
			echo '</tr>';
		}
	}
	echo '</table>';

	// Add a div for the document preview
	echo '<div id="document-preview" style="display:none;">';
	echo '<h2>Document Preview</h2>';
	echo '<canvas id="pdf-canvas" style="width:100%;"></canvas>';
	echo '<button onclick="closePreview()">Close Preview</button>';
	echo '</div>';

	// Add JavaScript for handling the preview
	echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>';
	echo '<script>
            function previewDocument(url) {
                var loadingTask = pdfjsLib.getDocument(url);
                loadingTask.promise.then(function(pdf) {
                    pdf.getPage(1).then(function(page) {
                        var scale = 1.5;
                        var viewport = page.getViewport({ scale: scale });

                        var canvas = document.getElementById("pdf-canvas");
                        var context = canvas.getContext("2d");
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        var renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };
                        page.render(renderContext);
                    });
                });
                document.getElementById("document-preview").style.display = "block";
            }
            function closePreview() {
                document.getElementById("document-preview").style.display = "none";
                var canvas = document.getElementById("pdf-canvas");
                var context = canvas.getContext("2d");
                context.clearRect(0, 0, canvas.width, canvas.height);
            }
        </script>';
}