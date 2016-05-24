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
 * The MamboActivitiesService class handles all Activities related requests
 * to the Mambo API.
 */
class MamboActivitiesService extends MamboBaseAbstract
{
	/**
	 * Activity service end point URI
	 * @var string
	 */
	const ACTIVITIES_SITE_URI = "/v1/{site}/activities";
	const ACTIVITIES_SITE_SYNC_URI = "/v1/{site}/activities/sync";
	const ACTIVITIES_USER_URI = "/v1/{site}/activities/{uuid}";
	const ACTIVITIES_ID_URI = "/v1/activities/{id}";
	const ACTIVITIES_REJECT_URI = "/v1/activities/{id}/reject";
	const ACTIVITIES_BOUNTY_CANCEL_URI = "/v1/activities/{id}/bounty/cancel";
	const ACTIVITIES_BOUNTY_AWARD_URI = "/v1/activities/{id}/bounty/award/{uuid}";
	
	
	/**
	 * This method is used to create activities.
	 * 
	 * @param string siteUrl			The site to which the user and behaviour belong to
	 * @param ActivityRequestData data		The data sent to the API in order to create an activity
	 * @return
	 */
	public static function create( $siteUrl, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof ActivityRequestData ) )
		{
			trigger_error( "The data should be of type ActivityRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getUrl( self::ACTIVITIES_SITE_URI, $siteUrl ), MamboClient::POST, $data->getJsonString() );
	}
	
	
	/**
	 * This method is used to create activities synchronously.
	 *
	 * This is the synchronous version of the standard Activities API. Synchronous means that the Activity will be processed immediately
	 * and the response will contain all the relevant behaviours and rewards unlocked by the user. The trade-off for having the Activity
	 * processed immediately is going to be performance as everything takes place in one go. The standard Activities API is asynchronous
	 * which means that under heavy load the platform will take care of processing the Activities as and when it has bandwidth.
	 * 
	 * @param string siteUrl			The site to which the user and behaviour belong to
	 * @param ActivityRequestData data		The data sent to the API in order to create an activity
	 * @return
	 */
	public static function createSync( $siteUrl, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof ActivityRequestData ) )
		{
			trigger_error( "The data should be of type ActivityRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getUrl( self::ACTIVITIES_SITE_SYNC_URI, $siteUrl ), MamboClient::POST, $data->getJsonString() );
	}
	
	
	/**
	 * This method is used to reject the activity with the specified ID.
	 * 
	 * @param string id								The ID of the activity to reject
	 * @param RejectActivityRequestData data		The RejectActivityRequestData
	 * @return
	 */
	public static function reject( $id, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof RejectActivityRequestData ) )
		{
			trigger_error( "The data should be of type RejectActivityRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getWithId( self::ACTIVITIES_REJECT_URI, $id ), MamboClient::POST, $data->getJsonString() );
	}
	
	
	/**
	 * This method is used to cancel the bounty activity with the specified ID.
	 * 
	 * @param string id		The ID of the bounty activity to cancel
	 * @return
	 */
	public static function bountyCancel( $id )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getWithId( self::ACTIVITIES_BOUNTY_CANCEL_URI, $id ), MamboClient::POST );
	}
	
	
	/**
	 * This method is used to award the bounty activity with the specified ID.
	 * 
	 * @param string id				The ID of the bounty activity to award
	 * @param string targetUuid		The UUID to whom the bounty should be awarded
	 * @return
	 */
	public static function bountyAward( $id, $targetUuid )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getUrlWithIdAndUuid( self::ACTIVITIES_BOUNTY_AWARD_URI, $targetUuid, $id ), MamboClient::POST );
	}
	
	
	/**
	 * Get an activity by it's ID
	 * 
	 * @param string id			The ID of the activity to retrieve
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function get( $id, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getWithId( self::ACTIVITIES_ID_URI, $id );
		$fullUrl = $builder->url( $url )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the list of activities for the specified site
	 * 
	 * @param string siteUrl	The site for which to retrieve the list of activities
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @param integer page		Specifies the page of results to retrieve
	 * @param integer count		Specifies the number of results to retrieve, up to a maximum of 100
	 * @param boolean withRewardsOnly	Specifies whether only activities which unlocked one or more rewards should be returned.
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @param array rewardIds		The list of reward IDs to filter by (if any)
	 * @param array behaviourIds	The list of behaviour IDs to filter by (if any)
	 * @param boolean withExceptions	Specifies whether the behaviour activities returned should include 
	 									behaviours which have an exception status. 
	 * @return
	 */
	public static function getActivities( $siteUrl, $tags = null, $tagUuid = null, $page = null, 
							$count = null, $withRewardsOnly = null, $withInternalPoints = null,
							$rewardIds = null, $behaviourIds = null, $withExceptions = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::ACTIVITIES_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->withRewardsOnly( $withRewardsOnly )
						  ->page( $page )
						  ->count( $count )
						  ->withInternalPoints( $withInternalPoints )
						  ->rewardIds( $rewardIds )
						  ->behaviourIds( $behaviourIds )
						  ->withExceptions( $withExceptions )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get the list of activities for the specified user and site
	 * 
	 * @param string siteUrl	The site for which to retrieve the list of activities
	 * @param string uuid		The user for which to retrieve the list of activities
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @param integer page		Specifies the page of results to retrieve
	 * @param integer count		Specifies the number of results to retrieve, up to a maximum of 100
	 * @param boolean withRewardsOnly	Specifies whether only activities which unlocked one or more rewards should be returned.
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @param boolean withTargetUser	Specifies whether activities which have a matching targetUser should also be returned.
	 * @param array rewardIds		The list of reward IDs to filter by (if any)
	 * @param array behaviourIds	The list of behaviour IDs to filter by (if any)
	 * @param boolean withExceptions	Specifies whether the behaviour activities returned should include 
	 									behaviours which have an exception status. 
	 * @return
	 */
	public static function getActivitiesByUser( $siteUrl, $uuid, $tags = null, $tagUuid = null, $page = null, 
											$count = null, $withRewardsOnly = null, $withInternalPoints = null, 
									  		$withTargetUser = null, $rewardIds = null, $behaviourIds = null,
									  		$withExceptions = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::ACTIVITIES_USER_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->withRewardsOnly( $withRewardsOnly )
						  ->withTargetUser( $withTargetUser )
						  ->page( $page )
						  ->count( $count )
						  ->withInternalPoints( $withInternalPoints )
						  ->rewardIds( $rewardIds )
						  ->behaviourIds( $behaviourIds )
						  ->withExceptions( $withExceptions )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
}

?>