## alias pour le script d'inventaire de la stack

alias update-stack='bash ~/hopital_symfony/stack-info.sh' #--update la stack-info dans le fichier stack-info.txt
alias dcu="docker compose --env-file .env.local up -d" #--build pour reconstruire les images à chaque lancement
alias dcub="docker compose --env-file .env.local up -d --build" #--build pour reconstruire les images à chaque lancement
alias dcd="docker compose --env-file .env.local down -v" #pour arrêter les conteneurs et supprimer les volumes associés
alias php-csfix="./vendor/bin/php-cs-fixer fix" #--dry-run pour voir les changements en les appliquer
alias php-cscheck="./vendor/bin/php-cs-fixer check" #--diff pour voir les changements sans les appliquer ( pour l'instant ne fontionne pas )
alias phpstancheck='./vendor/bin/phpstan analyse' #--analyse pour vérifier le code sans appliquer les changements  ( pour l'instant ne fontionne pas )
