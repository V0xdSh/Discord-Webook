<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $webhooks = explode("\n", $_POST["webhooks"]);
    $message = $_POST["message"];
    foreach ($webhooks as $webhook) {
        $data = array('content' => $message);
        $headers = array('Content-Type: application/json');
        $ch = curl_init($webhook);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        if ($response === false) {
            http_response_code(500);
            exit;
        }
    }
    http_response_code(200);
}
?>