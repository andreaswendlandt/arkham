#!/bin/bash
# author: andreaswendlandt
# last modified: 31.8.2017
# desc: some crazy-fancy-awesome stuff
                                                                                                                                                                                                            
mysql_root_pw=$(cat /root/.mysql_root_pw)
controlfile="/opt/help_date"
                                                                                                                                                                                                            
while true; do
    read -p "Bitte geben Sie ein ob die neue Hilfe von heute ist(now) oder geben Sie die Anzahl von Tagen ein 
wann die Hilfe erstellt wurde 'now/Zahl': " wert_cur_int
    if [[ "$wert_cur_int" = "now" ]]; then
        cur_date=$(date +%Y%m%d)
        break
    elif [[ "$wert_cur_int" = [[:digit:]]* ]]; then
        cur_date=$(date --date="$wert_cur_int days ago" +%Y%m%d)
        break
    else
        echo "Keine valide Antwort erhalten, bitte antworten Sie mit einer Zahl oder mit 'now'!"
        continue
    fi
done

if [ -s $controlfile ]; then
    old_date=$(cat $controlfile)
else
    while true; do
    read -p "Es gibt keine Datei $controlfile oder sie ist leer, bitte geben Sie ein ob es noch keine Hilfe gibt(never) oder geben Sie die Anzahl von Tagen ein wann die Hilfe
 zum letzten Mal aktualisiert wurde 'never/14': " wert_old_int
    if [[ "$wert_old_int" = "never" ]]; then
        old_date="never"
        break
    elif [[ "$wert_old_int" = [[:digit:]]* ]]; then
        old_date=$(date --date="$wert_old_int days ago" +%Y%m%d)
        break
    else
        echo "Keine valide Antwort erhalten, bitte antworten Sie mit einer Zahl oder mit 'never'!"
        continue
    fi
done
fi

if ! mount | grep "/mnt/smbshare" >/dev/null 2>&1; then
    if ! mount samba:/data/smbshare /mnt/smbshare/ >/dev/null; then 
        echo "Konnte /mnt/smbshare nicht mounten und breche deshalb ab"
        exit 1
    fi
fi

if ! ls /mnt/smbshare/sources/_packages/help/help_${cur_date}_{de,en}.zip >/dev/null 2>&1; then
    echo "Die neuen Hilfeseiten sind noch nicht hinterlegt auf dem Share, breche deshalb ab"
    exit 1
fi

mkdir /opt/help_{de,en}_${cur_date}
unzip /mnt/smbshare/sources/_packages/help/help_${cur_date}_en.zip -d /opt/help_en_${cur_date} 
unzip /mnt/smbshare/sources/_packages/help/help_${cur_date}_de.zip -d /opt/help_de_${cur_date}

if ! [ -L help_de ]; then
    cp /opt/help_de/configuration.php /opt/help_de_${cur_date}/
fi

if ! [ -L help_en ]; then
    cp /opt/help_en/configuration.php /opt/help_en_${cur_date}/
fi

# datenbanken anlegen und evtl. die configuration.php ändern(nur im fall dass der benutzer datenbanken mit datumstring anlegt)
while true; do
    read -p "Sollen neue Datenbanken mit Zeitstempel im Namen angelegt werden? [ja/nein]: " wert_db
    if [ "$wert_db" = "ja" ]; then
        mysql -u root -p$mysql_root_pw -e "CREATE DATABASE help_de_${cur_date}; CREATE DATABASE help_en_${cur_date};"
        mysql -u root -p$mysql_root_pw help_de_${cur_date} < /opt/help_de_${cur_date}/help.sql
        mysql -u root -p$mysql_root_pw help_en_${cur_date} < /opt/help_en_${cur_date}/help.sql
        if [[ "$old_date" = [[:digit:]]* ]]; then
            cp /opt/help_de_${old_date}/configuration.php /opt/help_de_${cur_date}/
            cp /opt/help_en_${old_date}/configuration.php /opt/help_en_${cur_date}/
            sed -i "s/${old_date}/${cur_date}/g" /opt/help_de_${cur_date}/configuration.php
            sed -i "s/${old_date}/${cur_date}/g" /opt/help_en_${cur_date}/configuration.php
        fi
        break
    elif [ "$wert_db" = "nein" ]; then
        mysql -u root -p$mysql_root_pw -e "DROP DATABASE help_de; DROP DATABASE help_en;"
        mysql -u root -p$mysql_root_pw -e "CREATE DATABASE help_de; CREATE DATABASE help_en;"
        mysql -u root -p$mysql_root_pw help_de < /opt/help_de_${cur_date}/help.sql
        mysql -u root -p$mysql_root_pw help_en < /opt/help_en_${cur_date}/help.sql
        break
    else
        echo "keine valide Antwort erhalten, bitte antworten Sie mit ja oder nein"
        continue
    fi
done

# neue englische Hilfe anlegen
while true; do
    read -p "Soll die englische Hilfe gelöscht und neu angelegt werden? [ja/nein]: " wert_en
    if [ "$wert_en" = "ja" ]; then
        rm -rf /opt/help_en && ln -s /opt/help_en_${cur_date} /opt/help_en
	break
    elif [ "$wert_en" = "nein" ]; then
        echo "Es wird nichts verändert für die englische Hilfe"
	break
    else
        echo "keine valide Antwort erhalten, bitte antworten Sie mit ja oder nein"
	continue
    fi
done

# neue deutsche Hilfe anlegen
while true; do
    read -p "Soll die deutsche Hilfe gelöscht und neu angelegt werden? [ja/nein]: " wert_de
    if [ "$wert_de" = "ja" ]; then
        rm -rf /opt/help_de && ln -s /opt/help_de_${cur_date} /opt/help_de
        break
    elif [ "$wert_de" = "nein" ]; then
        echo "Es wird nichts verändert für die deutsche Hilfe"
        break
    else
        echo "keine valide Antwort erhalten, bitte antworten Sie mit ja oder nein"
        continue
    fi
done


# die alte Hilfe endgültig löschen
while true; do
    read -p "Bitte prüfen Sie ob die neue Hilfe funktioniert, soll die alte Hilfe(englisch und deutsch) gelöscht werden? [ja/nein]: " wert_rm
    if [ "$wert_rm" = "ja" ]; then
        if [[ "$old_date" = [[:digit:]]* ]]; then
             rm -rf /opt/help_{en,de}_${old_date}/ && mysql -p$mysql_root_pw -e "DROP DATABASE help_de_${old_date}; DROP DATABASE help_en_${old_date}" && echo "alte Hilfe(deutsch und englisch) wurde gelöscht"
        else
            echo "Keine alte Hilfe vorhanden, es wird nichts gelöscht!!!"
        fi
        break
    elif [ "$wert_rm" = "nein" ]; then
        if [[ "$old_date" = [[:digit:]]* ]]; then
            echo "Die alte Hilfe wird nicht gelöscht und ist weiterhin unter /opt/help_{de,en}_${old_date} zu finden"
        else
            echo "Keine alte Hilfe vorhanden, es wird nichts gelöscht!!!"
        fi
        break
    else
        echo "keine valide Antwort erhalten, bitte antworten Sie mit ja oder nein"
        continue
    fi
done

echo $cur_date > $controlfile
unset mysql_root_pw
umount /mnt/smbshare
