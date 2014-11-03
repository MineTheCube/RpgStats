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