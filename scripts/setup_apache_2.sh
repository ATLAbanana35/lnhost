#!/bin/bash

pass="$(cat "/home/$USER/apps/lnhost/config/passwd.lnc")"
new_port=$(curl --get --data-urlencode "u=$USER" --data-urlencode "p=$pass" http://loines.ch/servers/api_port.php)
echo "$new_port" > apachePort.txt
apps_dir="/home/$1/apps"
apache_conf_dir="/home/$1/apache2-conf"
apache_root="/home/$1/apache2"
apache_conf_file="$apache_conf_dir/apache.conf"

if [ -d "$apache_conf_dir" ]; then
  echo "Dir OK"
else
  echo "DIR NOT OK!"
  mkdir "$apache_conf_dir"
fi
if [ -d "$apache_root" ]; then
  echo "Dir OK"
else
  echo "DIR NOT OK!"
  mkdir "$apache_root"
  mkdir "$apache_root/logs"
fi

cp /usr/lib/apache2/modules $apache_root/modules -r

cat <<APACHE_CONF > "$apache_conf_file"
# my_apache.conf
IncludeOptional mods-enabled/*.load
IncludeOptional mods-enabled/*.conf
ServerRoot "$apache_root"
# LoadModule mpm_prefork_module modules/mod_mpm_prefork.so
LoadModule php_module modules/libphp8.1.so
Listen $new_port
PidFile "$apache_root/apache.pid"
<VirtualHost *:$new_port>
    DocumentRoot $apps_dir
    <Directory "$apps_dir">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted

    </Directory>
</VirtualHost>
APACHE_CONF

apache2 -k restart -f "$apache_conf_file"
