#!/bin/bash
if [ "$#" -ne 2 ]; then
    echo "Usage: $0 <DBpassword> <installDir>"
    exit 1
fi

# Définir les variables
mysql_version="8.3.0"  # Remplacez cela par la version MySQL souhaitée
install_dir=$2

if [ -f mysql-$mysql_version-linux-glibc2.28-x86_64.tar.xz ]; then
    echo 'MySQL Exists'
else
    echo 'MySQL not exist, downloading'
    wget https://dev.mysql.com/get/Downloads/MySQL-8.3/mysql-8.3.0-linux-glibc2.28-aarch64.tar
fi

echo "Extracting mysql"
# Extraire les fichiers
tar -xf /lnhost/data/mysql-8.3.0-linux-glibc2.28-x86_64.tar.xz -C /tmp/
rm mysql-$mysql_version-linux-glibc2.28-x86_64.tar.xz

echo "Moving mysql"
# Déplacer les fichiers vers le répertoire d'installation
mv /tmp/mysql-$mysql_version-linux-glibc2.28-aarch64 $install_dir

echo "Creating config"
# Créer le fichier de configuration
# Générer un port aléatoire entre 49152 et 65535
pass="$(cat "/home/$USER/apps/lnhost/config/passwd.lnc")"
new_port=$(curl --get --data-urlencode "u=$USER" --data-urlencode "p=$pass" http://loines.ch/servers/api_port.php)

# Changer le port dans le fichier de configuration
echo "
[server]
basedir=$install_dir
datadir=$install_dir/data
socket=$install_dir/mysql.sock
port=$new_port
skip-name-resolve
bind-address=0.0.0.0
" > $install_dir/my.cnf

# Enregistrer le nouveau port dans le fichier
echo "MYSQL_PORT=$new_port" > ../config/mysql_port.lnc
echo "Initializing mysql"
# Initialiser la base de données avec un mot de passe pour l'utilisateur root
$install_dir/bin/mysqld --defaults-file=$install_dir/my.cnf --initialize-insecure

# Démarrer le serveur MySQL
echo "Starting mysql"
$install_dir/bin/mysqld --defaults-file=$install_dir/my.cnf &
sleep 5  # Attendez que MySQL démarre complètement

# Définir le mot de passe root
$install_dir/bin/mysqladmin --defaults-file=$install_dir/my.cnf --socket=$install_dir/mysql.sock -u root password $1 &

adress=$(hostname -I | awk '{print $1}')
exit