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
 * The MamboLeaderboardsService class handles all Leaderboard related requests
 * to the Mambo API.
 */
class MamboLeaderboardsService extends MamboBaseAbstract
{
	/**
	 * Leaderboard service end point URI
	 * @var string
	 */
	const LEADERBOARDS_SITE_URI = "/v1/{site}/leaderboards";
	const LEADERBOARDS_SYSTEM_URI = "/v1/{site}/leaderboards/system";

	const LEADERBOARDS_URI = "/v1/leaderboards";
	const LEADERBOARDS_ID_URI = "/v1/leaderboards/{id}";
	const BEHAVIOUR_LEADERBOARDS_URI = "/v1/leaderboards/behaviour/{id}";
	
	
	/**
	 * This method is used to create a new leaderboard.
	 * 
	 * @param string siteUrl				The site to which the leaderboard belongs to
	 * @param LeaderboardRequestData data	The data sent to the API in order to create a leaderboard
	 * @return
	 */
	public static function create( $siteUrl, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof LeaderboardRequestData ) )
		{
			trigger_error( "The data should be of type LeaderboardRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getUrl( self::LEADERBOARDS_SITE_URI, $siteUrl ), 
				MamboClient::POST, $data->getJsonString() );
	}
	
	
	/**
	 * Update an existing leaderboard by ID.
	 * 
	 * @param string id						The ID of the leaderboard to update
	 * @param LeaderboardRequestData data	The data with which to update the specified leaderboard object
	 * @return
	 */
	public static function update( $id, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof LeaderboardRequestData ) )
		{
			trigger_error( "The data should be of type LeaderboardRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getWithId( self::LEADERBOARDS_ID_URI, $id ), 
				MamboClient::PUT, $data->getJsonString() );
	}
	
	
	/**
	 * Delete a leaderboard by it's ID
	 * 
	 * @param string id				The ID of the leaderboard to delete
	 * @return
	 */
	public static function delete( $id )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getWithId( self::LEADERBOARDS_ID_URI, $id ), MamboClient::DELETE );
	}
	
	
	/**
	 * Delete a list of leaderboards by their ID
	 * 
	 * @param string ids		The list of IDs of the leaderboard to delete
	 * @return
	 */
	public static function deleteLeaderboards( $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof DeleteRequestData ) )
		{
			trigger_error( "The data should be of type DeleteRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::LEADERBOARDS_URI, MamboClient::DELETE, $data->getJsonString() );
	}
	
	
	/**
	 * Get the list of leaderboards for the specified site.
	 * Note: the leaderboards returned using this method are not populated
	 * with the users. In order to retrieve a leaderboard with it's users
	 * you should call one of the other methods.
	 * 
	 * @param string $siteUrl	The site for which to retrieve the list of leaderboards
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @return
	 */
	public static function getLeaderboards( $siteUrl, $tags = null, $tagUuid = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::LEADERBOARDS_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the system leaderboard for the specified site. The system leaderboard
	 * is the overall ranking for the site. This is based on the total number of
	 * points that the users acquire.
	 *
	 * @param string $siteUrl	The site for which to retrieve the system leaderboard
	 * @param string $period	The period for which to retrieve the leaderboard. Allowed values: day, week, month, all
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @return
	 */	
	public static function getSystemLeaderboard( $siteUrl, $period = null, $tags = null, $tagUuid = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::LEADERBOARDS_SYSTEM_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->period( $period )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the leaderboard specified by site and it's ID. To see a list of the leaderboard
	 * IDs, use the getLeaderboards() method.
	 *
	 * @param string $id		The ID of the leaderboard to retrieve
	 * @param string $period	The period for which to retrieve the leaderboard. Allowed values: day, week, month, all
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @return
	 */	
	public static function getLeaderboard( $id, $period = null, $tags = null, $tagUuid = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getWithId( self::LEADERBOARDS_ID_URI, $id );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->period( $period )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the leaderboard specified by site and it's associated behaviour ID. To see a list of the leaderboard
	 * behaviour IDs, use the getLeaderboards() method.
	 *
	 * @param string $behaviourId		The ID of the behaviour which has an associated leaderboard
	 * @param string $period			The period for which to retrieve the leaderboard. Allowed values: day, week, month, all
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @return
	 */	
	public static function getBehaviourLeaderboard( $behaviourId, $period = null, $tags = null, $tagUuid = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getWithId( self::BEHAVIOUR_LEADERBOARDS_URI, $behaviourId );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->period( $period )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
}

?>