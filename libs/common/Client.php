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
 * Fires the requests to the Mambo API. This class wraps the CURL
 * client with helper functions used to decode the responses from
 * the Mambo API as well as handle any Exceptions that may be returned.
 */
class MamboClient
{
	/**
	 * The PHP client version
	 * @var string
	 */
	const API_CLIENT_VERSION = '1.0.0';
	
	/**
	 * The default encoding used by the Client
	 * @var string
	 */
	const DEFAULT_ENCODING = 'UTF-8';
	
	/**
	 * HTTP method types
	 * @var string
	 */
	const GET = 'GET';
	const POST = 'POST';
	const PUT = 'PUT';
	const DELETE = 'DELETE';
	
	/**
	 * Whether debugging is enabled or disabled
	 * @var boolean
	 */
	public static $debug = false;

	/**
	 * API URL appended to the serverUrl
	 * @var string
	 */
	private static $apiUrlPath = "/api";
	
	/**
	 * The base URL of the API
	 * @var string
	 */
	private static $serverUrl = null;
	
	/**
	 * The API public key used to sign the requests
	 * @var string
	 */
	private static $publicKey = null;
	
	/**
	 * The API private key used to sign the requests
	 * @var string
	 */
	private static $privateKey = null;
	
	/**
	 * The accept language header value. Currently supported values are: en / pt
	 * @var string
	 */
	public static $acceptLanguage = "en";
	
	/**
	 * Determines whether the JSON should be decoded as an associative PHP array. 
	 * The default value is false and the JSON is returned as a PHP object.
	 * @var boolean
	 */
	public static $jsonDecodeAsArray = false;


	/**
	 * Updates the base portion of the URL.
	 * The default value is: https://api.mambo.io/api
	 * @param string baseUrl
	 */
	public static function setEndPointBaseUrl( $baseUrl )
	{
		if( strpos( $baseUrl, "http" ) !== 0 )
			trigger_error( "Please prefix the URL with the relevant protocol (e.g. https://)", E_USER_ERROR );

		self::$serverUrl = rtrim( $baseUrl, "/" ) . self::$apiUrlPath;
	}


