# secrets-mgmt-scripts
AWS Secrets Management Scripts

## Getting started:

Make copy of the .env.example to .env and provide values

```
_AWS_PROFILE="cloud-admin"
_AWS_SECRET_STORE="api/secrets"
_AWS_SECRET_STORE_NAME_PATTERN="app/api/env"
```

To bash into the snap-shell docker (It has tools for aws-vault etc)

```
$ ./run.sh
```

Once inside the docker snap-shell for genric house keeping

```
$ cd /secrets-mgmt-scripts
$ ./assist.bash
```

Verify Refernce Impementation

```
$ ./run.bash
$ cd /secrets-mgmt-scripts/refrence-implementation/php/
$ ./setup.bash
$ ./run.bash
```
