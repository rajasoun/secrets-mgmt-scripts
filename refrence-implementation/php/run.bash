#!/usr/bin/env bash

source .env
AWS_VAULT=
_AWS_PROFILE=cloud-admin
aws-vault --backend=file exec cloud-admin -- php GetCredentials.php