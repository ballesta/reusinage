<?php

// Le réusinage de code est l`opération consistant à retravailler (restructurer)
// le code source d`un programme informatique
// sans toutefois
//     - y ajouter des fonctionnalités
//     - ni en corriger les bogues
// de façon à en améliorer
//     - la lisibilité,
//     - la maintenance
//     - et l`évolution.

// Charges les composants utilisés (principalement "php parser")
require "../vendor/autoload.php";

require "Reusinage.php";
require "Reusine_nom_identificateurs.php";

Test();

function Test()
{
    // Programme Source à réusiner
    $reusinage = new Reusinage
                 ("programme1",
                  new Reusine_nom_identificateurs()
                 );
    $reusinage->reusine_source();
}


