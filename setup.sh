read -p "Enter like-> dbname username password: " db user pass
PGPASSWORD=$pass psql -h mcsdb.utm.utoronto.ca -d $db -U $user -f db
php index.php $db $user $pass 
