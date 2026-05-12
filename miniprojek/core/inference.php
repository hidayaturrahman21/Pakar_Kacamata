<?php

function inferenceEngine($conn, $user_conditions)
{
    $rules = mysqli_query($conn, "
        SELECT *
        FROM rules
    ");

    $best_score = 0;

    $best_rule = null;

    $matched_conditions = [];

    while ($rule = mysqli_fetch_assoc($rules)) {

        $id_rule = $rule['id_rule'];

        $details = mysqli_query($conn, "
            SELECT
                rd.weight_score,
                c.condition_code,
                c.condition_name
            FROM rule_details rd
            JOIN conditions c
            ON rd.id_condition = c.id_condition
            WHERE rd.id_rule = '$id_rule'
        ");

        $total_score = 0;

        $current_match = [];

        while ($detail = mysqli_fetch_assoc($details)) {

            if (in_array($detail['condition_code'], $user_conditions)) {

                $total_score += $detail['weight_score'];

                $current_match[] = $detail['condition_code'];
            }
        }

        if ($total_score > $best_score) {

            $best_score = $total_score;

            $best_rule = $rule;

            $matched_conditions = $current_match;
        }
    }

    // ==========================
    // FALLBACK
    // ==========================

    if ($best_rule == null) {

        $fallback = mysqli_query($conn, "
            SELECT *
            FROM recommendations
            ORDER BY id_recommendation DESC
            LIMIT 1
        ");

        $fallback_data = mysqli_fetch_assoc($fallback);

        return [

            'hasil' => $fallback_data,

            'matched_conditions' => [],

            'rule' => null
        ];
    }

    // ==========================
    // AMBIL REKOMENDASI
    // ==========================

    $id_recommendation = $best_rule['id_recommendation'];

    $recommendation = mysqli_query($conn, "
        SELECT *
        FROM recommendations
        WHERE id_recommendation = '$id_recommendation'
    ");

    $hasil = mysqli_fetch_assoc($recommendation);

    $hasil['reasoning_rule'] = $best_rule['reasoning_rule'];

    return [

        'hasil' => $hasil,

        'matched_conditions' => $matched_conditions,

        'rule' => $best_rule
    ];
}