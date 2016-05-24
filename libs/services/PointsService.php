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
 * The MamboPointsService class handles all Point related requests
 * to the Mambo API.
 */
class MamboPointsService extends MamboBaseAbstract
{
	/**
	 * Point service end point URI
	 * @var string
	 */
	const POINTS_URI = "/v1/points";
	const POINTS_ID_URI = "/v1/points/{id}";
	const POINTS_IMAGE_URI = "/v1/points/{id}/image";

	const POINTS_SITE_URI = "/v1/{site}/points";
	const INTERNAL_POINTS_SITE_URI = "/v1/{site}/points/internal";
	const EXTERNAL_POINTS_SITE_URI = "/v1/{site}/points/external";
	
	
	/**
	 * This method is used to create a new point.
	 * 
	 * @param string siteUrl				The site to which the point belongs to
	 * @param PointRequestData data		The data sent to the API in order to create a point
	 * @return
	 */
	public static function create( $siteUrl, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof PointRequestData ) )
		{
			trigger_error( "The data should be of type PointRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getUrl( self::POINTS_SITE_URI, $siteUrl ), 
				MamboClient::POST, $data->getJsonString() );
	}
	
	
	/**
	 * Update an existing point by ID.
	 * 
	 * @param string id					The ID of the point to update
	 * @param PointRequestData data	The data with which to update the specified point object
	 * @return
	 */
	public static function update( $id, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof PointRequestData ) )
		{
			trigger_error( "The data should be of type PointRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getWithId( self::POINTS_ID_URI, $id ), 
				MamboClient::PUT, $data->getJsonString() );
	}
	
	
	/**
	 * Upload an image for the point
	 * 
	 * @param string id		The point for which to upload the image
	 * @param data image 	The image to upload for the point
	 * @return
	 */
	public static function uploadImage( $id, $image )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( is_null( $image ) || empty( $image ) )
		{
			trigger_error( "The image must not be empty", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->upload( self::getWithId( self::POINTS_IMAGE_URI, $id ), $image );
	}
	
	
	/**
	 * Delete a point by it's ID
	 * 
	 * @param string id				The ID of the point to delete
	 * @return
	 */
	public static function delete( $id )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getWithId( self::POINTS_ID_URI, $id ), MamboClient::DELETE );
	}
	
	
	/**
	 * Delete a list of points by their ID
	 * 
	 * @param string ids		The list of IDs of the point to delete
	 * @return
	 */
	public static function deletePoints( $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof DeleteRequestData ) )
		{
			trigger_error( "The data should be of type DeleteRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::POINTS_URI, MamboClient::DELETE, $data->getJsonString() );
	}
	
	
	/**
	 * Get a point by it's ID
	 * 
	 * @param string id			The ID of the point to retrieve
	 * @return
	 */
	public static function get( $id )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getWithId( self::POINTS_ID_URI, $id ), MamboClient::GET );
	}
	
	
	/**
	 * Get the list of points for the specified site
	 * 
	 * @param string $siteUrl	The site for which to retrieve the list of points
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @return
	 */
	public static function getPoints( $siteUrl, $tags = null, $tagUuid = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::POINTS_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the list of external points (i.e. points which are not marked as internalOnly) for the specified site
	 * 
	 * @param string $siteUrl	The site for which to retrieve the list of points
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @return
	 */
	public static function getExternalPoints( $siteUrl, $tags = null, $tagUuid = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::EXTERNAL_POINTS_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the list of points marked as internalOnly for the specified site
	 * 
	 * @param string $siteUrl	The site for which to retrieve the list of points
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @return
	 */
	public static function getInternalPoints( $siteUrl, $tags = null, $tagUuid = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::INTERNAL_POINTS_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
}

?>