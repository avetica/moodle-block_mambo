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
 * The MamboBehavioursService class handles all Behaviour related requests
 * to the Mambo API.
 */
class MamboBehavioursService extends MamboBaseAbstract
{
	/**
	 * Behaviour service end point URI
	 * @var string
	 */
	const BEHAVIOURS_URI = "/v1/behaviours";
	const BEHAVIOURS_ID_URI = "/v1/behaviours/{id}";
	const BEHAVIOURS_IMAGE_URI = "/v1/behaviours/{id}/image";

	const BEHAVIOURS_SITE_URI = "/v1/{site}/behaviours";
	const SIMPLE_BEHAVIOURS_SITE_URI = "/v1/{site}/behaviours/simple";
	const FLEXIBLE_BEHAVIOURS_SITE_URI = "/v1/{site}/behaviours/flexible";
	
	
	/**
	 * This method is used to create a new behaviour.
	 * 
	 * @param string siteUrl				The site to which the behaviour belongs to
	 * @param BehaviourRequestData data		The data sent to the API in order to create a behaviour
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function create( $siteUrl, $data, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof BehaviourRequestData ) )
		{
			trigger_error( "The data should be of type BehaviourRequestData", E_USER_ERROR );
		}
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::BEHAVIOURS_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::POST, $data->getJsonString() );
	}
	
	
	/**
	 * Update an existing behaviour by ID.
	 * 
	 * @param string id					The ID of the behaviour to update
	 * @param BehaviourRequestData data	The data with which to update the specified behaviour object
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function update( $id, $data, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof BehaviourRequestData ) )
		{
			trigger_error( "The data should be of type BehaviourRequestData", E_USER_ERROR );
		}
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getWithId( self::BEHAVIOURS_ID_URI, $id );
		$fullUrl = $builder->url( $url )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::PUT, $data->getJsonString() );
	}
	
	
	/**
	 * Upload an image for the behaviour
	 * 
	 * @param string id		The behaviour for which to upload the image
	 * @param data image 	The image to upload for the behaviour
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function uploadImage( $id, $image, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( is_null( $image ) || empty( $image ) )
		{
			trigger_error( "The image must not be empty", E_USER_ERROR );
		}
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getWithId( self::BEHAVIOURS_IMAGE_URI, $id );
		$fullUrl = $builder->url( $url )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->upload( $fullUrl, $image );
	}
	
	
	/**
	 * Delete a behaviour by it's ID
	 * 
	 * @param string id				The ID of the behaviour to delete
	 * @return
	 */
	public static function delete( $id )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getWithId( self::BEHAVIOURS_ID_URI, $id ), MamboClient::DELETE );
	}
	
	
	/**
	 * Delete a list of behaviours by their ID
	 * 
	 * @param string ids		The list of IDs of the behaviour to delete
	 * @return
	 */
	public static function deleteBehaviours( $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof DeleteRequestData ) )
		{
			trigger_error( "The data should be of type DeleteRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::BEHAVIOURS_URI, MamboClient::DELETE, $data->getJsonString() );
	}
	
	
	/**
	 * Get a behaviour by it's ID
	 * 
	 * @param string id			The ID of the behaviour to retrieve
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function get( $id, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getWithId( self::BEHAVIOURS_ID_URI, $id );
		$fullUrl = $builder->url( $url )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the list of behaviours for the specified site
	 * 
	 * @param string $siteUrl	The site for which to retrieve the list of behaviours
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getBehaviours( $siteUrl, $tags = null, $tagUuid = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::BEHAVIOURS_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the list of simple behaviours for the specified site
	 * 
	 * @param string $siteUrl	The site for which to retrieve the list of simple behaviours
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getSimpleBehaviours( $siteUrl, $tags = null, $tagUuid = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::SIMPLE_BEHAVIOURS_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the list of flexible behaviours for the specified site
	 * 
	 * @param string $siteUrl	The site for which to retrieve the list of flexible behaviours
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getFlexibleBehaviours( $siteUrl, $tags = null, $tagUuid = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::FLEXIBLE_BEHAVIOURS_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
}

?>