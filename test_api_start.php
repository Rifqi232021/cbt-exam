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
curl_close($ch);

echo "HTTP_CODE=" . $info['http_code'] . "\n";
echo "ERROR=" . $err . "\n";
echo "BODY=\n" . $response . "\n";
