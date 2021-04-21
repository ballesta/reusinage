<?php

tests('Transforme un identifiant du format snake_case en camelCase');

// Tests (en premier, le plus important
function tests(string $titre)
{
    echo "Test: $titre\n";
    verifie('age_du_capitaine', 'ageDuCapitaine');
    verifie('age_de_la_capitaine', 'ageDeLaCapitaine');
    verifie('_age_', 'Age');
    verifie('AGE', 'age');
    verifie('A__g__e', 'aGE');
    echo "Fin du Test\n";
}

// Vérifie que la transformation donne le résultat attendu

function verifie(string $id_snake,      // Identifiant à transformer
                 string $id_camel_OK)   // Identifiant attendu après transformation
{
    // Transformation
    $id_camel = snake_to_camel_case($id_snake);

    echo "    $id_snake";
    // Pour la présentation en colonnes
    $espaces = 20 - strlen($id_snake);
    for ($i=0; $i<$espaces; $i++) echo ' ';
    // Identifiant attendu
    echo " => $id_camel_OK ";
    // Voir si la transformation correspond au résultat attendu
    if ($id_camel === $id_camel_OK)
        echo "OK";
    else
        echo " ==> $id_camel ***Erreur***";
    echo "\n";
}

// Transforme un identifiant du format snake_case en camelCase
function snake_to_camel_case(String $id_snake) : String
{
    // Transforme l'identifiant en minuscules
    $id_snake = strtolower($id_snake);
    // Transforme l'identifiant en un tableau de caracteres
    $id_snake_array = str_split($id_snake);
    // Résultat de la transformation
    $id_camel_array = [];
    $forcer_Majuscule = false;
    foreach ($id_snake_array as $c){
        if ($c !== '_')
        {
            // Caractère autre que sous-ligné
            if ($forcer_Majuscule)
            {
                // Forcer en Majuscule
                $id_camel_array[] = ucfirst($c);
                $forcer_Majuscule = false;
            }
            else
            {
                // Garder en minuscule
                $id_camel_array[] = $c;
            }
        }
        else
        {
            // Caractère '_'
            // Forcer le prochain caractère en majuscules
            $forcer_Majuscule = true;
            // Ne pas retranscrire le caractère sousligné
        }
    }
    $id_camel = implode("", $id_camel_array);
    return $id_camel;
}
