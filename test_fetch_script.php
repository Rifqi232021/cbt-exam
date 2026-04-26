<?php
$content = file_get_contents('http://127.0.0.1:8000/script.js');
if ($content === false) {
    echo "FAILED\n";
    exit(1);
}
echo substr($content, 0, 160);
