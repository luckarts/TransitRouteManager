# Project Api TransitRouteManager

Développer une API gérant un ensemble de cartes de transport en désordre,

- une fonction pour identifier le point de départ de l'itineraire
- une fonction pour récupérer la prochaine ville dans l'itinéraire.
- une fonction pour créer l'itinéraire en utilisant les deux fonctions précédentes.

User story
En tant qu' utilisateur,
Je veux pouvoir avoir l'itinéraire d'un point A vers un point B
Afin que je puisse voir l'ordre complet des transports .

# Liste des Fonctions du Service :

- une fonction pour identifier le point de départ de l'itineraire
- une fonction pour récupérer la prochaine ville dans l'itinéraire.
- une fonction pour créer l'itinéraire en utilisant les deux fonctions précédentes.

# Tests Unitaires :

# Écrire et exécuter des tests unitaires pour les trois fonctions.

- [x] Assurer la couverture de tous les cas possibles.
  - [x] Un itineraire doit avoir des données valide.
  - [x] Un itineraire peux ne pas avoir de données.
- [x] Un itineraire peux de mauvaise donnée.
- [x] Gestion des Erreurs lorsque l'itineraires est invalid
- [x] Les tests doivent etre faux car pas d'algorithme sous-jacent

# Développer l'algorithme sous-jacent pour les services.

Valider les tests unitaires en utilisant l'algorithme des services.

# Tâches de Développement du Contrôleur

- Le Controller va devoir appellée recuperer la collections les itineraires avec leurs differentes steps et il va utiliser le service precedant trier les étapes et definir une itineraire.

- [x] Créer le contrôleur en intégrant le Itinary service , la recuperation des datas et les services développés.
- [x] S'assurer que le contrôleur fonctionne comme prévu avec les services intégrés.

  # Reformate

- [x] Crée le Model Step
- [x] Crée la Collection Itineraire
- [x] S'assurer que le contrôleur fonctionne avec le reformate

  # Cette Api ne prend pas en compte plusieurs itineraires Comme plusieurs depart et plusieurs arrivée

# Autres Features

pour plus tard Possibilité de definir une route et CRUD
