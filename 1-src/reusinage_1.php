<?php
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;
require "../vendor/autoload.php";

Test();

function Test()
{


    // Lis le code source à traiter
    $code = file_get_contents("programme.php");
    echo "Source à réusiner:\n $code \n";
    // Analyse syntaxique du code

    affiche_source("Etat initial", $arbre_syntaxique);

}

function parse_to_AST($code) : array
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

