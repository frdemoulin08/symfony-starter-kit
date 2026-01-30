# Reservation Salle

## Présentation
Application de réservation de salles et d’administration (backoffice SPSL), avec gestion des sites, utilisateurs, journaux d’authentification et tâches planifiées.

## Stack technique
- **Backend** : Symfony 8 (PHP 8.4)
- **DB** : MySQL 8 (dev/prod), SQLite pour les tests
- **Front** : Twig + Tailwind 4 + Flowbite 4
- **Tooling** : Webpack Encore, PHPUnit

## Mise en route rapide

1) Installer les dépendances PHP
```
composer install
```

2) Installer les dépendances front
```
npm install
```

3) Configurer la base (ex. `.env.local`)
```
DATABASE_URL="mysql://user:pass@127.0.0.1:3306/reservation_salle?serverVersion=8.4.0&charset=utf8mb4"
```

4) Migrations
```
php bin/console doctrine:migrations:migrate
```

5) Fixtures (⚠️ purge la base)
```
php bin/console doctrine:fixtures:load
```

## Commandes utiles

### Tests
```
./vendor/bin/phpunit --testdox
```

### Build assets
```
npm run watch
npm run build
```

### Cache
```
php bin/console cache:clear
```

## Documentation

### Tests
- Index : `docs/testing.md`
- Guide dev : `docs/testing/guide-debutant.md`
- Stratégie : `docs/testing/strategie.md`

### UI / Design
- Couleurs CD08 : `docs/ui/colors.md`
- Flowbite + Tailwind : `docs/ui/flowbite-tailwind-integration.md`
- Guidelines Flowbite + Tailwind : `docs/ui/flowbite-with-tailwind-guidelines.md`
- Icônes Flowbite : `docs/ui/icons.md`

### Dev / Process
- Versioning : `docs/VERSIONING.md`
- Epics & user stories : `docs/EPICS.md`
- Usage JavaScript : `docs/technique/js-usage.md`
- PHPMyAdmin : `docs/technique/phpmyadmin.md`
- Tâches CRON : `docs/cron.md`
- Stratégie tableaux : `docs/technique/tableaux/strategie-gestion-tableaux-symfony-flowbite.md`
- Guide dev tableaux : `docs/technique/tableaux/guide-implementation-tableaux.md`

### Sécurité / RGPD
- Journalisation RGPD : `docs/securite/rgpd-journalisation.md`
- Politique mots de passe : `docs/securite/politique-mots-de-passe.md`
