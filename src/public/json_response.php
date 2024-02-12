<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    try {
        // Your code here...

        $response = [
            'username' => 'UserOne',
            'password' => '123456',
            'data' => $data,
        ];
        header('Content-type: application/json');
        echo json_encode($response);
    } catch (Exception $e) {
        // If an error occurs, return a JSON error message
        echo json_encode(['error' => $e->getMessage()]);
    }

    // header('Location: /');
} else {
    http_response_code(400);
}
