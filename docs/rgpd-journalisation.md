# Note RGPD – Journalisation des connexions

## Finalité
La journalisation des connexions vise la **sécurité** du système et des données : détection d'accès non autorisés, investigation d'incidents, traçabilité des actions d'accès. citeturn0search0turn0search1

## Données enregistrées (minimisation)
Pour rester proportionné, le journal de connexion conserve uniquement :
- identifiant utilisateur (clé interne),
- date et heure de connexion,
- succès/échec,
- adresse IP,
- user‑agent (navigateur/appareil).

La CNIL recommande la traçabilité des opérations avec l’identifiant de l’auteur et la date/heure (et la nature de l’opération), afin de détecter les anomalies. citeturn0search1turn0search2
Dans ce projet, l’IP et le user‑agent sont ajoutés pour disposer d’un contexte technique minimal, sans stocker d’informations métier.

## Durée de conservation
- **Journalisation standard** : **6 à 12 mois**. citeturn0search0turn0search1turn0search2
- **Exceptions** : durée plus longue si obligation légale, gestion de contentieux, contrôle interne ou besoin d’analyse post‑incident. citeturn0search0turn0search1

Le projet retient une **conservation par défaut de 12 mois**, paramétrable si besoin.

## Purge automatique
Une commande Symfony supprime les entrées dépassant la durée retenue :

```
php bin/console app:log-user:purge --days=365
```

Cette commande est prévue pour une exécution **hebdomadaire** via CRON (tout en supprimant uniquement les entrées âgées de plus d’un an).

Par défaut, la **suppression** est retenue, car la CNIL insiste surtout sur la limitation de la durée de conservation et l’absence de conservation sans limite. Si un besoin statistique durable apparaît, une **anonymisation irréversible** peut être envisagée, à cadrer avec le DPO. citeturn0search1turn0search2turn0search4

## Sécurité et accès aux journaux
Les journaux doivent faire l'objet de mesures techniques et organisationnelles pour limiter tout risque de détournement de finalité et d'accès non autorisé. citeturn0search1

## Base légale
Base légale à préciser avec le DPO ; en pratique, l'intérêt légitime lié à la sécurité est souvent retenu (RGPD, art. 6‑1‑f).
