<?php
header('Content-Type: application/json');
http_response_code(200);
echo json_encode([
    'status' => 'Absensi SMAN1 Baregbeg API Online',
    'version' => '1.0',
    'mode' => 'anti-crash ready',
    'time' => date('Y-m-d H:i:s')
]);
