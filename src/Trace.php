<?php

trait Trace
{
    // Affiche la trace ?
    static bool $_affiche = true;

    public static function affiche
    (
        string $titre,
        string $contenu
    )
    {
        if (self::$_affiche)
        {
            echo $titre ;
            if (strlen($contenu) > 50)
                echo "\n";
            echo "$contenu: \n";
        }
    }

}