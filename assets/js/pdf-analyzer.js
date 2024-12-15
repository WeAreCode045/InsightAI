document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('pdf-analyzer-form');
    const answerDiv = document.getElementById('answer');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(form);

        fetch(pdfAnalyzer.ajax_url + '?action=pdf_analyzer', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    answerDiv.innerHTML = `<h2>Answer:</h2><p>${data.data.answer}</p>`;
                } else {
                    answerDiv.innerHTML = `<p>Error: ${data.data}</p>`;
                }
            })
            .catch(error => {
                answerDiv.innerHTML = '<p>Error fetching the answer. Please try again.</p>';
            });
    });
});