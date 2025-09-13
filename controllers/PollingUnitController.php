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
    
    
}
?>