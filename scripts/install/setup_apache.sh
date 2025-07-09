#!/usr/bin/env bash
set -euo pipefail

# Ce script doit être exécuté en tant que root
if [ "$(id -u)" -ne 0 ]; then
    echo "Erreur : ce script doit être exécuté en tant que root."
    exit 1
fi

# Variables
LAB_DIR="${HOME}/labs_materials"
SITE_CONF="/etc/apache2/sites-available/000-default.conf"
SSL_CONF="/etc/apache2/sites-available/default-ssl.conf"
CERT="/etc/ssl/certs/apache-selfsigned.crt"
KEY="/etc/ssl/private/apache-selfsigned.key"

# Installation non-interactive des dépendances
export DEBIAN_FRONTEND=noninteractive
apt-get update -qq
apt-get install -qq -y apache2 openssl

# Activation des modules Apache
a2enmod ssl rewrite

# Sauvegardes (si non existantes)
cp -n "$SITE_CONF" "${SITE_CONF}.bak"
cp -n "$SSL_CONF" "${SSL_CONF}.bak"

# Génération d'un certificat auto-signé si nécessaire
if [ ! -f "$CERT" ] || [ ! -f "$KEY" ]; then
    openssl req -x509 -nodes -days 365 \
        -newkey rsa:2048 \
        -keyout "$KEY" \
        -out "$CERT" \
        -subj "/CN=0.0.0.0"
fi

# Configuration HTTP
cat > "$SITE_CONF" <<EOF
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot "$LAB_DIR"

    <Directory "$LAB_DIR">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

# Configuration HTTPS
cat > "$SSL_CONF" <<EOF
<IfModule mod_ssl.c>
    <VirtualHost _default_:443>
        ServerAdmin webmaster@localhost
        DocumentRoot "$LAB_DIR"

        <Directory "$LAB_DIR">
            Options Indexes FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>

        ErrorLog \${APACHE_LOG_DIR}/error.log
        CustomLog \${APACHE_LOG_DIR}/access.log combined

        SSLEngine on
        SSLCertificateFile      $CERT
        SSLCertificateKeyFile   $KEY
    </VirtualHost>
</IfModule>
EOF

# Activation du site SSL et désactivation éventuelle d'autres
a2ensite default-ssl.conf
# Reload/restart Apache pour prendre en compte les changements
systemctl restart apache2

echo "✅ Apache sert désormais $LAB_DIR sur http://0.0.0.0/ et https://0.0.0.0/"
