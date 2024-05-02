apache_conf_dir="/home/$1/apache2-conf"
apache_conf_file="$apache_conf_dir/apache.conf"

if [ -d $apache_conf_dir ]; then
  echo "Apache conf already installed in $apache_conf_dir"
  apache2 -k restart -f "$apache_conf_file"
  exit
else
  echo "Apache not installed, running setup"
  ./setup_apache_2.sh $1
fi

