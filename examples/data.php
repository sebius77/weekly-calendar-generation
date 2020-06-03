<?php
// Traitement via le filtre en fonction de la catégorie (prof), du code (12345) et de la ou des dates.
// ------------- Première requête --------------------
// On récupère le nom du filtre (nom de l'enseignant si catégorie prof, nom du groupe si groupe, nom de la salle si salle)
$data['nameFilter'] = 'toto';   // Dans notre exemple
// ------------- deuxième requête ---------------------
// On récupère toutes les séances (sessions) correspondant au filtre
$data = [
[
'filter' => 'prof-12345',
'filterName' => 'toto',
'sessions' => [
[
0 => 12345, // code Ressource
1 => '2020-03-24', // Date du jour
2 => '800', // Heure de début
3 => '60', // 130 signifie 1h30 ; Durée séance
4 => 'TD', // Type de séance
5 => 'Mathematiques', // nom de matière
6 => 'Toto', // nom de l'enseignant
7 => 'R10', // nom de salle
8 => [],
9 => 'salle-test', // alias de salle
],
[
0 => 123345,
1 => '2020-03-24',
2 => '800',
3 => '130', // 130 signifie 1h30
4 => 'TD',
5 => 'Mathematiques',
6 => 'Toto',
7 => 'R12',
8 => [],
9 => 'salle-test',
],
[
0 => 123345,
1 => '2020-03-24',
2 => '830',
3 => '100', // 130 signifie 1h30
4 => 'TD',
5 => 'Mathematiques',
6 => 'Toto',
7 => 'R12',
8 => [],
9 => 'salle-test',
],
[
0 => 12345,
1 => '2020-03-25',
2 => '1000',
3 => '100', // 130 signifie 1h30
4 => 'CM',
5 => 'Français',
6 => 'Toto',
7 => 'R12',
8 => [],
9 => 'salle-2'
]
]
]
];