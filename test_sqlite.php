<?php

// On définit le chemin manuellement comme Symfony le ferait
$dossierVar = __DIR__ . '/var';
$fichierDb = $dossierVar . '/data.db';

echo "--- DIAGNOSTIC SQLITE ---\n";
echo "1. Dossier var : " . $dossierVar . "\n";

// Test 1 : Vérifier si le dossier existe
if (!is_dir($dossierVar)) {
    die("ERREUR : Le dossier 'var' n'est pas trouvé par PHP. Crée-le !\n");
} else {
    echo "OK : Le dossier 'var' existe.\n";
}

// Test 2 : Vérifier si on peut écrire dedans
if (!is_writable($dossierVar)) {
    die("ERREUR : PHP dit qu'il ne peut PAS écrire dans le dossier 'var'. Problème de droits Windows.\n");
} else {
    echo "OK : Le dossier 'var' est accessible en écriture.\n";
}

// Test 3 : Tenter de créer le fichier avec PDO (comme Doctrine)
try {
    // On tente la connexion directe sans passer par la config Symfony
    $pdo = new PDO('sqlite:' . $fichierDb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // On crée une table bidon pour forcer l'écriture sur le disque
    $pdo->exec("CREATE TABLE IF NOT EXISTS test_table (id INTEGER PRIMARY KEY)");

    echo "SUCCÈS TOTAL : La base a été créée manuellement ici : $fichierDb\n";
    echo "Si tu vois ce message, c'est que ta config Symfony (.env) est la cause du problème.\n";
} catch (PDOException $e) {
    echo "ERREUR PDO CRITIQUE : " . $e->getMessage() . "\n";
}
