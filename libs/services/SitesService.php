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
 * The MamboSitesService class handles all Site related requests
 * to the Mambo API.
 */
class MamboSitesService extends MamboBaseAbstract
{
	/**
	 * Site service end point URI
	 * @var string
	 */
	const SITES_URI = "/v1/sites";
	const SITES_ID_URI = "/v1/sites/{id}";
	const SITES_CLONE_URI = "/v1/sites/{id}/clone";
	
	
	/**
	 * This method is used to create a new site.
	 * 
	 * @param SiteRequestData siteRequestData	The data sent to the API in order to create a site
	 * @return
	 */
	public static function create( $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof SiteRequestData ) )
		{
			trigger_error( "The data should be of type SiteRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::SITES_URI, MamboClient::POST, 
				$data->getJsonString() );
	}
	
	
	/**
	 * Update an existing site by ID.
	 * 
	 * @param string id							The ID of the site to update
	 * @param SiteRequestData siteRequestData	The data with which to update the specified site object
	 * @return
	 */
	public static function update( $id, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof SiteRequestData ) )
		{
			trigger_error( "The data should be of type SiteRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getWithId( self::SITES_ID_URI, $id ), 
				MamboClient::PUT, $data->getJsonString() );
	}
	
	
	/**
	 * Clone an existing site by ID.
	 * 
	 * @param string id							The ID of the site to clone
	 * @param SiteRequestData siteRequestData	The data of the site into which we wish to clone
	 * @return
	 */
	public static function cloneSite( $id, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof SiteRequestData ) )
		{
			trigger_error( "The data should be of type SiteRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getWithId( self::SITES_CLONE_URI, $id ), 
				MamboClient::POST, $data->getJsonString() );
	}
	
	
	/**
	 * Delete a site by it's ID
	 * 
	 * @param string id				The ID of the site to delete
	 * @return
	 */
	public static function delete( $id )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getWithId( self::SITES_ID_URI, $id ), MamboClient::DELETE );
	}
	
	
	/**
	 * Delete a list of sites by their ID
	 * 
	 * @param string ids		The list of IDs of the behaviour to delete
	 * @return
	 */
	public static function deleteSites( $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof DeleteRequestData ) )
		{
			trigger_error( "The data should be of type DeleteRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::SITES_URI, MamboClient::DELETE, $data->getJsonString() );
	}
	
	
	/**
	 * Get a site by it's ID
	 * 
	 * @param string id			The ID of the site to retrieve
	 * @return
	 */
	public static function get( $id )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getWithId( self::SITES_ID_URI, $id ), MamboClient::GET );
	}
	
	
	/**
	 * Get the list of sites available
	 * @return
	 */
	public static function getSites()
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::SITES_URI, MamboClient::GET );
	}
}

?>