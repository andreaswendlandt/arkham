
SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE engine = 'myisam';

echo "SELECT concat('ALTER TABLE ',TABLE_NAME,' ENGINE=InnoDB;') FROM Information_schema.TABLES WHERE ENGINE = 'MyISAM' AND TABLE_TYPE='BASE TABLE'" | mysql --defaults-file=/etc/mysql/debian.cnf >convert.sql
 
find /var/www/pg/import -type f -printf '%f\t%s\t\t%TY.%Tm.%Td\n' | numfmt --field=2 --to=iec-i
