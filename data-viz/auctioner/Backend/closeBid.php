<?php
    include '../../DB/config.php';

    // GET CURRENT PLAYER ID
    $currentId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // ✅ 2. SELECT Next Record from player_details
    // $newPlayerId = $currentId+1;
    // $stmt = $conn->prepare("SELECT * FROM player_details where player_id = :playerId ORDER BY player_id ASC Limit 1");
    // $stmt->bindParam(":playerId", $newPlayerId, PDO::PARAM_INT);
    // $stmt->execute();
    // $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // $newId = $row['player_id'];

        // ✅ 2.1 UPDATE PLAYER STATUS TO 1
        /*
            0 -> Unattended
            1 -> Current Player
            2 -> Attended
        */
        $query = "UPDATE player_details SET sold_resume = :id WHERE player_id = :currentId";
        $s_stmt = $conn->prepare($query);
        $s_stmt->execute([':id' => 2, ':currentId' => $currentId]);


    // if ($row) {
    //     echo json_encode($row);
    // } else {
    //     echo json_encode(["error" => "No more records"]);
    // }

?>