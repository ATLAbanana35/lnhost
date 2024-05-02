#!/bin/bash
echo Ceating dirs and vars
if [ "$#" -ne 2 ]; then
    echo "Usage: $0 <MySQLDBpassword> <username>"
    exit 1
fi
install_dir="/home/$2/apps/kchat"
apps_install_dir="/home/$2/apps"
mysql_install_dir="/home/$2/mysql"
current_dir=$(pwd)
address=$(hostname -I | awk '{print $1}')
# Créer le répertoire d'installation des applications s'il n'existe pas
if [ ! -d "$apps_install_dir" ]; then
    mkdir -p "$apps_install_dir"
fi

# Créer le répertoire d'installation de Nextcloud s'il n'existe pas
if [ ! -d "$install_dir" ]; then
    mkdir -p "$install_dir"
fi
if [ -f kchat.zip ]; then
    echo 'KChat Exists'
else
    echo 'KChat not exist, downloading'
    wget https://loines.ch/api/lnhost/apps/kchat.zip
fi

echo copying nextcloud latest
# Copier les fichiers nécessaires
unzip kchat.zip -d $install_dir
rm kchat.zip
cd $install_dir
composer install
cd "$current_dir"
# Aller dans le répertoire d'installation de Nextcloud
echo starting mysql
# Exécuter le script de configuration MySQL en arrière-plan
if [ -d $mysql_install_dir ]; then
    echo "MySQL ealready installed!, but you should run setup_part2"
    #!/bin/bash
    UP=$(ps aux | grep $mysql_install_dir/bin/mysqld | wc -l);
    if [ "$UP" = "1" ];
    then
        echo "MySQL is down, starting...";
        $mysql_install_dir/bin/mysqld --defaults-file=$mysql_install_dir/my.cnf &
        sleep 5
        exit
    else
        echo "MySQL is started.";
    fi
else
    ./setup_mysql.sh $1 $mysql_install_dir
fi

# echo "Server started at $address:8080"
echo "XY__SH::EXIT::SH::XY"