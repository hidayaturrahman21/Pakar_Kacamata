<?php

function hitungSkor($user_conditions, $rule_conditions)
{
    $score = 0;

    foreach ($rule_conditions as $rule) {

        if (in_array($rule['condition_code'], $user_conditions)) {

            $score += $rule['weight_score'];
        }
    }

    return $score;
}