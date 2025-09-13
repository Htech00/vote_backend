<?php
class PartyController {
    public static function getParties($conn) {
        $query = "SELECT partyid FROM party";
        $result = mysqli_query($conn, $query);

        $parties = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $parties[] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($parties);
    }
}
?>