RpgStats, une API pour RPG Paradize
========

A quoi ça sert ?
---------

Cette API s'utilise en PHP, et permet de connaitre la position, le nombre de votes et d'OUT d'un serveur classé sur rpg-paradize.com

Ou le télécharger ?
---------

Téléchargez la dernière version juste ici:
https://github.com/MineTheCube/RpgStats/releases

Vous obtiendrez une archive contenant 2 fichiers PHP: l'API et un exemple d'utilisation.

Comment l'utiliser ?
---------

Il suffit d'inclure le fichier ```RpgStats.class.php``` (les autres sont optionnels) pour récuperer les infos.

Le fichier ```stats.php``` est un exemple d'utilisation de cette API, vous pouvez l'utiliser pour commencer:

```php
<?php

// Inclut le fichier contenant l'API
require_once 'RpgStats.class.php';

// Créé un nouvel objet avec l'ID du serveur
$RpgStats = new RpgStats(44302);

// Retourne le nombre de votes avec la fonction dédiée
echo 'Votes: ' . $RpgStats->getVotes();

// Retourne le nombre d'Out directement
echo '<br/>' . 'Out: ' . $RpgStats->out;

// Affiche les stats (position, votes, out) en format JSON
echo '<br/>' . 'JSON: ' . $RpgStats;

?>
```
