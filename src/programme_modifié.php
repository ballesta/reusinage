<?php

$ageEstiméDuCapitaine = estimationAge();
echo "Age_estimé_du_capitaine: {$ageEstiméDuCapitaine} ans\n";
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
    $terminé = true;
    return $ageDuCapitaine;
}