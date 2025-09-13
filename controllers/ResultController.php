<?php
// Prevent PHP warnings breaking JSON output
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

class ResultController {
    public static function addResult($conn, $data) {
        header('Content-Type: application/json');
        ob_start(); // Start output buffering

        $response = [
            "success" => false,
            "message" => "",
            "errors" => []
        ];

        try {
            if (!is_array($data)) {
                $response['message'] = "Invalid data format";
                $response['received'] = $data;
                echo json_encode($response);
                ob_end_flush();
                return;
            }

            $inserted = 0;

            foreach ($data as $row) {
                if (!isset($row['polling_unit_uniqueid'], $row['party_abbreviation'], $row['party_score'], $row['entered_by_user'])) {
                    $response['errors'][] = "Missing keys in row: " . json_encode($row);
                    continue;
                }

                $polling_unit_id = intval($row['polling_unit_uniqueid']);
                $party = mysqli_real_escape_string($conn, $row['party_abbreviation']);
                $score = intval($row['party_score']);
                $entered_by_user = mysqli_real_escape_string($conn, $row['entered_by_user']);
                $user_ip_address = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

                $query = "INSERT INTO announced_pu_results 
                          (polling_unit_uniqueid, party_abbreviation, party_score, entered_by_user, date_entered, user_ip_address)
                          VALUES ($polling_unit_id, '$party', $score, '$entered_by_user', NOW(), '$user_ip_address')";

                if (!mysqli_query($conn, $query)) {
                    $response['errors'][] = "DB Error: " . mysqli_error($conn);
                } else {
                    $inserted++;
                }
            }

            if ($inserted > 0 && empty($response['errors'])) {
                $response['success'] = true;
                $response['message'] = "$inserted results added successfully";
            } elseif ($inserted > 0 && !empty($response['errors'])) {
                $response['success'] = true;
                $response['message'] = "$inserted results added, some failed";
            } else {
                $response['message'] = "No results inserted";
            }
        } catch (Exception $e) {
            $response['errors'][] = $e->getMessage();
            $response['message'] = "An exception occurred";
        }

        ob_clean(); // Clear any accidental output
        echo json_encode($response);
        ob_end_flush();
    }
}
?>
