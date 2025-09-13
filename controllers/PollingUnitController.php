<?php
class PollingUnitController {
    public static function getPollingUnits($conn) {
        $query = "SELECT uniqueid, polling_unit_name FROM polling_unit";
        $result = mysqli_query($conn, $query);
        $units = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $units[] = $row;
        }
        echo json_encode($units);
    }

    public static function getPollingUnitResult($conn, $id) {
        $query = "SELECT apr.party_abbreviation, apr.party_score 
                  FROM announced_pu_results apr 
                  JOIN polling_unit pu ON apr.polling_unit_uniqueid = pu.uniqueid 
                  WHERE pu.uniqueid = $id";
        $result = mysqli_query($conn, $query);
        $results = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $results[] = $row;
        }
        echo json_encode($results);
    }

    public static function addResult($conn, $data) {
        if (!is_array($data)) {
            echo json_encode(["success" => false, "message" => "Invalid data format"]);
            return;
        }

        foreach ($data as $r) {
            $polling_unit_id = intval($r['polling_unit_uniqueid']);
            $party = mysqli_real_escape_string($conn, $r['party_abbreviation']);
            $score = intval($r['party_score']);
            $entered_by_user = mysqli_real_escape_string($conn, $r['entered_by_user']);

            $query = "INSERT INTO announced_pu_results 
                        (polling_unit_uniqueid, party_abbreviation, party_score, entered_by_user, date_entered, user_ip_address)
                      VALUES 
                        ($polling_unit_id, '$party', $score, '$entered_by_user', NOW(), '127.0.0.1')";

            mysqli_query($conn, $query);
        }

        echo json_encode(["success" => true, "message" => "Polling unit results saved successfully"]);
    }

    
}
?>