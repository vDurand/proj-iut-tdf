# [TDF MAJ](http://www.iutc3.unicaen.fr/)

L'objectif est de réaliser un ou plusieurs formulaires de mise à jour des tables du tour de France. Le langage utilisé sera le PHP et la présentation sera faite en HTML.

## Préparation des tables des tours 2015 à XXXX

- TDF_COUREUR :
    - On ne peut supprimer un coureur qui possède des participations au tour de France,
    - Une modification ne peut concerner le numéro de coureur,
    - Les champs : nom,prenom et code_tdf sont obligatoires,
    - num_coureur est calculé,
    - les noms des coureurs sont écrits en majuscule sans accent. Les tirets (dont 1 double tiret), espaces isolés
sont autorisés mais pas au début et à la fin. Les apostrophes sont autorisées. Les caractères autorisés sont
ceux de l'alphabet français (sans ligature),
    - les prénoms des coureurs sont écrits en minuscule sauf les premières lettres de chaque mot, codée en
majuscule sans accent. Les tirets et espaces isolés sont autorisés mais ni au début, ni à la fin,

- TDF_SPONSOR
    - Est considéré comme nouveau sponsor une « équipe » dont le nom exact + nom abrégé (ou code_tdf) n'est
pas ou plus dans la liste des sponsors actifs. Le sponsor actif est le dernier sponsor d'une équipe qui n'a pas
disparue. Créer un nouveau sponsor consiste à « remplacer » (par ajout d'un nouveau sponsor) l'ancien
sponsor par le nouveau.

- TDF_EQUIPE
    - Quand une nouvelle équipe est créée, un nouveau sponsor lui est associé.

- TDF_EQUPE_ANNEE
    - Cette table contient la participation des équipes au tour de France. Seuls les sponsors actifs peuvent être
inscrits
    - Au moins un directeur est associé à cette participation.
    - Un directeur ne peut participer au même tour de France avec plusieurs sponsors

- TDF_PARTICIPATION
    - Les coureurs peuvent être inscrits dans les équipes elles-mêmes participantes.
    - 9 coureurs peuvent être inscrits dans chaque équipe
    - les dossards d'une équipe appartient à la même dizaine (de X1 à X9)
    - les dossards doivent être uniques à chaque tour de France
    - un coureur ne peut-être inscrit à plusieurs tours de France la même année

- Les noms des épreuves sont codés comme les noms des coureurs . Les chiffres sont autorisés,
- Les noms des sponsors sont écrits en majuscule sans accent : tous les caractères (même ceux de contrôle) sont
autorisés.
Attention aux suppressions et modifications : l'intégrité référentielle doit être préservée.