<?php
include 'quiz_handler.php';

$user_scores_details = fetch_top_50_users_use_index();

if (!empty($user_scores_details)) {
    // Output the scores
    echo "<h2>Top 50 Users by Answer Accuracy and Time Taken</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Rank</th><th>User Name</th><th>Question Total</th><th>Answer Accuracy</th><th>Seconds</th><th>Item Name</th></tr>";
    
    $rank = 1;
    foreach ($user_scores_details as $row) {
        echo "<tr>
                <td>" . $rank . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["question_total"] . "</td>
                <td>" . $row["answer_acc"] . "</td>
                <td>" . $row["seconds"] . "</td>
                <td>" . ($row["item_name"] ?? 'N/A') . "</td>
              </tr>";
        $rank++;
    }

    echo "</table>";
} else {
    echo "No results found.";
}

?>