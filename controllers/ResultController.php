<?php
class ResultController {
    public static function addResult($conn, $data) {
        if (!is_array($data)) {
            echo json_encode(["success" => false, "message" => "Invalid data format"]);
            return;
        }

        foreach ($data as $row) {
            $polling_unit_id = intval($row['polling_unit_uniqueid']);
            $party = mysqli_real_escape_string($conn, $row['party_abbreviation']);
            $score = intval($row['party_score']);
            $entered_by_user = mysqli_real_escape_string($conn, $row['entered_by_user']);
            $user_ip_address = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

            $query = "INSERT INTO announced_pu_results 
                      (polling_unit_uniqueid, party_abbreviation, party_score, entered_by_user, date_entered, user_ip_address)
                      VALUES ($polling_unit_id, '$party', $score, '$entered_by_user', NOW(), '$user_ip_address')";

            if (!mysqli_query($conn, $query)) {
                echo json_encode(["success" => false, "message" => "DB Error: " . mysqli_error($conn)]);
                return;
            }
        }

        echo json_encode(["success" => true, "message" => "Results added successfully"]);
    }
}
?>