	/**
	 * Set the Credentials to be used when calling the API
	 *
	 * @param string publicKey		The public key used to sign the requests to the Mambo API
	 * @param string privateKey	The private key used to sign the requests to the Mambo API
	 */
	public static function setCredentials( $publicKey, $privateKey )
	{
		self::$publicKey = $publicKey;
		self::$privateKey = $privateKey;
	}
	
	
	/**
  	 * Upload an Image to the Mambo.IO platform
	 * 
	 * @param string $uri		Target URI for this request (relative to the SERVER_URL)
	 * @param mixed $image		The image to be sent with the request
	 */
	public function upload( $uri, $image )
	{
		return self::doRequest( $uri, MamboClient::POST, null, $image );
	}
	
	
	/**
  	 * Send an HTTP request to the Mambo API
	 * 
	 * @param string $uri		Target URI for this request (relative to the SERVER_URL)
	 * @param string $method	Specifies the HTTP method to be used for this request
	 * @param mixed $data		The data to be sent with the request
	 */
	public function request( $uri, $method, $data = null )
	{
		return self::doRequest( $uri, $method, $data );
	}
	
	
	/**
  	 * Send an HTTP request to the Mambo API
	 * 
	 * @param string $uri		Target URI for this request (relative to the SERVER_URL)
	 * @param string $method	Specifies the HTTP method to be used for this request
	 * @param mixed $data		The data to be sent with the request
	 * @param mixed $image		The image to be sent with the request
	 */
	private function doRequest( $uri, $method, $data = null, $image = null )
	{
		// Make sure the credentials and URL are set
		if( self::$publicKey == null || self::$privateKey == null )
			trigger_error( "Before using the SDK you must set your API credentials using MamboClient->setCredentials()", E_USER_ERROR );
		
		if( self::$serverUrl == null )
			trigger_error( "Before using the SDK you must set the server URL using MamboClient->setEndPointBaseUrl()", E_USER_ERROR );
		
		// Set the default encoding
		if( function_exists( 'mb_internal_encoding' ) ) {
			mb_internal_encoding( self::DEFAULT_ENCODING );
		}
		
		// Get the fully qualified URL
		$url = $this->getUrl( $uri );
		
		// Debugging
		if( self::$debug ) {
			echo "------------------------\n";
			echo "Method: " . $method . "\n";
			echo "URL: " . $url . "\n";
			echo "Request: " . $data . "\n";
		}
		
		// Create the OAuth signature
		$consumer = new MamboOAuthConsumer( self::$publicKey, self::$privateKey );
		$request = MamboOAuthRequest::from_consumer_and_token( $consumer, null, $method, $url );
		$request->sign_request( new MamboOAuthSignatureMethod_HMAC_SHA1(), $consumer, null );
		
		// Debugging
		if( self::$debug ) {
			echo "OAuth details\n";
			echo "OAuth base_string: " . $request->get_signature_base_string() . "\n";
			echo "OAuth parameters:\n";
			var_dump( $request->get_parameters() );
		}
		
		// Get the cURL options
		$options = $this->getCurlOptions( $url, $method, $request->to_header(), $data, $image );
		
		// Execute the cURL request
		$response = $this->execRequest( $options );
		
		// Return the response
		return $response;
	}
	
	
	/**
	 * Executes the cURL request to the API
	 * 
	 * @param array $options	The cURL options used to make the request
	 * @return string
	 */
	private function execRequest( $options )
	{
		// Initialise and execute the request
		$conn = curl_init();
		curl_setopt_array( $conn, $options );
		$json = curl_exec( $conn );
		curl_close( $conn );
		
		// Debugging
		if( self::$debug ) {
			echo "Response: " . $json . "\n";
		}
		
		// Decode the json response
		return json_decode( $json, self::$jsonDecodeAsArray );
	}
	
	
	/**
	 * Initialise all the cURL options required to execute the request
	 * 
	 * @param string $url		Target URL for this request
	 * @param string $method	Specifies the HTTP method to be used for this request
	 * @param mixed $data		The data to be sent with the request
	 * @param mixed $image		The image to be sent with the request
	 * @return array
	 */
	private function getCurlOptions( $url, $method, $auth_header, $data, $image )
	{
		// The User-Agent
		$userAgent = 'User-Agent: Mambo/' . self::API_CLIENT_VERSION . '; PHP ' . phpversion();
		
		// Request content type
		$contentType = ( is_null( $image ) ) ? 'application/json' : 'multipart/form-data';
		
		// Initialise all the request headers
		$header = array( 'Content-Type: ' . $contentType . '; charset=' . self::DEFAULT_ENCODING,
						 'Accept: application/json',
						 'Accept-Language: ' . self::$acceptLanguage,
						 $auth_header );
		
		// Initialise the default cURL options
		$options = array( CURLOPT_HTTPHEADER => $header,
						CURLOPT_HEADER => false,
						CURLOPT_ENCODING => '',
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_SSL_VERIFYPEER => false,
						CURLOPT_SSL_VERIFYHOST => false,
						CURLOPT_FOLLOWLOCATION => false,
						CURLOPT_FAILONERROR => false,
						CURLOPT_MAXREDIRS => 1, 
						CURLOPT_CONNECTTIMEOUT => 20,
						CURLOPT_TIMEOUT => 45,
						CURLOPT_USERAGENT => $userAgent );
		
		// Configure the options based on the HTTP method
		if( $method == self::POST )
		{
			$postfields = $data;
			if( !is_null( $image ) ) {
				if( version_compare(phpversion(), '5.5.0', '>=') ) {
					$postfields = array( 'image' => new CURLFile( $image ) );
				} else {
					$postfields = array( 'image' => '@' . $image );
				}
			}
			
			$options[ CURLOPT_POST ] = true;
			$options[ CURLOPT_POSTFIELDS ] = $postfields;
		}
		else if( $method == self::PUT )
		{
			$options[ CURLOPT_CUSTOMREQUEST ] = 'PUT';
			$options[ CURLOPT_POSTFIELDS ] = $data;
		}
		else if( $method == self::DELETE )
		{
			$options[ CURLOPT_CUSTOMREQUEST ] = $method;
			
			if( !is_null( $data ) && !empty( $data ) )
				$options[ CURLOPT_POSTFIELDS ] = $data;
		}
		
		return $options;
	}
	
	
	/**
	 * Get the $uri and append it to the SERVER_URL
	 * 
	 * @param string $uri	The URI of the resource to connect to
	 * @return string 		The fully qualified URL used to connect to the API
	 */
	private function getUrl( $uri )
	{
		// Check the prefix is correct, otherwise add it
		if( !$this->startsWith( $uri, "/" ) )
		{
			$uri = "/" . $uri;
		}
		
		// Return the WebResource
		return self::$serverUrl . $uri;
	}
	
	
	/**
	 * Check whether the a string starts with a specific substring
	 * 
	 * @param string $haystack	The string that should start with the needle
	 * @param string $needle	The string with which the haystack should start
	 * @param string
	 */
	private function startsWith( $haystack, $needle )
	{
		$length = strlen( $needle );
		return ( substr( $haystack, 0, $length ) === $needle );
	}
}

?>