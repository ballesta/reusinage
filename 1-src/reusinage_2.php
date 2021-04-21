<?php
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

// Ce dont a besoin le visiteur
use PhpParser\Node;
use PhpParser\Node\Stmt\Function_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

require "../vendor/autoload.php";

Test();

function Test()
{
    // Lis le code source à traiter
    $code = file_get_contents("programme.php");
    echo "Source à réusiner:\n $code \n";
    // Analyse syntaxique du code
    $arbre_syntaxique = analyse_syntaxe($code);
    $arbre_syntaxique_reusine = reusine($arbre_syntaxique);
    affiche_source("Après réusinage", $arbre_syntaxique_reusine);

}

// Renoie l'arbre syntaxique du code du programme source
function analyse_syntaxe($code) : array
{
    // Creates Php7 Parser
    $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
    try {
        // Parse the code
        $arbre_syntaxique = $parser->parse($code);

    } catch (Error $error) {
        echo "Parse error: {$error->getMessage()}\n";
        die();
    }
    return $arbre_syntaxique;
}

function reusine($arbre_syntaxique) : array
{

    // Crée un accompagnateur pour la visite de l'arbre syntaxique
    $accompagnateur = new NodeTraverser();
    // Crée un visiteur pour tous les noeuds de l'arbre syntaxique
    $accompagnateur->addVisitor(new class extends NodeVisitorAbstract {
        // Exécuté à l'entrée de chaque noeud
        public function enterNode(Node $node) {
            // Traitement selon le type du noeud
            if ($node instanceof Node\Expr\Variable) {
                // Visite d'un identificateur
                echo ">>>>Visite Variable $node->name \n";
                $node->name = snake_to_camel_case($node->name);
            }
        }
    });

    $arbre_syntaxique_reusiné = $accompagnateur->traverse($arbre_syntaxique);
    return $arbre_syntaxique_reusiné;
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
    $premier_caractere = true;
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
            // Ne pas retranscrire le caractère sousligné
        }
    }
    $id_camel = implode("", $id_camel_array);
    return $id_camel;
}



// Affiche Arbre syntaxique
function affiche_arbre_syntaxique($titre, $arbre_syntaxique)
{
    echo "****  Ast ", $titre, " ****", "\n";
    // Create AST Dumper
    $dumper = new NodeDumper;
    // Affiche AS
    echo $dumper->dump($arbre_syntaxique), "\n";
    return;
}

// Affiche le source du programme à partie de l'arbre syntaxique
function affiche_source($titre, $arbre_syntaxique)
{
    affiche_arbre_syntaxique($titre, $arbre_syntaxique);
    echo "\n";
    echo "---- Source: $titre ----\n";
    $prettyPrinter = new PrettyPrinter\Standard();
    echo $prettyPrinter->prettyPrintFile($arbre_syntaxique);
    echo "\n";
}

