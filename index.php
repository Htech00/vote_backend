<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once __DIR__ . '/config/db_connect.php';
require_once __DIR__ . '/controllers/PollingUnitController.php';
require_once __DIR__ . '/controllers/LGAController.php';
require_once __DIR__ . '/controllers/ResultController.php';

$action = $_GET['action'] ?? null;

switch ($action) {
    case 'getPollingUnits':
        PollingUnitController::getPollingUnits($conn);
        break;
    case 'getPollingUnitResult':
        $id = intval($_GET['id'] ?? 0);
        PollingUnitController::getPollingUnitResult($conn, $id);
        break;
    case 'getLGAs':
        LGAController::getLGAs($conn);
        break;
    case 'getLGAResult':
        $id = intval($_GET['id'] ?? 0);
        LGAController::getLGAResult($conn, $id);
        break;
    case 'addResult':
        $data = json_decode(file_get_contents("php://input"), true);
        ResultController::addResult($conn, $data);
        break;
    default:
        echo json_encode(["error" => "Invalid action"]);
}
?>