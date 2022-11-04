echo "** Creating default DB and users"

mysql -u root -p$MYSQL_ROOT_PASSWORD --execute \
"CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE; 
GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* TO '$MYSQL_USER'@'%'; 
CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE_TEST; 
GRANT ALL PRIVILEGES ON $MYSQL_DATABASE_TEST.* TO '$MYSQL_USER'@'%'; 
DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"

echo "** Finished creating default DB, test DB and users"