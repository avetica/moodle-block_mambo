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
	const LEADERBOARDS_GENERAL_URI = "/v1/{site}/leaderboards/general";

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
	 * @return
	 */
	public static function getLeaderboards( $siteUrl )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getUrl( 
				self::LEADERBOARDS_SITE_URI, $siteUrl ), MamboClient::GET );
	}
	
	
	/**
	 * Get the general leaderboard for the specified site. The general leaderboard
	 * is the overall ranking for the site. This is based on the total number of
	 * points that the users acquire.
	 *
	 * @param string $siteUrl	The site for which to retrieve the general leaderboard
	 * @param string $period	The period for which to retrieve the leaderboard. Allowed values: day, week, month, all
	 * @return
	 */	
	public static function getGeneralLeaderboard( $siteUrl, $period = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( 
				self::getUrl( self::LEADERBOARDS_GENERAL_URI, $siteUrl ) . 
				self::getUrlAppendage( $period ), MamboClient::GET );
	}
	
	
	/**
	 * Get the leaderboard specified by site and it's ID. To see a list of the leaderboard
	 * IDs, use the getLeaderboards() method.
	 *
	 * @param string $siteUrl	The site for which to retrieve the leaderboard
	 * @param string $id		The ID of the leaderboard to retrieve
	 * @param string $period	The period for which to retrieve the leaderboard. Allowed values: day, week, month, all
	 * @return
	 */	
	public static function getLeaderboard( $siteUrl, $id, $period = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getUrlWithId( 
				self::LEADERBOARDS_ID_URI, $siteUrl, $id ) . 
				self::getUrlAppendage( $period ), MamboClient::GET );
	}
	
	
	/**
	 * Get the leaderboard specified by site and it's associated behaviour ID. To see a list of the leaderboard
	 * behaviour IDs, use the getLeaderboards() method.
	 *
	 * @param string $siteUrl			The site for which to retrieve the leaderboard
	 * @param string $behaviourId		The ID of the behaviour which has an associated leaderboard
	 * @param string $period			The period for which to retrieve the leaderboard. Allowed values: day, week, month, all
	 * @return
	 */	
	public static function getBehaviourLeaderboard( $siteUrl, $behaviourId, $period = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getUrlWithId( 
				self::BEHAVIOUR_LEADERBOARDS_URI, $siteUrl, $behaviourId ) . 
				self::getUrlAppendage( $period ), MamboClient::GET );
	}
	
	
	/**
	 * Takes the period parameter and validates it's content. If the content is valid, then it will
	 * format the query string to be used with the Leaderboard API end points.
	 * 
	 * @param string $period	The period for which to retrieve the leaderboard. Allowed values: day, week, month, all
	 */
	private static function getUrlAppendage( $period )
	{
		// Make sure the period is not null
		if( !is_null( $period ) )
		{
			// Check the period variable
			if( strcmp( $period, 'day') != 0 && strcmp( $period, 'week') != 0 && 
				strcmp( $period, 'month') != 0 && strcmp( $period, 'all') != 0 )
			{
				trigger_error( "The value specified for period is invalid. Allowed values: day, week, month, all", E_USER_ERROR );
			}
			else
			{
				return "?period=" . $period;
			}
		}
		return "";
	}
}

?>