<?php

$ageEstimeDuCapitaine = estimationAge();
echo "Age estimé du capitaine: {$ageEstimeDuCapitaine} ans\n";
function estimationAge() : int
{
    $ageDuCapitaine = null;
    $longueurBateau = 310;
    if ($longueurBateau > 300) {
        $ageDuCapitaine = 50;
    } else {
        $ageDuCapitaine = 40;
    }
    $poidsDuCapitaine = 100;
    $pi = 3.14;
    $termine = true;
    return $ageDuCapitaine;
}