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
 * The MamboRewardsService class handles all Reward related requests
 * to the Mambo API.
 */
class MamboRewardsService extends MamboBaseAbstract
{
	/**
	 * Reward service end point URIs
	 * @var string
	 */
	const REWARDS_URI = "/v1/rewards";
	const REWARDS_ID_URI = "/v1/rewards/{id}";
	const REWARDS_IMAGE_URI = "/v1/rewards/{id}/image";
	
	const REWARDS_SITE_URI = "/v1/{site}/rewards";
	const ACHIEVEMENTS_SITE_URI = "/v1/{site}/rewards/achievements";
	const LEVELS_SITE_URI = "/v1/{site}/rewards/levels";
	const MISSIONS_SITE_URI = "/v1/{site}/rewards/missions";
	
	
	/**
	 * This method is used to create a new reward.
	 * 
	 * @param string siteUrl				The site to which the reward belongs to
	 * @param RewardRequestData data		The data sent to the API in order to create a reward
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function create( $siteUrl, $data, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof RewardRequestData ) )
		{
			trigger_error( "The data should be of type RewardRequestData", E_USER_ERROR );
		}
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::REWARDS_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::POST, $data->getJsonString() );
	}
	
	
	/**
	 * Update an existing reward by ID.
	 * 
	 * @param string id					The ID of the reward to update
	 * @param RewardRequestData data	The data with which to update the specified reward object
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function update( $id, $data, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof RewardRequestData ) )
		{
			trigger_error( "The data should be of type RewardRequestData", E_USER_ERROR );
		}
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getWithId( self::REWARDS_ID_URI, $id );
		$fullUrl = $builder->url( $url )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::PUT, $data->getJsonString() );
	}
	
	
	/**
	 * Upload an image for the reward
	 * 
	 * @param string id		The reward for which to upload the image
	 * @param data image 	The image to upload for the reward
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
		$url = self::getWithId( self::REWARDS_IMAGE_URI, $id );
		$fullUrl = $builder->url( $url )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->upload( $fullUrl, $image );
	}
	
	
	/**
	 * Delete a reward by it's ID
	 * 
	 * @param string id				The ID of the reward to delete
	 * @return
	 */
	public static function delete( $id )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getWithId( self::REWARDS_ID_URI, $id ), MamboClient::DELETE );
	}
	
	
	/**
	 * Delete a list of rewards by their ID
	 * 
	 * @param string ids		The list of IDs of the reward to delete
	 * @return
	 */
	public static function deleteRewards( $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof DeleteRequestData ) )
		{
			trigger_error( "The data should be of type DeleteRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::REWARDS_URI, MamboClient::DELETE, $data->getJsonString() );
	}
	
	
	/**
	 * Get a reward by it's ID
	 * 
	 * @param string id			The ID of the reward to retrieve
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function get( $id, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getWithId( self::REWARDS_ID_URI, $id );
		$fullUrl = $builder->url( $url )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the list of rewards for the specified site
	 * 
	 * @param string $siteUrl	The site for which to retrieve the list of rewards
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getRewards( $siteUrl, $tags = null, $tagUuid = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::REWARDS_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the list of achievements for the specified site
	 * 
	 * @param string $siteUrl	The site for which to retrieve the list of achievements
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getAchievements( $siteUrl, $tags = null, $tagUuid = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::ACHIEVEMENTS_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the list of levels for the specified site
	 * 
	 * @param string $siteUrl	The site for which to retrieve the list of levels
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getLevels( $siteUrl, $tags = null, $tagUuid = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::LEVELS_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the list of missions for the specified site
	 * 
	 * @param string $siteUrl	The site for which to retrieve the list of missions
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getMissions( $siteUrl, $tags = null, $tagUuid = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::MISSIONS_SITE_URI, $siteUrl );
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