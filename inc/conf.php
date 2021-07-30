<?php
/**
 * @copyright Copyright 2020, Schoolbox Pty Ltd
 * @link      https://schoolbox.com.au/
 */

/* Really simple script to read configuration from environment files.
 * TODO: Upgrade to something like https://github.com/vlucas/phpdotenv
 */
define('WEB_ROOT', dirname($_SERVER['DOCUMENT_ROOT']));

// parse config from environment files
$envFileDefault = WEB_ROOT . DIRECTORY_SEPARATOR . '.env.defaults';  // Must exist
$envFileCustom  = WEB_ROOT . DIRECTORY_SEPARATOR . '.env';           // May exist
if(!file_exists($envFileDefault)){
    die('.env file not found');
}

$environmentConfig = parseConfigFromEnvFile($envFileDefault);
if(file_exists($envFileCustom)){
    $environmentConfig = array_merge($environmentConfig, parseConfigFromEnvFile($envFileCustom));
}
function parseConfigFromEnvFile($filename){
    $data = [];
    foreach (explode("\n", file_get_contents($filename)) as $line){
        $trimmed = trim($line);
        if($trimmed && strpos($trimmed, '#') !== 0){
            $keyAndVal = explode('=', trim($line), 2);
            $data[$keyAndVal[0]] = $keyAndVal[1];
        }
    }
    return $data;
}

/**
 * Returns the value of an environment variable.
 *
 * If not defined, emits a user warning, and returns NULL
 *
 * @param string $name
 * @return null|string
 */
function env($name)
{
    global $environmentConfig;
    if(!array_key_exists($name, $environmentConfig)){
        trigger_error("Config '$name' not defined", E_USER_WARNING);
    }
    return array_key_exists($name, $environmentConfig) ? $environmentConfig[$name] : null;
}






