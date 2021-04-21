<?php

// Transforme un identifiant du format snake_case en camelCase
function snake_to_camel_case(String $id_snake) : String
{
    // Transforme en minuscules
    $id_snake = strtolower($id_snake);
    // Résultat de la transformation
    $id_camel = '';
    $iMax = strlen($id_snake);
    for ($i = 0; $i < $iMax; $i++){
        $c = $id_snake[$i];
        echo $c,'-';
        if ($c != '_')
        {
            $id_camel .= $c;
        }
        else
        {
            // '_'
            // Prochain caractère
            $i++;
            $c = $id_snake[$i];
            // En majuscules
            $id_camel .= ucfirst($c);
        }
    }
    die();
    return $id_camel;
}

    $v = '_age_du_capitaine';
    echo $v, ' => ', snake_to_camel_case('age_du_capitaine'), "\n";
