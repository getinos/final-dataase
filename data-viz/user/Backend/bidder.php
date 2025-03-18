<?php
include './../DB/config.php';

$currentId = isset($_GET['id']) ? (is_numeric($_GET['id']) ? intval($_GET['id']) : 0) : 0;
$team = isset($_GET['uid']) && is_numeric($_GET['uid']) ? intval($_GET['uid']) : 0;

    $sql = "SELECT * FROM (
                SELECT player_price FROM bidding WHERE player_id = :currentId
                UNION ALL
                    SELECT player_price FROM player_details WHERE player_id = :currentId
                ) AS combined_results ORDER BY player_price DESC LIMIT 1";


    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->execute([':currentId' => $currentId]);

    // Fetch the result
    $result = $stmt->fetch();

    $amount = $result['player_price'];

    if($amount < 100) {
        $C_amount = $amount + 5;
    } else if($amount < 200 && $amount >= 100) {
        $C_amount = $amount + 10;
    } else if($amount < 500 && $amount >= 200) {
        $C_amount = $amount + 20;
    } else if($amount >= 500) {
        $C_amount = $amount + 25;
    } else {
        alert("Invalid Amount");
    }

if ($result) {
    echo "<button id='bid-button' onclick='placeBid({$team}, {$C_amount}, {$currentId})'> BID NOW (₹{$C_amount} L)</button>";
} else {
    echo "<div class='team-rank'> No teams found. </div>";
}

    $a_sql = "SELECT SUM(player_price) AS total_amount
                FROM winner
                WHERE team_id = :currentId";
    
    $a_stmt = $conn->prepare($a_sql);
    $a_stmt->execute([':currentId' => $team]);
    $a_result = $a_stmt->fetch();

    // Store the total amount
    $total_amount = $a_result['total_amount'] ?? 0;
    echo "<input type='hidden' id='total_amount' value='$total_amount' readonly />";
?>