# Tutoriel sur le réusinage de programmes en PHP

# Objectifs, présentation

Définition de Wikipédia l'encyclopédie libre:
- https://fr.wikipedia.org/wiki/Réusinage_de_code

Le **réusinage** de code est l'opération consistant à:
- retravailler (restructurer) le code source d'un programme informatique, 
- sans y ajouter de nouvelles fonctionnalités,
- sans en corriger les bogues.

Le terme **réusinage** est originaire du Québec
Le terme anglais est "**refactoring**"

L'objectif de ce tutoriel est de présenter l'utilisation de l'outil "**PHP PARSER**" 
pour faire du réusinage de code.

# Types d'outils de réusinage

- Editeurs de texte
    - Les éditeurs de texte proposent des commandes de remplacement global
d'une chaine de caractère par une autre
portant sur le contenu d'un programme ou d'un dossier.

    - Des expressiosn régulières peuvent être mises à contribution pour sélectionner les 
    mots à remplacer.
      
- Environnements de déveveloppements
    - Les IDE comme PHPStorm de JetBrain ou VS code de Microsoft proposent des stragegies de remplacement 
    plus sophistiquée en supportant les expressions régulières et en distingant le code source et les commentaires
      
    - Ces outils quoi que très puissant et utiles ont leur limites
        - Par exemple, changer les noms des variables d'un programme de conventions d'écriture 
            - de "Snake case" ("date_de_naissance") qui était la pratique dominante dans les années 1980 
            - vers "dateDeNaissance" en "Camel Case" qui est apparue plus tard
              https://commons.wikimedia.org/wiki/File:CamelCase.svg#/media/Fichier:CamelCase.svg
              
- Les outils basés sur l'analyse syntaxiques des langages comme PHP PARSER que nous allons utiliser.

    - PHP Parser 
    
# Analyse syntaxique de programmes PHP

![Analyse lexicale et Syntaxique](Analyse_syntaxique.png)

- L’analyse lexicale, est la conversion d’une chaîne de caractères (un texte) 
en une liste de symboles (tokens en anglais). 
- Elle fait partie de la première phase de la chaîne de compilation. 
- Les symboles générés par l'analyseur lexical sont ensuite consommés lors de l'analyse syntaxique. 
- Un analyseur lexical est généralement combiné à un analyseur syntaxique pour 
analyser la syntaxe du texte basé sur la grammaire du langage.
  
## Analyse lexicale

Prenons un exemple


## Analyse syntaxique

### Arbre syntaxique

# Vérifications avant installation

- Ce tutoriel est réalisé sur le système d'exploitation Ubuntu version 20:

    ````
       lsb_release -a
       Distributor ID:	Ubuntu
       Description:	Ubuntu 20.10
       Release:	20.10
       Codename:	groovy
    ````
  
- Vous devez disposer des logiciels suivants:
    - **Composer**
      ````
        composer --version
        Composer version 2.0.9 2021-01-27 16:09:27
      ````
    - **PHP**
      - Php version supérieure ou égale à la 7.0
      - **PHP 7.4** est utilisé pour les besoins de ce tutoriel
          ````
          php -v
          PHP 7.4.16 (cli) (built: Mar  5 2021 07:54:56) ( NTS )
          Copyright (c) The PHP Group
          Zend Engine v3.4.0, Copyright (c) Zend Technologies
          with Zend OPcache v7.4.16, Copyright (c), by Zend Technologies
          ````
    
# Creation du projet

Créer un dossier "reusinage_PHP" pour notre projet:

````
mkdir reusinage_PHP
````


# Installation de PHP PARSER

# Logiciels utilisés

## Visualisation d'arbres syntaxiques

[RSyntaxTree](https://yohasebe.com/rsyntaxtree/)

Outil permettant de générer la visualisation d'un arbre syntaxique à partir d'une version textuelle.

Fragment de programme comportant deux assignations:

````
    $pi = 3.14;
    
    $révolution-Française = 1798;
````

Texte de l'**arbre syntaxique**:

````
[PROGRAMME
    [ASSIGNATION
        [VARIABLE PI]
        [NOMBRE-FLOTTANT 3.14]
    ]
    [ASSIGNATION
        [VARIABLE révolution-Française]
        [NOMBRE-ENTIER 1789]
    ]
]
````
Diagramme généré par le logiciel "**rsyntaxtree**":

![Arbre syntaxique de deux assinations](AS_Assignations.png)
