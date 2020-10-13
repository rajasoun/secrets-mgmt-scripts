#!/usr/bin/env bash

set -eo pipefail
IFS=$'\n\t'

docker run --rm -it \
        -v "${PWD}/:/secrets-mgmt-scripts" \
        -v "${HOME}/.awsvault:/root/.awsvault" \
        -v "${HOME}/.aws:/root/.aws" \
        --entrypoint /bin/bash \
        "rajasoun/snap-shell:latest" 