Itération 5 : Création de la table 'Profil'.
Afin d'ajouter la gestion des profils utilisateurs, une nouvelle table nommée profil a été créée. Elle comprend les colonnes suivantes :

- id (type INT, auto-incrémenté),
- name (type VARCHAR(255)),
- avatar (type VARCHAR(255)),
- min_age (type INT(11)).

Pour les données, j’ai gardé les mêmes valeurs que celles utilisées dans les tables movie et category, pour rester cohérent. Pour les noms, j’ai choisi de tout laisser en anglais et en minuscules, pour garder une certaine uniformité.



Itération 9 : Création de la table 'Favorites'.

Pour permettre aux utilisateurs d’ajouter des films à leurs favoris, j’ai mis en place une table favorites. Elle contient :

- id en INT auto-incrémenté,
- id_profile : clé étrangère vers l’id de la table profil,
- id_movie : clé étrangère vers l’id de la table movie.

Comme pour le reste, j’ai gardé des noms de champs en anglais et tout en minuscules pour garder une cohérence dans le projet.


Itération 11 : Ajout de la colonne 'is_featured'.
Pour pouvoir mettre en avant certains films, j’ai ajouté une colonne is_featured dans la table movie. Elle est de type TINYINT(1), ce qui permet de simuler un booléen. Par défaut, la valeur est à 0, donc non mis en avant.


Itération 14 : Création de la table 'Ratings'.
J’ai intégré une table ratings pour permettre aux utilisateurs de noter les films. Elle comprend :

- id en INT auto-incrémenté,
- profile_id : clé étrangère vers profil,
- movie_id : clé étrangère vers movie,
- rating : TINYINT(4), pour stocker la note donnée.

Là aussi, les noms de champs restent en anglais et minuscules, pour rester fidèle à la convention du projet.



Itération 15 : Mise en place de la table 'Comments'.
Pour activer les commentaires sur les films, j’ai ajouté une table comments avec les champs suivants :

id en INT auto-incrémenté,

- movie_id : clé étrangère vers movie,
- profile_id : clé étrangère vers profil,
- comment : champ TEXT pour stocker le contenu,
- created_at : DATETIME pour enregistrer la date et l’heure de publication.


Itération 16 : Ajout de la colonne 'Status'.
Pour modérer les commentaires, j’ai ajouté une colonne status à la table comments. Elle utilise une énumération : enum('pending', 'approved', 'deleted'), ce qui permet de gérer l’état de chaque commentaire. Par défaut, un commentaire est marqué comme pending, pour éviter qu’il ne soit affiché avant validation.

Itération 17 : Ajout de la colonne 'created_at' à la table 'movie'.
Pour enregistrer la date et l’heure de création de chaque film, j’ai ajouté une colonne created_at à la table movie. Elle est de type DATETIME et permet de garder une trace précise du moment où chaque entrée a été ajoutée. Les valeurs sont automatiquement remplies avec la date et l’heure du moment de l’insertion.


