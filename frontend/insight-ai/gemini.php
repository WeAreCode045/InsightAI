<?php
curl "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=AIzaSyCChB4qSi2VWEny32BmSGNSFZJ7h5gcHn0" \
-H 'Content-Type: application/json' \
-X POST \
-d '{
"contents": [{
"parts":[{"text": "Explain how AI works"}]
}]
}'