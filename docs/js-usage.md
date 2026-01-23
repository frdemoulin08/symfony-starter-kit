# Usage du JavaScript dans ce projet

## Principes

- **Vanilla JS par défaut** : pas de jQuery, sauf obligation ultime (ex. DataTables).
- **Pas de Stimulus** : uniquement si un besoin critique est identifié.
- **Webpack Encore** est la chaîne d'assets officielle.
- Le JavaScript applicatif est **factorisé** dans `assets/js/`.
- Les initialisations globales (theme, notifications, etc.) passent par des helpers réutilisables.

## Structure des fichiers

```
assets/js/
├── pages/
│   └── base_template.js # Entrée principale liée au template de base
├── components/          # Composants UI réutilisables
├── helpers/             # Utilitaires et fonctions partagées
└── datatables/          # Exceptions jQuery/DataTables si nécessaire
```

## Entrée principale

Le point d'entrée unique est `assets/app.js` (Webpack Encore).  
Il charge `assets/js/pages/base_template.js`, qui appelle les helpers nécessaires.

## Règles d'utilisation

- **Écrire en vanilla JS** pour les interactions simples.
- **Factoriser** dans `assets/js/components` et `assets/js/helpers`.
- **Limiter jQuery** aux cas où une dépendance l'impose (ex. DataTables).
- **Documenter** toute exception (bibliothèque imposée, dépendance legacy, etc.).

## Debug local

Un message de log est présent dans `base_template.js` pour vérifier le chargement
au développement.
