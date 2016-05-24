<?php
/*
 * Copyright (C) 2014-2015 Mambo Solutions Ltd.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
/**
 * Validation file used to ensure that all the dependencies required in order to
 * use the Mambo PHP SDK are available.
 */

// Define EOL
define('PHP_BROWSER_EOL', "<br>\n");

// Perform the necessary checks
$php_ok = (function_exists('version_compare') && version_compare(phpversion(), '5.3.0', '>='));
$json_ok = (extension_loaded('json') && function_exists('json_encode') && function_exists('json_decode'));
$curl_ok = false;
if (function_exists('curl_version'))
{
	$curl_version = curl_version();
	$curl_ok = (function_exists('curl_exec') && in_array('https', $curl_version['protocols'], true));
}
$mbstring_ok = ( extension_loaded('mbstring') && function_exists( 'mb_internal_encoding' ) );

// Let the user know the results of the compatibility check
echo 'Mambo SDK for PHP' . PHP_BROWSER_EOL;
echo 'PHP Environment Compatibility Test' . PHP_BROWSER_EOL;
echo PHP_BROWSER_EOL;

echo 'PHP 5.3 or newer............ ' . ($php_ok ? ('Pass ' . phpversion()) : 'Fail') . PHP_BROWSER_EOL;
echo 'cURL with SSL............... ' . ($curl_ok ? ('Pass ' . $curl_version['version'] . ' (' . $curl_version['ssl_version'] . ')') : 'Fail ' . $curl_version['version'] . (in_array('https', $curl_version['protocols'], true) ? ' (with ' . $curl_version['ssl_version'] . ')' : ' (without SSL)')) . PHP_BROWSER_EOL;
echo 'JSON........................ ' . ($json_ok ? 'Pass' : 'Fail') . PHP_BROWSER_EOL;
echo 'mbstring.................... ' . ($mbstring_ok ? 'Pass' : 'Fail') . PHP_BROWSER_EOL;

echo PHP_BROWSER_EOL;

// Overall success or failure message
if ( $php_ok && $curl_ok && $json_ok )
{
	echo 'Your environment meets the minimum requirements for using the Mambo SDK for PHP' . PHP_BROWSER_EOL;
}
else
{
	echo 'Your PHP environment does not support the minimum requirements for the Mambo SDK for PHP.' . PHP_BROWSER_EOL;
	
	if( !$php_ok )
	{
		echo '* PHP: You are running an unsupported version of PHP.' . PHP_BROWSER_EOL . PHP_BROWSER_EOL;
	}
	if( !$curl_ok )
	{
		echo '* cURL: cURL support is not available. Without cURL, the SDK cannot connect to Mambo\'s API.' . PHP_BROWSER_EOL . PHP_BROWSER_EOL;
	}
	if( !$json_ok )
	{
		echo '* JSON: JSON support is not available. Mambo returns JSON for all of its services.' . PHP_BROWSER_EOL . PHP_BROWSER_EOL;
	}
	if( !$mbstring_ok )
	{
		echo '* mbstring: mbstring support is not available. Mambo needs this in order to encode data into UTF-8.' . PHP_BROWSER_EOL . PHP_BROWSER_EOL;
	}
}


?>