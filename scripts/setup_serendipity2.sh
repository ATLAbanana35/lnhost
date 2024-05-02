app_install_dir="/home/$2/apps/serendipity"
mysql_install_dir="/home/$2/mysql"

echo starting php
# Démarrer le serveur PHP intégré
address=$(hostname -I | awk '{print $1}')
databaseName='serendiplitydb'
databasePassword='password'
if [ -d $mysql_install_dir ]; then
    echo "MySQL ealready installed!"
    #!/bin/bash
    UP=$(ps aux | grep $mysql_install_dir/bin/mysqld | wc -l);
    if [ "$UP" = "1" ];
    then
        echo "MySQL is down, please start it with... '$mysql_install_dir/bin/mysqld --defaults-file=$mysql_install_dir/my.cnf &'";
        exit
    else
        echo "MySQL is started.";
        echo "Connextion à la dbb"
            echo "Création de la base de données et de l'utilisateur..."
        $mysql_install_dir/bin/mysql --socket=$mysql_install_dir/mysql.sock -u root -p"$1" <<MYSQL_SCRIPT
CREATE DATABASE IF NOT EXISTS $databaseName;
CREATE USER 'root'@'%' IDENTIFIED BY '$1';
grant all privileges on *.* to 'root'@'%' with grant option;
FLUSH PRIVILEGES;
EXIT
MYSQL_SCRIPT
address=$(hostname -I | awk '{print $1}')
mysql_port_file="../config/mysql_port.lnc"

# Extraire la valeur du port du fichier mysql_port.lnc
db_port=$(cat "$mysql_port_file")


echo "
USER: root,
ADRESS:$address:$db_port
PASSWORD:DEFINED
SOCKET:$mysql_install_dir/mysql.sock
CONFIG:$mysql_install_dir/my.cnf
DATABASE_NAME:$databaseName
" > serendipityBDD.txt
echo "
USER: root,
ADRESS:$address:$db_port
PASSWORD:DEFINED
SOCKET:$mysql_install_dir/mysql.sock
CONFIG:$mysql_install_dir/my.cnf
DATABASE_NAME:$databaseName
PLEASE RUN SETUP_PART_2!
"
    fi
else
    echo "ERROR! MYSQL IS NOT INSTALLED!"
    exit
fi

echo starting apache

bash start_apache2.sh $2
echo "XY__SH::EXIT::SH::XY"