<?php
require_once PLUGIN_DIR . 'vendor/autoload.php';

use Smalot\PdfParser\Parser;
use GuzzleHttp\Client;

function pdf_analyzer_enqueue_scripts() {
    wp_enqueue_script('pdf-analyzer-ajax', plugin_dir_url(__FILE__) . 'assets/js/pdf-analyzer.js', ['jquery'], null, true);
    wp_localize_script('pdf-analyzer-ajax', 'pdfAnalyzer', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);
}
add_action('wp_enqueue_scripts', 'pdf_analyzer_enqueue_scripts');

// Shortcode to display the form and answer container
function pdf_analyzer_shortcode() {
    ob_start();
    $current_group_id = bp_get_current_group_id();
    $group_dir = wp_upload_dir()['basedir'] . '/group-docs/group-' . $current_group_id;
    $pdf_files = glob($group_dir . '/*.pdf');
    ?>
    <h1>Ask a Question About a PDF</h1>
    <div id="chatbox">
        <div id="chat-messages"></div>
        <form id="pdf-analyzer-form">
            <label for="pdf_file">Select PDF:</label><br>
            <select id="pdf_file" name="pdf_file" required>
                <?php foreach ($pdf_files as $pdf_file): ?>
                    <option value="<?php echo esc_attr($pdf_file); ?>"><?php echo esc_html(basename($pdf_file)); ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <label for="question">Your Question:</label><br>
            <input type="text" id="question" name="question" required><br><br>
            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('pdf-analyzer-form');
            const chatMessages = document.getElementById('chat-messages');

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const formData = new FormData(form);
                const question = formData.get('question');

                const userMessage = document.createElement('div');
                userMessage.className = 'chat-message user';
                userMessage.textContent = question;
                chatMessages.appendChild(userMessage);

                fetch(pdfAnalyzer.ajax_url + '?action=pdf_analyzer', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        const answerMessage = document.createElement('div');
                        answerMessage.className = 'chat-message bot';
                        if (data.success) {
                            answerMessage.innerHTML = `<h2>Answer:</h2><p>${data.data.answer}</p>`;
                        } else {
                            answerMessage.innerHTML = `<p>Error: ${data.data}</p>`;
                        }
                        chatMessages.appendChild(answerMessage);
                    })
                    .catch(error => {
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'chat-message bot';
                        errorMessage.innerHTML = '<p>Error fetching the answer. Please try again.</p>';
                        chatMessages.appendChild(errorMessage);
                    });
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('pdf_analyzer', 'pdf_analyzer_shortcode');

// AJAX handler for the form submission
function pdf_analyzer_handle_ajax() {
    $parser = new Parser();
    $pdf_file = sanitize_text_field($_POST['pdf_file']);
    $pdf = $parser->parseFile($pdf_file);
    $pdfText = $pdf->getText();

    $openai_api_key = get_option('options_openai_api_key');

    if (!$pdfText) {
        wp_send_json_error('Failed to extract text from PDF.');
    }

    $userQuestion = sanitize_text_field($_POST['question'] ?? '');

    if (empty($userQuestion)) {
        wp_send_json_error('Please provide a question.');
    }

    $client = new Client(['base_uri' => 'https://api.openai.com/v1/']);

    $response = $client->post('chat/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . $openai_api_key,
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an assistant that answers questions about PDF content.'],
                ['role' => 'user', 'content' => "Here is the content of a PDF: \n$pdfText"],
                ['role' => 'user', 'content' => $userQuestion],
            ],
        ],
    ]);

    $result = json_decode($response->getBody(), true);
    $answer = $result['choices'][0]['message']['content'] ?? 'No response';

    wp_send_json_success(['answer' => $answer]);
}
add_action('wp_ajax_pdf_analyzer', 'pdf_analyzer_handle_ajax');
add_action('wp_ajax_nopriv_pdf_analyzer', 'pdf_analyzer_handle_ajax');
?>