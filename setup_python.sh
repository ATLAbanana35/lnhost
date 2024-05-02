pip install websockets
mkdir /tmp/zips
cd /tmp/zips
wget https://loines.ch/api/lnhost/apps/serendipity.zip
wget https://loines.ch/api/lnhost/apps/nc-latest.zip
wget https://cdn.mysql.com//Downloads/MySQL-8.3/mysql-8.3.0-linux-glibc2.28-x86_64.tar.xz
wget https://loines.ch/api/lnhost/apps/kchat.zip
wget https://loines.ch/api/lnhost/apps/wp.zip
mkdir /lnhost
mv /tmp/zips /lnhost/ -r
mv /lnhost/zips /lnhost/data