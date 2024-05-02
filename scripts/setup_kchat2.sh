if [ "$#" -ne 2 ]; then
    echo "Usage: $0 <MySQLDBpassword> <userName>"
    exit 1
fi
kchat_install_dir="/home/$2/apps/kchat"
apps_dir="/home/$2/apps"
mysql_install_dir="/home/$2/mysql"
install_dir="/home/$2/mysql"
address=$(hostname -I | awk '{print $1}')
databaseName='kchatdb'
databaseUser='kchatuser'
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
        $install_dir/bin/mysql --socket=$install_dir/mysql.sock -u root -p"$1" <<MYSQL_SCRIPT
CREATE DATABASE IF NOT EXISTS $databaseName;
CREATE USER 'root'@'%' IDENTIFIED BY '$1';
grant all privileges on *.* to 'root'@'%' with grant option;
FLUSH PRIVILEGES;
EXIT
MYSQL_SCRIPT

cat <<HTACCESS > "$apps_dir/.htaccess"
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ /kchat/public%{REQUEST_URI} [L]
</IfModule>

HTACCESS

mysql_port_file="../config/mysql_port.lnc"

# Extraire la valeur du port du fichier mysql_port.lnc
db_port=$(cat "$mysql_port_file")


cat <<EOF > "$kchat_install_dir/.env"
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=$address
DB_PORT=$db_port
DB_DATABASE=kchatdb
DB_USERNAME=root
DB_PASSWORD=$1

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="\${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="\${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="\${PUSHER_HOST}"
VITE_PUSHER_PORT="\${PUSHER_PORT}"
VITE_PUSHER_SCHEME="\${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="\${PUSHER_APP_CLUSTER}"
EOF
php $kchat_install_dir/artisan key:generate
php $kchat_install_dir/artisan migrate

echo "
USER:root,
ADRESS:$address:$db_port
PASSWORD:DEFINED
SOCKET:$install_dir/mysql.sock
CONFIG:$install_dir/my.cnf
DATABASE_NAME:$databaseName
" > kchatBDD.txt
echo "
USER:root,
ADRESS:$address:$db_port
PASSWORD:DEFINED
SOCKET:$install_dir/mysql.sock
CONFIG:$install_dir/my.cnf
DATABASE_NAME:$databaseName
PLEASE RUN SETUP_PART_2!
"
    fi
else
    echo "ERROR! MYSQL IS NOT INSTALLED!"
    exit
fi



echo starting apache

./start_apache2.sh $2
echo "XY__SH::EXIT::SH::XY"