<?php
// Analyseur lexical et syntaxique de sources PHP
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

// Ce dont a besoin le visiteur pour transformer le programme
// au cours du parcours de l'arbre syntaxique.
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

class Reusinage
{
    function __construct($nom_fichier_programme, NodeVisitorAbstract $visiteur) {
        $this->nom_fichier_programme = "../tests/{$nom_fichier_programme}.php";
        $this->programme_modifie = "../tests/{$nom_fichier_programme}_modifie.php";
        echo "Tansforme $this->nom_fichier_programme  en $this->programme_modifie\n";

        // Lis le code source à traiter
        $code = file_get_contents($this->nom_fichier_programme);
        echo "Source à réusiner:\n $code \n";

        // Analyse syntaxique du code produisant l'arbre syntaxique
        $arbre_syntaxique = $this->analyse_syntaxe($code);
        $this->affiche_arbre_syntaxique($this->nom_fichier_programme,
                                        $arbre_syntaxique);

        // Réusinage de l'arbre syntaxique
        $arbre_syntaxique_reusine = $this->reusine_arbre_syntaxique($arbre_syntaxique,
                                                                    $visiteur);

        $this->affiche_source("Après réusinage", $arbre_syntaxique_reusine);
    }

    // Renvoie l'arbre syntaxique du code du programme source.
    private function analyse_syntaxe($code) : array
    {
        // Crée l'analyseur syntaxique de PHP version 7
        $analyseur_syntaxique_php = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        try {
            // Analyse le code à réusiner
            $arbre_syntaxique = $analyseur_syntaxique_php->parse($code);

        } catch (Error $error) {
            echo "Erreur: {$error->getMessage()}\n";
            die();
        }
        return $arbre_syntaxique;
    }

    private function reusine_arbre_syntaxique
    (
        // Arbre syntaxique à réusiner
        array $arbre_syntaxique,
        // Visiteur responsable des modifications
        NodeVisitorAbstract $visiteur
    )
    {
        // Crée un accompagnateur (traverseur)
        // pour la visite (le parcours) de l'arbre syntaxique
        $accompagnateur = new NodeTraverser();
        // Crée un visiteur pour tous les noeuds de l'arbre syntaxique
        $accompagnateur->addVisitor($visiteur);
        // Traverse l'arbre syntaxique et fait les modifications
        return $accompagnateur->traverse($arbre_syntaxique);
    }

    private function affiche_arbre_syntaxique
    (
        // Titre de l'affichage
        string $titre,
        // Arbre syntaxique à afficher
        array $arbre_syntaxique
    )
    {
        echo "****  Arbre Syntaxique ", $titre, " ****", "\n";
        // Crée l'afficheur d'arbre syntaxique
        $afficheur_AS = new NodeDumper;
        // Affiche AS
        echo $afficheur_AS->dump($arbre_syntaxique), "\n\n";
        return;
    }

    // Affiche pûis sauvegarde le source du programme à partir de l`arbre syntaxique
    private function affiche_source($titre, $arbre_syntaxique)
    {
        echo "---- Source: $titre ----\n";
        // Crée un générateur de source à partir d'un arbre syntaxique
        $prettyPrinter = new PrettyPrinter\Standard();
        // Regénère le source à partir de l`arbre syntaxique
        $source_modifie = $prettyPrinter->prettyPrintFile($arbre_syntaxique);
        // Ecris le source généré
        file_put_contents($this->programme_modifie,$source_modifie);
        echo "{$this->programme_modifie}.php \n",
             $source_modifie,
             "\n\n";
    }
}