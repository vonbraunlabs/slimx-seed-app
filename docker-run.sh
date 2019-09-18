#!/usr/bin/env bash

CWD=${CWD:-$(pwd "${0}")}

BASE_NAME=${1:-"backoffice"}

IMAGE_NAME="${BASE_NAME}-api"
NETWORK_NAME="${BASE_NAME}_dbnet"

CONTAINER_NAME="${IMAGE_NAME}-dev"
RESPONSE=$(docker inspect -f "{{.State.Running}}" "${CONTAINER_NAME}" 2>/dev/null)
RET=$?

if [ 1 -eq ${RET} ] || [ x'false' = x"${RESPONSE}" ]
then
    docker build --pull -t "${IMAGE_NAME}" -f ./Dockerfile-dev . \
    && docker run --rm -ti --network="${NETWORK_NAME}" -v "${CWD}":/opt --name "${CONTAINER_NAME}" -p 8877:8877 "${IMAGE_NAME}" /bin/bash
else
    docker exec -ti "${CONTAINER_NAME}" /bin/bash
fi
