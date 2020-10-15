#!/usr/bin/env bash

source .env
AWS_VAULT=
aws-vault --backend=file exec $_AWS_PROFILE --no-session -- php GetCredentials.php
