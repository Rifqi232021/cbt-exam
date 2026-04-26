<?php
$url = 'http://127.0.0.1:8000/api/test/start';
$data = json_encode([
    'jenis_ujian' => 'uts',
    'nama' => 'Auto Test',
    'sekolah' => 'smk1',
    'token' => '232021',
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$info = curl_getinfo($ch);
$err = curl_error($ch);

if ($err) {
    echo "ERROR START: $err\n";
    exit(1);
}

$data = json_decode($response, true);
if (!$data || !$data['success']) {
    echo "START FAILED: $response\n";
    exit(1);
}
$sessionToken = $data['session_token'];

$ch2 = curl_init('http://127.0.0.1:8000/api/test/questions');
curl_setopt($ch2, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Session-Token: ' . $sessionToken,
]);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
$response2 = curl_exec($ch2);
$info2 = curl_getinfo($ch2);
$err2 = curl_error($ch2);

echo "START HTTP=" . $info['http_code'] . "\n";
echo "QUESTIONS HTTP=" . $info2['http_code'] . "\n";
if ($err2) {
    echo "ERROR QUESTIONS: $err2\n";
    exit(1);
}
$json2 = json_decode($response2, true);
echo "QUESTIONS RESPONSE: \n" . json_encode($json2, JSON_PRETTY_PRINT) . "\n";
