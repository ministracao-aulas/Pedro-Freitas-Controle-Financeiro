#!/bin/bash
###########
# Author: Tiago França | linkedin.com/in/tiago-php
# Date: 2024-01-27
##########

CURRENT_PATH=$(echo $(dirname "$(readlink -f "$0")"))

export DB_HOST='172.17.0..1'
export DB_PORT=1010
export DB_DATABASE=meu_banco
export DB_USERNAME=postgres
export DB_PASSWORD=postgres

export EXIT_ON_END=${EXIT_ON_END:-0}

export DIR_PATH_TO_SAVE=${CURRENT_PATH}/backups  ### mkdir -p ./backups

# bash "${CURRENT_PATH}/../../bin/db-backup.sh"
. "${CURRENT_PATH}/../../bin/db-backup.sh"

## Se existe a variável FILE_FULL_NAME e ela não é 'empty'
if [ -n "${FILE_FULL_NAME}" ]; then
    # echo "FILE_FULL_NAME: ${FILE_FULL_NAME}"
    ## Outras coisas aqui
fi
