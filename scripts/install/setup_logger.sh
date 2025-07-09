#!/usr/bin/env bash
set -euo pipefail

# Ce script configure logger.php et le dossier de logs pour Apache
# Logger capture GET, POST, COOKIES, HEADERS dans .log et .json
# Doit être exécuté en root

if [ "$(id -u)" -ne 0 ]; then
    echo "Erreur : ce script doit être exécuté en tant que root."
    exit 1
fi

WEB_ROOT="/var/www/html"
LOG_DIR="$WEB_ROOT/logs"
LOGGER_PHP="$WEB_ROOT/logger.php"

# Création du dossier de logs
mkdir -p "$LOG_DIR"
chown www-data:www-data "$LOG_DIR"
chmod 0755 "$LOG_DIR"

# Création de logger.php
cat > "$LOGGER_PHP" <<'EOF'
<?php
// logger.php - capture et enregistre toutes les requêtes
date_default_timezone_set('UTC');
$logDir = __DIR__ . '/logs';
$date = date('d-m-Y');
$logFile = "$logDir/$date.log";
$jsonFile = "$logDir/$date.json";

// Collecte des données de la requête
$data = [
    'timestamp'    => date('c'),
    'method'       => $_SERVER['REQUEST_METHOD'],
    'uri'          => $_SERVER['REQUEST_URI'],
    'ip'           => $_SERVER['REMOTE_ADDR'],
    'query'        => $_GET,
    'post'         => $_POST,
    'cookies'      => $_COOKIE,
    'headers'      => function_exists('getallheaders') ? getallheaders() : [],
];

// Entrée lisible pour le .log
$entry = sprintf(
    "[%s] %s %s from %s\nGET: %s\nPOST: %s\nCOOKIES: %s\nHEADERS: %s\n\n",
    $data['timestamp'],
    $data['method'],
    $data['uri'],
    $data['ip'],
    json_encode($data['query']),
    json_encode($data['post']),
    json_encode($data['cookies']),
    json_encode($data['headers'])
);

// Écriture dans le fichier .log
file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);

// Ajout du hash à la structure de données
$data['hash'] = hash('sha256', $entry);

// Écriture dans le fichier .json (pretty)
$jsonEntry = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($jsonFile, $jsonEntry . "\n", FILE_APPEND | LOCK_EX);

// Réponse simple
header('Content-Type: text/plain');
echo "Logged\n";
EOF

# Permissions
chown www-data:www-data "$LOGGER_PHP"
chmod 0644 "$LOGGER_PHP"

# Message final
echo "✅ logger.php et dossier logs créés."
echo "  - Logger: $LOGGER_PHP"
echo "  - Logs : $LOG_DIR"
