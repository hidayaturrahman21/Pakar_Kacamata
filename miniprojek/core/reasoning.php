<?php

function generateReasoning($conn, $conditions)
{
    $hasil = [];

    foreach ($conditions as $condition) {

        $query = mysqli_query($conn, "
            SELECT condition_name
            FROM conditions
            WHERE condition_code = '$condition'
        ");

        $data = mysqli_fetch_assoc($query);

        if ($data) {

            $hasil[] = "✔ " . $data['condition_name'];
        }
    }

    return $hasil;
}