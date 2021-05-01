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

Test();

function Test()
{
    // Programme Source à réusiner
    $reusinage = new Reusinage("programme1");
    $reusinage->reusine_source();
}



// Affiche un Arbre Syntaxique
function affiche_arbre_syntaxique($titre, $arbre_syntaxique)
{

}


