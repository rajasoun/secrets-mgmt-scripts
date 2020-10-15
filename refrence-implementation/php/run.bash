#!/usr/bin/env bash

AWS_VAULT=
_AWS_PROFILE=cloud-admin
aws-vault --backend=file exec cloud-admin -- php GetSecret.php