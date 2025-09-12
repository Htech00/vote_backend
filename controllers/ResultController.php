<?php
class ResultController {
    public static function addResult($conn, $data) {
        $polling_unit_id = intval($data['polling_unit_id']);
        $entered_by_user = mysqli_real_escape_string($conn, $data['entered_by_user']);
        $user_ip_address = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

        foreach ($data['results'] as $party => $score) {
            $party = mysqli_real_escape_string($conn, $party);
            $score = intval($score);
            $query = "INSERT INTO announced_pu_results 
                      (polling_unit_uniqueid, party_abbreviation, party_score, entered_by_user, date_entered, user_ip_address)
                      VALUES ($polling_unit_id, '$party', $score, '$entered_by_user', NOW(), '$user_ip_address')";
            mysqli_query($conn, $query);
        }
        echo json_encode(["success" => true, "message" => "Results added successfully"]);
    }
}
?>