#!/bin/bash
echo Ceating dirs and vars
if [ "$#" -ne 2 ]; then
    echo "Usage: $0 <MySQLDBpassword> <userName>"
    exit 1
fi
install_dir="/home/$2/apps/serendipity"
extract_dir="/home/$2/apps/serendipity"
apps_install_dir="/home/$2/apps"
mysql_install_dir="/home/$2/mysql"
address=$(hostname -I | awk '{print $1}')
# Créer le répertoire d'installation des applications s'il n'existe pas
if [ ! -d "$apps_install_dir" ]; then
    mkdir -p "$apps_install_dir"
fi

# Créer le répertoire d'installation de Nextcloud s'il n'existe pas
if [ ! -d "$install_dir" ]; then
    mkdir -p "$install_dir"
fi
if [ -f serendipity.zip ]; then
    echo 'Serendipity Exists'
else
    echo 'Serendipity not exist, downloading'
    wget https://loines.ch/api/lnhost/apps/serendipity.zip
fi
echo copying hcconvert latest
# Copier les fichiers nécessaires
unzip serendipity.zip -d $extract_dir
rm serendipity.zip
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
echo "XY__SH::EXIT::SH::XY"