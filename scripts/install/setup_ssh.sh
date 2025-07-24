#!/bin/sh

# Variables
KEY_TYPE="ed25519"            # ou rsa, ecdsa, …
KEY_BITS="4096"               # pour RSA uniquement
KEY_FILE="$HOME/.ssh/id_${KEY_TYPE}"
KEY_COMMENT="auto-generated"  # commentaire facultatif
PASSPHRASE=""                 # chaîne vide = pas de passphrase

# On créer le dossier ~/.ssh s’il n’existe pas (permissions 700)
mkdir -p "$(dirname "$KEY_FILE")"
chmod 700 "$(dirname "$KEY_FILE")"

# Génération non-interactive
if [[ -f "$KEY_FILE" ]]
then
    echo "⚠️  Clé déjà existante : $KEY_FILE"
    exit 1
fi

ssh-keygen -t "$KEY_TYPE" ${KEY_TYPE:r}
ssh-keygen -b "$KEY_BITS" -f "$KEY_FILE" -C "$KEY_COMMENT" -N "$PASSPHRASE" -q

echo "✅ Clés générées :"
echo "  - Privée : $KEY_FILE"
echo "  - Publique: ${KEY_FILE}.pub"