<?php

require 'vendor/autoload.php';

use Aws\SecretsManager\SecretsManagerClient; 
use Aws\Credentials\CredentialProvider;
use Aws\Exception\AwsException;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\RejectedPromise;

// This function CREATES a credential provider
function getCredentials()
{
    // This function IS the credential provider
    return function () {
        // Use credentials from environment variables, if available
        return Promise\promise_for(
            new Aws\Credentials\Credentials(
                                getenv('AWS_ACCESS_KEY_ID'), 
                                getenv('AWS_SECRET_ACCESS_KEY'), 
                                getenv('AWS_SESSION_TOKEN')
                            )
        );
        $msg = 'Could not find environment variable ';
        return new RejectedPromise(new CredentialsException($msg));
    };
}

try {
    //get the AWS IAM key and secret from an environment variable 
    $awsCredentials = getCredentials();
    $client = new SecretsManagerClient([
        'version' => 'latest',
        'region' => getenv('AWS_REGION'),
        'credentials' => $awsCredentials
    ]);
} catch (AwsException $e) {
    //handle exception
    print($e);
}

try {
    $secretName = getenv('SECRET_NAME');
    $result = $client->getSecretValue([
        'SecretId' => $secretName,
    ]);

} catch (AwsException $e) {
    $error = $e->getAwsErrorCode();
    if ($error == 'DecryptionFailureException') {
        // Secrets Manager can't decrypt the protected secret text using the provided AWS KMS key.
        // Handle the exception here, and/or rethrow as needed.
        throw $e;
    }
    if ($error == 'InternalServiceErrorException') {
        // An error occurred on the server side.
        // Handle the exception here, and/or rethrow as needed.
        throw $e;
    }
    if ($error == 'InvalidParameterException') {
        // You provided an invalid value for a parameter.
        // Handle the exception here, and/or rethrow as needed.
        throw $e;
    }
    if ($error == 'InvalidRequestException') {
        // You provided a parameter value that is not valid for the current state of the resource.
        // Handle the exception here, and/or rethrow as needed.
        throw $e;
    }
    if ($error == 'ResourceNotFoundException') {
        // We can't find the resource that you asked for.
        // Handle the exception here, and/or rethrow as needed.
        throw $e;
    }
}
// Decrypts secret using the associated KMS CMK.
// Depending on whether the secret is a string or binary, one of these fields will be populated.
if (isset($result['SecretString'])) {
    $secret = $result['SecretString'];
} else {
    //ToDo: Explore
    $secret = base64_decode($result['SecretBinary']);
}

echo($secret."\n");

