<?php

$Age_estime_du_capitaine = estimation_age();
echo "Age estimé du capitaine: $Age_estime_du_capitaine ans\n";
function estimation_age() : int
{
    $age_du_capitaine = null;
    $longueur_bateau = 310;
    if ($longueur_bateau > 300)
        $age_du_capitaine = 50;
    else
        $age_du_capitaine = 40;
    $POIDS_du_capitaine = 100;
    $Pi = 3.14;
    $____Termine____ = true;
    return $age_du_capitaine;
}
?>
