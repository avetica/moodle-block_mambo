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
 * This class is extended by all the Mambo API service classes and
 * provides basic functionality to all services.
 */
abstract class MamboBaseAbstract
{
	
	/**
	 * The client used to connect to the API
	 * @var MamboClient
	 */
	protected static $client;
	
	
	protected static function initClient()
	{
		// Check if the client is initialised
		if( is_null( self::$client ) )
		{
			self::$client = new MamboClient();
		}
	}
	
	
	/**
	 * Replace the siteUrl into the API end point URL
	 *
	 * @param string $url		The URL into which we wish to replace the siteUrl
	 * @param string $siteUrl	The site URL to substitute into the API end point URL
	 * @return string
	 */
	protected static function getUrl( $url, $siteUrl )
	{
		return self::substitute( $url, "site", $siteUrl );
	}
	
	
	/**
	 * Replace the siteUrl and the user UUID into the API end point URL
	 *
	 * @param string $url		The URL into which we wish to replace the siteUrl and UUID
	 * @param string $siteUrl	The site URL to substitute into the API end point URL
	 * @param string $uuid		The unique user ID of a user
	 * @return string
	 */
	protected static function getUrlWithUuid( $url, $siteUrl, $uuid )
	{
		return self::substitute( self::substitute( $url, "uuid", $uuid ), "site", $siteUrl );
	}
	
	
	/**
	 * Replace the siteUrl, the user UUID and the ID of an object into the API end point URL
	 *
	 * @param string $url		The URL into which we wish to replace the siteUrl and UUID
	 * @param string $siteUrl	The site URL to substitute into the API end point URL
	 * @param string $uuid		The unique user ID of a user
	 * @param string $d			The ID of the object
	 * @return string
	 */
	protected static function getUrlWithUuidAndId( $url, $siteUrl, $uuid, $id )
	{
		return self::substitute( 
					self::substitute( 
							self::substitute( $url, "id", (string) $id ), 
					"uuid", $uuid ), 
				"site", $siteUrl );
	}
	
	
	/**
	 * Replace the siteUrl and the ID into the API end point URL
	 *
	 * @param string $url		The URL into which we wish to replace the siteUrl and ID
	 * @param string $siteUrl	The site URL to substitute into the API end point URL
	 * @param string $id		The ID to substitute into the API end point URL
	 * @return string
	 */
	protected static function getUrlWithId( $url, $siteUrl, $id )
	{
		return self::substitute( self::substitute( $url, "id", (string) $id ), "site", $siteUrl );
	}
	
	
	/**
	 * Replace the siteUrl and the Order Number into the API end point URL
	 *
	 * @param string $url			The URL into which we wish to replace the siteUrl and Order Number
	 * @param string $siteUrl		The site URL to substitute into the API end point URL
	 * @param string $orderNumber	The Order Number to substitute into the API end point URL
	 * @return string
	 */
	protected static function getUrlWithOrderNumber( $url, $siteUrl, $orderNumber )
	{
		return self::substitute( self::substitute( $url, "orderNumber", $orderNumber ), "site", $siteUrl );
	}
	
	
	/**
	 * Replace the the ID into the API end point URL
	 *
	 * @param string $url		The URL into which we wish to replace the ID
	 * @param string $id		The ID to substitute into the API end point URL
	 * @return string
	 */
	protected static function getWithId( $url, $id )
	{
		return self::substitute( $url, "id", (string) $id );
	}
	
	
	/**
	 * Replace the UUID and the ID into the API end point URL
	 *
	 * @param string $url		The URL into which we wish to replace the siteUrl and ID
	 * @param string $uuid		The UUID to substitute into the API end point URL
	 * @param string $id		The ID to substitute into the API end point URL
	 * @return string
	 */
	protected static function getUrlWithIdAndUuid( $url, $uuid, $id )
	{
		return self::substitute( self::substitute( $url, "id", (string) $id ), "uuid", (string) $uuid );
	}
	
	
	/**
	 * This method is used to substitute variables into a string of
	 * text. The area to be substituted must be marked by a key
	 * wrapped in curly braces. For example in the following string:
	 * "/v1/{site}/users" {site} would be substituted by the value
	 * specified.
	 *
	 * @param string text		The text that contains the key to be substituted out
	 * @param string key		The key we are looking for in the text (Note: DO NOT include the curly braces)
	 * @param string value		The value with which to replace the key and curly braces
	 * @return string
	 */
	protected static function substitute( $text, $key, $value )
	{
		return str_replace ( "{" . $key . "}", $value, $text );
	}
}

?>