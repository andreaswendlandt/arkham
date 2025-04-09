#!/bin/bash
update_all_repos(){
    if [[ $# -ne 1 ]]; then
        echo "error: one parameter must be passed, the directory with the repos"
	return 1
    fi
    find "${1}" -type d -name '.git' | while read -r dir; do
        repo=${dir%%.git}
        if git -C "${repo}" rev-parse --is-inside-work-tree >/dev/null 2>&1; then
            echo "${repo}"
            if ! git -C "${repo}" pull 2>/dev/null; then
	        echo "check your branch, it seems there are no tracking information available"
	    fi
        else
            echo "${repo} is not a git repo..."
        fi
    done
}
