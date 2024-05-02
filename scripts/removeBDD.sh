mysql_install_dir="/home/$2/mysql"
# Démarrer le serveur PHP intégré
address=$(hostname -I | awk '{print $1}')
databaseName="$3"
if [ -d $mysql_install_dir ]; then
    echo "MySQL ealready installed!"
    #!/bin/bash
    UP=$(ps aux | grep $mysql_install_dir/bin/mysqld | wc -l);
    if [ "$UP" = "1" ];
    then
        echo "MySQL is down, please start it with... '$mysql_install_dir/bin/mysqld --defaults-file=$mysql_install_dir/my.cnf &'";
        $mysql_install_dir/bin/mysqld --defaults-file=$mysql_install_dir/my.cnf &
        exit
    else
        echo "MySQL is started.";

    fi
else
    echo "ERROR! MYSQL IS NOT INSTALLED!"
    exit
fi
sleep 5
echo "Connextion à la dbb"
$mysql_install_dir/bin/mysql --socket=$mysql_install_dir/mysql.sock -u root -p"$1" <<MYSQL_SCRIPT
DROP DATABASE IF EXISTS $databaseName;
EXIT
MYSQL_SCRIPT


echo "XY__SH::EXIT::SH::XY"