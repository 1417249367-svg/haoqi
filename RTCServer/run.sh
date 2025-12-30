service apache2 restart
cd /home/data/RTCServer
pm2 start processes.json
cd /home/data/KeFu-master
pm2 start bin/www --name kefu