#!/usr/bin/env bash
set -euo pipefail

# Ce script configure un serveur FTP (vsftpd) et SMB (Samba)
# Serveurs accessibles anonymement ou avec l'utilisateur kali:kali
# Fournit accès en lecture/écriture au dossier /home/kali/labs_materials
# Tout est non-interactif.

# Doit être exécuté en root
if [ "$(id -u)" -ne 0 ]; then
    echo "Erreur : le script doit être exécuté en root."
    exit 1
fi

LAB_DIR="/home/kali/labs_materials"
FTP_SHARE="/var/shares/ftp"
SMB_SHARE="/var/shares/smb"

# Installation non interactive
export DEBIAN_FRONTEND=noninteractive
apt-get update -qq
apt-get install -y -qq vsftpd samba smbclient

# Création des répertoires de partage
mkdir -p "$FTP_SHARE" "$SMB_SHARE"
ln -sfn "$LAB_DIR" "$FTP_SHARE/labs_materials"
ln -sfn "$LAB_DIR" "$SMB_SHARE/labs_materials"
chmod -R 0777 "$FTP_SHARE" "$SMB_SHARE"

# Sauvegarde des configurations si non existantes
cp -n /etc/vsftpd.conf /etc/vsftpd.conf.bak
cp -n /etc/samba/smb.conf /etc/samba/smb.conf.bak

# Configuration vsftpd
cat > /etc/vsftpd.conf <<EOF
listen=YES
listen_ipv6=NO
anonymous_enable=YES
anon_root=$FTP_SHARE
anon_upload_enable=YES
anon_mkdir_write_enable=YES
local_enable=YES
write_enable=YES
local_root=$FTP_SHARE
chroot_local_user=YES
allow_writeable_chroot=YES
pasv_enable=NO
EOF

# Restart vsftpd
systemctl restart vsftpd

# Création et configuration de l'utilisateur kali
if ! id -u kali &>/dev/null; then
    useradd -m -s /bin/bash kali
fi
echo "kali:kali" | chpasswd

# Configuration Samba
cat >> /etc/samba/smb.conf <<EOF

[labsshare]
   path = $SMB_SHARE
   browsable = yes
   writable = yes
   guest ok = yes
   guest only = no
   valid users = kali
   force user = kali
   create mask = 0777
   directory mask = 0777
EOF

# Ajout de l'utilisateur Samba non-interactif
(echo "kali"; echo "kali") | smbpasswd -s -a kali

# Restart Samba services
systemctl restart smbd nmbd

# Affichage des commandes Windows pour montée du share SMB
echo ""
echo "Pour connecter le share SMB depuis Windows (PowerShell ou cmd) :"
echo "  net use Z: \\\\<REMOTE_ADDRESS>\\labsshare /user:kali kali"
echo "  (ou pour accès anonyme) : net use Z: \\\\<REMOTE_ADDRESS>\\labsshare"
