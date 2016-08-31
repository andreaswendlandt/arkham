folder_sync () 
{ 
    backup_folder=$1;
    user_folder=$2;
    if [ -z "$backup_folder" -o -z "$user_folder" ]; then
        echo "error, you need to provide 2 parameters";
        return 1;
    else
        ls -1 $backup_folder | grep -v roaming | while read a; do
            set $a;
            if [ $# -eq 2 ]; then
                cp -a -r ${backup_folder}/$1\ $2 $user_folder;
            else
                cp -a -r ${backup_folder}/$@ $user_folder;
            fi;
        done;
    fi
}
