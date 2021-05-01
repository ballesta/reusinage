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
    function __construct($nom_fichier_programme) {
        $this->nom_fichier_programme = "../tests/{$nom_fichier_programme}.php";
        $this->programme_modifie = "../tests/{$nom_fichier_programme}_modifie.php";
        echo "Tansforme $this->nom_fichier_programme  en $this->programme_modifie\n";
    }

    function reusine_source()
    {
        // Lis le code source à traiter
        $code = file_get_contents($this->nom_fichier_programme);
        echo "Source à réusiner:\n $code \n";

        // Analyse syntaxique du code produisant l'arbre syntaxique
        $arbre_syntaxique = $this->analyse_syntaxe($code);
        $this->affiche_arbre_syntaxique("Programme1.php", $arbre_syntaxique);

        // Réusinage de l'arbre syntaxique
        $arbre_syntaxique_reusine = $this->reusine_arbre_syntaxique($arbre_syntaxique);

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

    private function reusine_arbre_syntaxique(array $arbre_syntaxique)
    {
        // Crée un accompagnateur pour la visite de l'arbre syntaxique
        $accompagnateur = new NodeTraverser();
        // Crée un visiteur pour tous les noeuds de l'arbre syntaxique
        $accompagnateur->addVisitor(new class extends NodeVisitorAbstract {
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
            function snake_to_camel_case(String $id_snake) : String
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
        });
        return $accompagnateur->traverse($arbre_syntaxique);
    }

    private function affiche_arbre_syntaxique(string $titre, 
                                              array $arbre_syntaxique)
    {

        echo "****  Arbre Syntaxique ", $titre, " ****", "\n";
        // Create AST Dumper
        $afficheur_AS = new NodeDumper;
        // Affiche AS
        echo $afficheur_AS->dump($arbre_syntaxique), "\n\n";
        return;
    }

    // Affiche le source du programme à partir de l`arbre syntaxique
    private function affiche_source($titre, $arbre_syntaxique)
    {
        echo "---- Source: $titre ----\n";
        // Crée un générateur de source à partir d'un arbre syntaxique
        $prettyPrinter = new PrettyPrinter\Standard();
        // Regénère le source à partir de l`arbre syntaxique
        $source_modifie = $prettyPrinter->prettyPrintFile($arbre_syntaxique);
        // Ecris le source généré
        file_put_contents($this->programme_modifie,$source_modifie);
        echo "programme1_modifié.php \n", $source_modifie, "\n\n";
    }
}