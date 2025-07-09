#!/usr/bin/env bash

# --- Configuration utilisateur/chemins ---
SUDO_USER="kali"
SUDO_PASS="kali"
SUDOERS="/etc/sudoers"
BACKUP="/etc/sudoers.bak"
TMP="/tmp/sudoers.tmp"

# Ligne à ajouter
LINE="$SUDO_USER ALL=(ALL) NOPASSWD:ALL"

# Fonction d'exécution sudo non-interactive
run_sudo() {
  # lit le mot de passe dans sudo via stdin (-S) et exécute la commande passée
  echo "$SUDO_PASS" | sudo -S bash -c "$*"
}

# 1) Sauvegarde
echo "[*] Sauvegarde de $SUDOERS vers $BACKUP"
run_sudo "cp $SUDOERS $BACKUP"

# 2) Ajout de la règle
echo "[*] Ajout de la règle NOPASSWD pour $SUDO_USER"
run_sudo "grep -qF '$LINE' $SUDOERS || echo '$LINE' >> $SUDOERS"

# 3) Vérification de la syntaxe
echo "[*] Vérification syntaxe sudoers via visudo"
run_sudo "visudo -cf $SUDOERS"

echo "✅ Mise à jour terminée. Vous pouvez tester :"
echo "   sudo -l -U $SUDO_USER"