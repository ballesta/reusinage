<?php
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

class Reusine_nom_identificateurs extends NodeVisitorAbstract
{
    // Exécuté à l'entrée de chaque noeud de l'arbre syntaxique
    public function enterNode(Node $node)
    {
        // Traitement selon le type du noeud

        // Variable ?
        if ($node instanceof Node\Expr\Variable) {
            // Visite d'une variable
            echo ">>>>Visite Identificateur $node->name \n";
            // Transforme le nom de la variable en "camelCase"
            $node->name = $this->snake_to_camel_case($node->name);
        }

        // Appel de fonction
        if ($node instanceof Node\Expr\FuncCall) {
            // Visite d'un appel de fonction
            echo ">>>>Visite d'un appel de fonction $node->name \n";
            $node->name->parts[0] = $this->snake_to_camel_case($node->name);
        }

        // Définition de fonction
        if ($node instanceof Node\Stmt\Function_) {
            // Visite d'un appel de fonction
            echo ">>>>Visite d'un appel de fonction $node->name \n";
            $node->name->name = $this->snake_to_camel_case($node->name);
        }
    }

    // Transforme un identifiant du format "snake_case" en "camelCase"
    function snake_to_camel_case
    (
        // Identifiant en snakeCase à transformer
        String $id_snake
    )
    :
        // Identifiant en snakeCase renvoyé
        String
    {
        // Transforme l'identifiant en lettres minuscules
        $id_snake = strtolower($id_snake);
        // Transforme l'identifiant en un tableau de caracteres
        $id_snake_array = str_split($id_snake);
        // Résultat de la transformation
        $id_camel_array = [];
        // Forcer le prochain caratère en Majuscule
        $forcer_Majuscule = false;
        $premier_caractere = true;
        // Pour tous les caractères de l'identifiant
        foreach ($id_snake_array as $c){
            if ($c !== '_')
            {
                // Caractère autre que sous-ligné
                if (!$premier_caractere && $forcer_Majuscule )
                {
                    // Forcer en Majuscule
                    $id_camel_array[] = ucfirst($c);
                    $forcer_Majuscule = false;
                }
                else
                {
                    // Garder en minuscule
                    $id_camel_array[] = $c;
                    $premier_caractere = false;
                    $forcer_Majuscule = false;
                }
            }
            else
            {
                // Caractère '_'
                // Forcer le prochain caractère en majuscules
                $forcer_Majuscule = true;
                // Ne pas retranscrire (ignorer) le caractère souligné
            }
        }
        $id_camel = implode("", $id_camel_array);
        return $id_camel;
    }
}