<?php

use App\Controllers\StepsController;

require __DIR__ . '/bootstrap.php';


try {
    $controller = new StepsController();
    $response = $controller->index();

    if ($response->getStatusCode() == 200) {
        $data = json_decode($response->getBody(), true);
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

} catch (\Exception $e) {

    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}


