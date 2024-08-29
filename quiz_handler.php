<?php
include 'db_connect.php';


function fetch_top_50_users_use_index()
{
    // Connect to the database
    global $conn;

    // Optimized query with the necessary indexes in place
    $sql = "SELECT u.name, qr.question_total, qr.answer_acc, qr.seconds, qfi.item_name 
            FROM user u 
            JOIN quiz_result qr ON u.user_id = qr.user_id
            JOIN quiz_filter_items qfi ON qfi.item_id = qr.item_id
            WHERE qr.deleted = 0
            ORDER BY qr.answer_acc DESC, qr.seconds ASC
            LIMIT 50";

    // Execute the query
    $result = $conn->query($sql);

    // Fetch data
    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Close the database connection
    $conn->close();

    return $data;
}

// Function to fetch top 50 user scores with optimization
function fetch_top_50_users_use_cache()
{
    $cacheDir = 'cache';
    $cacheFile = $cacheDir . '/top_50_users.json';
    $cacheTime = 3600; // 1 hour

    // Check if the cache directory exists, if not, create it
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0777, true); // 0777 is permission, true allows recursive creation
    }

    // Check if the cache file exists and is not expired
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
        // Fetch data from the cache file
        $data = json_decode(file_get_contents($cacheFile), true);
        return $data;
    }

    // Connect to the database
    global $conn;

    // Optimized query
    $sql = "SELECT u.name, qr.question_total, qr.answer_acc, qr.seconds, qfi.item_name 
            FROM user u 
            JOIN quiz_result qr ON u.user_id = qr.user_id
            JOIN quiz_filter_items qfi ON qfi.item_id = qr.item_id
            WHERE qr.deleted = 0
            ORDER BY qr.answer_acc DESC, qr.seconds ASC
            LIMIT 50";

    $result = $conn->query($sql);

    // Fetch data
    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Save data to cache file
    file_put_contents($cacheFile, json_encode($data));
    echo "Data fetched from MySQL and saved to file cache.<br>";

    // Close the database connection
    $conn->close();

    return $data;
}

