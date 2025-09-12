<?php
class LGAController {
    public static function getLGAs($conn) {
        $query = "SELECT lga_id, lga_name FROM lga WHERE state_id = 25";
        $result = mysqli_query($conn, $query);
        $lgas = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $lgas[] = $row;
        }
        echo json_encode($lgas);
    }

    public static function getLGAResult($conn, $id) {
        $query = "SELECT apr.party_abbreviation, SUM(apr.party_score) AS total_score
                  FROM announced_pu_results apr 
                  JOIN polling_unit pu ON apr.polling_unit_uniqueid = pu.uniqueid 
                  WHERE pu.lga_id = $id 
                  GROUP BY apr.party_abbreviation";
        $result = mysqli_query($conn, $query);
        $results = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $results[] = $row;
        }
        echo json_encode($results);
    }
}
?>