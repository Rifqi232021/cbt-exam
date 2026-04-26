<?php
$urls = [
    'http://127.0.0.1:8000/script.js',
    'http://127.0.0.1:8000/dashboard.html',
    'http://127.0.0.1:8000/ujian.html',
];

foreach ($urls as $url) {
    echo "URL: $url\n";
    $content = @file_get_contents($url);
    if ($content === false) {
        echo "FAILED\n\n";
        continue;
    }
    echo "LEN=" . strlen($content) . "\n";
    echo "START=" . str_replace(["\r", "\n"], ['',' '], substr($content, 0, 180)) . "\n\n";
}
