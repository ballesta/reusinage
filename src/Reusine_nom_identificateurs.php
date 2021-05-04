<?php
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

// Exemple de réusinage à reprendre pour tout nouvel usinage.
// Seule partie à écrire, le reste est factorisé et donc commun à tout les usinages.

// Change le nom des identificateurs
class Reusine_nom_identificateurs extends NodeVisitorAbstract
{
    use Trace;

    // Exécuté à l'entrée de chaque noeud de l'arbre syntaxique
    // Ce visiteur est appelé par l'accompagnateur qui organise la visite
    // Appellé pour chawque noeud de l'arbre syntaxique
    public function enterNode
    (
        // Entrée dans le noeud
        Node $node
    )
    {
        // Traitement selon le type du noeud
        // Un seul traitement réalisé avec retour immédiat

        // Variable ?
        if ($node instanceof Node\Expr\Variable)
        {
            // Visite d'une variable
            Trace::affiche( "Visite Identificateur", $node->name);
            // Transforme le nom de la variable en "camelCase"
            $node->name = $this->snake_to_camel_case($node->name);
        }

        // Appel de fonction ?
        elseif  ($node instanceof Node\Expr\FuncCall)
        {
            // Visite d'un appel de fonction
            Trace::affiche( "Visite d'un appel de fonction", $node->name);
            $node->name->parts[0] = $this->snake_to_camel_case($node->name);
        }

        // Définition de fonction ?
        elseif ($node instanceof Node\Stmt\Function_)
        {
            // Visite d'un appel de fonction
            Trace::affiche( "Visite d'une définition de fonction", $node->name);

            $node->name->name = $this->snake_to_camel_case($node->name);
        }
        // Autre noeud: ignorer (ne rien faire)
    }

    // Transforme un identifiant du format "snake_case" en "camelCase"
    function snake_to_camel_case
    (
        // Identifiant en snakeCase à transformer
        String $id_snake
    )
    :
        // Identifiant en camelCase renvoyé
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
                    // Pour le prochain caractère
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
                // Ne pas retranscrire (ignorer) ce caractère souligné
            }
        }
        $id_camel = implode("", $id_camel_array);
        // Renvoie l'identifiant transformé en camelCase
        return $id_camel;
    }
}