<?php

$body = json_encode([
    'jenis_ujian' => 'uts',
    'nama' => 'Test Student',
    'sekolah' => 'smk1',
    'token' => '232021',
]);

// Test start endpoint
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/test/start');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_COOKIE, '');

$response = curl_exec($ch);
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($response, 0, $headerSize);
$body_content = substr($response, $headerSize);

echo "=== START API RESPONSE ===\n";
echo "Headers:\n$headers\n";
$data = json_decode($body_content, true);
echo "Body:\n" . json_encode($data, JSON_PRETTY_PRINT) . "\n";

// Extract session token
$sessionToken = $data['session_token'] ?? null;
if (!$sessionToken) {
    echo "No session token received!\n";
    exit(1);
}

echo "\nSession Token: $sessionToken\n";

// Test questions endpoint
echo "\n=== QUESTIONS API REQUEST ===\n";
$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, 'http://127.0.0.1:8000/api/test/questions');
curl_setopt($ch2, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Session-Token: ' . $sessionToken,
]);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

$response2 = curl_exec($ch2);
$questionsData = json_decode($response2, true);

echo "Questions Response:\n" . json_encode($questionsData, JSON_PRETTY_PRINT) . "\n";

if (!empty($questionsData['questions'])) {
    echo "\n=== FIRST QUESTION ===\n";
    echo "Text: " . $questionsData['questions'][0]['question_text'] . "\n";
    echo "Options: " . json_encode($questionsData['questions'][0]['options']) . "\n";
    echo "Total Questions: " . count($questionsData['questions']) . "\n";
}

curl_close($ch);
curl_close($ch2);
