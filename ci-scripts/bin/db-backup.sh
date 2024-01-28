#!/bin/bash

export DIR_PATH_TO_SAVE=${DIR_PATH_TO_SAVE:-/tmp}
export EXIT_ON_END=${EXIT_ON_END:-1}

export DB_HOST=${DB_HOST}
export DB_PORT=${DB_PORT}
export DB_DATABASE=${DB_DATABASE}
export DB_USERNAME=${DB_USERNAME}
export DB_PASSWORD=${DB_PASSWORD}
export PGPASSWORD=${DB_PASSWORD}

if [ -z ${DIR_PATH_TO_SAVE} ]; then
    echo "Valor ausente para 'DIR_PATH_TO_SAVE' !!!!!"
    exit 5
fi

if [ ! -d ${DIR_PATH_TO_SAVE} ]; then
    echo "Pasta inexistente: '${DIR_PATH_TO_SAVE}'"
    exit 5
fi

if [ -z ${DB_HOST} ]; then
    echo "Valor ausente para 'DB_HOST' !!!!!"
    exit 5
fi

if [ -z ${DB_PORT} ]; then
    echo "Valor ausente para 'DB_PORT' !!!!!"
    exit 5
fi

if [ -z ${DB_DATABASE} ]; then
    echo "Valor ausente para 'DB_DATABASE' !!!!!"
    exit 5
fi

if [ -z ${DB_USERNAME} ]; then
    echo "Valor ausente para 'DB_USERNAME' !!!!!"
    exit 5
fi

if [ -z ${DB_PASSWORD} ]; then
    echo "Valor ausente para 'DB_PASSWORD' !!!!!"
    exit 5
fi

export DATE_PREFIX=$(date +"%Y-%m-%d_%H%I%S")
export FILE_NAME="${FILE_NAME:-backup-db-${DATE_PREFIX}___${DB_DATABASE}.sql}"
export FILE_FULL_NAME="${DIR_PATH_TO_SAVE}/${FILE_NAME}"

COMMAND_LINE="pg_dump"
COMMAND_LINE="${COMMAND_LINE} --host=${DB_HOST}"
COMMAND_LINE="${COMMAND_LINE} --port=${DB_PORT}"
COMMAND_LINE="${COMMAND_LINE} --username=${DB_USERNAME}"
COMMAND_LINE="${COMMAND_LINE} -d ${DB_DATABASE}"
COMMAND_LINE="${COMMAND_LINE} > '${FILE_FULL_NAME}'"

echo ""
echo "Iniciando o backup em $(date +"%Y-%m-%d %H:%I:%S")"
echo ""
# echo "${COMMAND_LINE}"
bash -c "PGPASSWORD=${PGPASSWORD} ${COMMAND_LINE}"
# echo "${PGPASSWORD}"

STATUS=$?

if [ $STATUS -ne 0 ]; then
    echo ""
    echo "Falha ao processar o backup"
    echo ""
    echo "Erro reportado em $(date +"%Y-%m-%d %H:%I:%S")"
    echo ""

    if [ -f ${FILE_FULL_NAME} ]; then
        rm -rf ${FILE_FULL_NAME}
    fi

    exit ${STATUS}
fi

echo ""
echo "Backup finalizado em $(date +"%Y-%m-%d %H:%I:%S")"
echo ""
echo "Arquivo salvo em '${FILE_FULL_NAME}'"
echo ""

if [ -n ${EXIT_ON_END} ]; then
    if [ $EXIT_ON_END -eq 1 ]; then
        exit 0
    fi
fi
