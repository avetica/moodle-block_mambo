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
 * The MamboUsersService class handles all User related requests
 * to the Mambo API.
 */
class MamboUsersService extends MamboBaseAbstract
{
	/**
	 * User service end point URIs
	 */
	const USER_ID_URI = "/v1/users/{id}";
	
	const USER_SITE_URI = "/v1/{site}/users";
	const USER_UUID_URI = "/v1/{site}/users/{uuid}";
	const USER_SEARCH_URI = "/v1/{site}/users/search";
	
	const USER_BLACKLIST_URI = "/v1/{site}/users/blacklist";
	const USER_BLACKLIST_UUID_URI = "/v1/{site}/users/blacklist/{uuid}";
	
	const USER_RESET_URI = "/v1/{site}/users/{uuid}/reset";
	const USER_REWARDS_URI = "/v1/{site}/users/{uuid}/rewards";
	const USER_ALL_REWARDS_URI = "/v1/{site}/users/{uuid}/rewards/all";
	const USER_LEVELS_URI = "/v1/{site}/users/{uuid}/rewards/levels";
	const USER_ALL_LEVELS_URI = "/v1/{site}/users/{uuid}/rewards/levels/all";
	const USER_ACHIEVEMENTS_URI = "/v1/{site}/users/{uuid}/rewards/achievements";
	const USER_ALL_ACHIEVEMENTS_URI = "/v1/{site}/users/{uuid}/rewards/achievements/all";
	const USER_MISSIONS_URI = "/v1/{site}/users/{uuid}/rewards/missions";
	const USER_ALL_MISSIONS_URI = "/v1/{site}/users/{uuid}/rewards/missions/all";
	const USER_COUPONS_URI = "/v1/{site}/users/{uuid}/coupons";
	const USER_ALL_COUPONS_URI = "/v1/{site}/users/{uuid}/coupons/all";
	const USER_PURCHASES_URI = "/v1/{site}/users/{uuid}/purchases";
	const USER_ACTIVITIES_URI = "/v1/{site}/users/{uuid}/activities";
	const USER_NOTIFICATIONS_URI = "/v1/{site}/users/{uuid}/notifications";
	const USER_CLEAR_NOTIFICATIONS_URI = "/v1/{site}/users/{uuid}/notifications/clear";
	
	
	
	/**
	 * Create a new user
	 * 
	 * @param string siteUrl		The site in which you want to create the user
	 * @param UserRequestData data	The data used to create the user
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function create( $siteUrl, $data, $withPersonalization = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof UserRequestData ) )
		{
			trigger_error( "The data should be of type UserRequestData", E_USER_ERROR );
		}
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::USER_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->withPersonalization( $withPersonalization )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::POST, $data->getJsonString() );
	}
	
	
	/**
	 * Update an existing user
	 * 
	 * @param string siteUrl		The site to which the user belongs
	 * @param string uuid			The unique user ID of the user to update
	 * @param UserRequestData data	The data with which to update the specified user object
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function update( $siteUrl, $uuid, $data, $withPersonalization = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof UserRequestData ) )
		{
			trigger_error( "The data should be of type UserRequestData", E_USER_ERROR );
		}
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_UUID_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->withPersonalization( $withPersonalization )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, 
				MamboClient::PUT, $data->getJsonString() );
	}
	
	
	/**
	 * Get a user
	 * 
	 * @param string siteUrl		The site from which you want to retrieve the user
	 * @param string uuid			The unique user ID of the user to retrieve
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function get( $siteUrl, $uuid, $withPersonalization = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_UUID_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->withPersonalization( $withPersonalization )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get a user by ID
	 * 
	 * @param string id		The ID of the user to retrieve
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getById( $id, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getWithId( self::USER_ID_URI, $id );
		$fullUrl = $builder->url( $url )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
						  
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Delete a user
	 * 
	 * @param string siteUrl	The site from which to delete the user
	 * @param string uuid		The unique user ID of the user to delete
	 * @return
	 */
	public static function delete( $siteUrl, $uuid )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getUrlWithUuid( 
				self::USER_UUID_URI, $siteUrl, $uuid ), MamboClient::DELETE );
	}
	
	
	/**
	 * Reset a user. This will clear all the data associated to the user, except
	 * for the basic data (i.e. username, email, name, etc).
	 * 
	 * @param string siteUrl	The site from which to reset the user
	 * @param string uuid		The unique user ID of the user to reset
	 * @return
	 */
	public static function reset( $siteUrl, $uuid )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getUrlWithUuid( 
				self::USER_RESET_URI, $siteUrl, $uuid ), MamboClient::POST );
	}


	/**
	 * Add a user to the blacklist. The blacklist stops user's from earning points.
	 *
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user to be added to the blacklist
	 * @return
	 */
	public static function addToBlacklist( $siteUrl, $uuid )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getUrlWithUuid( 
				self::USER_BLACKLIST_UUID_URI, $siteUrl, $uuid ), MamboClient::POST );
	}


	/**
	 * Remove a user from the blacklist. The blacklist stops user's from earning points.
	 *
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user to be removed from the blacklist
	 * @return
	 */
	public static function removeFromBlacklist( $siteUrl, $uuid )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getUrlWithUuid( 
				self::USER_BLACKLIST_UUID_URI, $siteUrl, $uuid ), MamboClient::DELETE );
	}


	/**
	 * Get the list of blacklisted users for the specified site
	 *
	 * @param string siteUrl	The site for which to retrieve the list blacklisted of users
	 * @param array tags		The list of tags to filter by (if any)
	 * @param integer page		Specifies the page of results to retrieve
	 * @param integer count		Specifies the number of results to retrieve, up to a maximum of 100
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getBlacklistedUsers( $siteUrl, $tags = null, $page = null, $count = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::USER_BLACKLIST_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->page( $page )
						  ->count( $count )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get a user's rewards. This returns a list of all the rewards
	 * awarded to the specified user (achievements + levels).
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's rewards information is to be retrieved
	 * @param array tags		The list of tags to filter by (if any)
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getRewards( $siteUrl, $uuid, $tags = null, $withPersonalization = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_REWARDS_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->withPersonalization( $withPersonalization )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get a user's rewards together with a full list of available rewards. 
	 * This returns a list of all the rewards awarded to the specified user
	 * and a list of available rewards. Note: the rewards awarded to the user
	 * will contain a rewardId rather than the reward. The reward can be found
	 * in the list of available rewards.
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's reward information is to be retrieved
	 * @param array tags		The list of tags to filter by (if any)
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getAllRewards( $siteUrl, $uuid, $tags = null, $withPersonalization = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_ALL_REWARDS_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->withPersonalization( $withPersonalization )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get a user's levels. This returns a list of all the levels
	 * awarded to the specified user.
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's level information is to be retrieved
	 * @param array tags		The list of tags to filter by (if any)
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getLevels( $siteUrl, $uuid, $tags = null, $withPersonalization = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_LEVELS_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->withPersonalization( $withPersonalization )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get a user's levels together with a full list of available levels. 
	 * This returns a list of all the levels awarded to the specified user
	 * and a list of available levels. Note: the levels awarded to the user
	 * will contain a rewardId rather than the level. The level can be found
	 * in the list of available levels.
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's level information is to be retrieved
	 * @param array tags		The list of tags to filter by (if any)
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getAllLevels( $siteUrl, $uuid, $tags = null, $withPersonalization = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_ALL_LEVELS_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->withPersonalization( $withPersonalization )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get a user's achievements. This returns a list of all the achievements
	 * awarded to the specified user.
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's achievements information is to be retrieved
	 * @param array tags		The list of tags to filter by (if any)
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getAchievements( $siteUrl, $uuid, $tags = null, $withPersonalization = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_ACHIEVEMENTS_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->withPersonalization( $withPersonalization )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get a user's achievements together with a full list of available achievements. 
	 * This returns a list of all the achievements awarded to the specified user
	 * and a list of available achievements. Note: the achievements awarded to the user
	 * will contain a rewardId rather than the achievement. The achievement can be found
	 * in the list of available achievements.
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's achievement information is to be retrieved
	 * @param array tags		The list of tags to filter by (if any)
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getAllAchievements( $siteUrl, $uuid, $tags = null, $withPersonalization = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_ALL_ACHIEVEMENTS_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->withPersonalization( $withPersonalization )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get a user's missions. This returns a list of all the missions
	 * with the user's progress in them.
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's missions information is to be retrieved
	 * @param array tags		The list of tags to filter by (if any)
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getMissions( $siteUrl, $uuid, $tags = null, $withPersonalization = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_MISSIONS_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->withPersonalization( $withPersonalization )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get a user's missions together with a full list of available missions. 
	 * This returns a list of all the missions awarded to the specified user
	 * and a list of available missions. Note: the missions awarded to the user
	 * will contain a rewardId rather than the mission. The mission can be found
	 * in the list of available missions.
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's mission information is to be retrieved
	 * @param array tags		The list of tags to filter by (if any)
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getAllMissions( $siteUrl, $uuid, $tags = null, $withPersonalization = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_ALL_MISSIONS_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->withPersonalization( $withPersonalization )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get a user's coupons. This returns a list of all the coupons
	 * with associated user data. Like when they were awarded or redeemed on.
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's coupons information is to be retrieved
	 * @param array tags		The list of tags to filter by (if any)
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @return
	 */
	public static function getCoupons( $siteUrl, $uuid, $tags = null, $withPersonalization = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_COUPONS_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->withPersonalization( $withPersonalization )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get a user's coupons and a list of coupons which can be bought with points.
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's coupons information is to be retrieved
	 * @param array tags		The list of tags to filter by (if any)
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @return
	 */
	public static function getAllCoupons( $siteUrl, $uuid, $tags = null, $withPersonalization = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_ALL_COUPONS_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->withPersonalization( $withPersonalization )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get a user's notifications
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's notifications information is to be retrieved
	 * @param array tags		The list of tags to filter by (if any)
	 * @param integer page		Specifies the page of results to retrieve
	 * @param integer count		Specifies the number of results to retrieve, up to a maximum of 100
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @param boolean withActivities	Flag used to indicate whether the activity which triggered the notification should also be returned.
	 * @return
	 */
	public static function getNotifications( $siteUrl, $uuid, $tags = null, $page = null, 
							$count = null, $withPersonalization = null, $withActivities = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_NOTIFICATIONS_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->page( $page )
						  ->count( $count )
						  ->tags( $tags )
						  ->withPersonalization( $withPersonalization )
						  ->withActivities( $withActivities )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Clear a user's notifications
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's notifications are to be cleared
	 * @return
	 */
	public static function clearNotifications( $siteUrl, $uuid )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getUrlWithUuid( 
				self::USER_CLEAR_NOTIFICATIONS_URI, $siteUrl, $uuid ), MamboClient::POST );
	}
	
	
	/**
	 * Get a user's purchases. This returns a pagd list of the purchases
	 * made by the user.
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's purchase information is to be retrieved
	 * @param integer page		Specifies the page of results to retrieve
	 * @param integer count		Specifies the number of results to retrieve, up to a maximum of 100
	 * @return
	 */
	public static function getPurchases( $siteUrl, $uuid, $page = null, $count = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL with page and count
		$urlAppendix = ( !is_null( $page ) && !is_null( $count ) ) ? '?page=' . $page . '&count=' . $count : '';
		
		// Make the request
		return self::$client->request( self::getUrlWithUuid( 
				self::USER_PURCHASES_URI, $siteUrl, $uuid ) . 
				$urlAppendix, MamboClient::GET );
	}
	
	
	/**
	 * Get a user's activities. This returns a paged list of the activities
	 * performed by the user.
	 * 
	 * @param string siteUrl	The site to which the user belongs
	 * @param string uuid		The unique user ID of the user who's activities information is to be retrieved
	 * @param array tags		The list of tags to filter by (if any)
	 * @param boolean withPersonalization	Flag used to indicate whether the response should be filtered by the user's personalization tags.
	 * @param boolean withRewardsOnly		Specifies whether only activities which unlocked one or more rewards should be returned.
	 * @param integer page		Specifies the page of results to retrieve
	 * @param integer count		Specifies the number of results to retrieve, up to a maximum of 100
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @param boolean withTargetUser	Specifies whether activities which have a matching targetUser should also be returned.
	 * @param array rewardIds		The list of reward IDs to filter by (if any)
	 * @param array behaviourIds	The list of behaviour IDs to filter by (if any)
	 * @param boolean withExceptions	Specifies whether the behaviour activities returned should include 
	 									behaviours which have an exception status. 
	 * @return
	 */
	public static function getActivities( $siteUrl, $uuid, $tags = null, $withPersonalization = null, 
										  $withRewardsOnly = null, $page = null, $count = null, $withInternalPoints = null, 
										  $withTargetUser = null, $rewardIds = null, $behaviourIds = null,
										  $withExceptions = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrlWithUuid( self::USER_ACTIVITIES_URI, $siteUrl, $uuid );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->withPersonalization( $withPersonalization )
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
	
	
	/**
	 * Get the list of users for the specified site
	 * 
	 * @param string siteUrl	The site for which to retrieve the list of users
	 * @param array tags		The list of tags to filter by (if any)
	 * @param integer page		Specifies the page of results to retrieve
	 * @param integer count		Specifies the number of results to retrieve, up to a maximum of 100
	 * @param string orderBy	Specifies the field on which to sort the results. Allowed values: uuid, email, createdOn, 
	 * 							totalPoints, pointsSpent, pointsBalance, totalSpend, totalCouponSpend, avgSpend, avgCouponSpend, 
	 * 							rewards, purchases, couponPurchases, coupons, isMember, lastSeenOn, memberSince
	 * @param string order		Specifies the order in which to sort the results. Allowed values: asc, desc
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function getUsers( $siteUrl, $tags = null, $page = null, $count = null, $orderBy = null, $order = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();

		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::USER_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->page( $page )
						  ->count( $count )
						  ->orderBy( $orderBy )
						  ->order( $order )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	

	/**
	 * Search the users of the specified site starting from the page
	 * specified and returning the number of users specified by count. Also
	 * filter by the specified field.
	 * 
	 * @param string siteUrl	The site for which to retrieve the list of users
	 * @param string query		The search query to be used
	 * @param array tags		The list of tags to filter by (if any)
	 * @param integer page		Specifies the page of results to retrieve
	 * @param integer count		Specifies the number of results to retrieve, up to a maximum of 100
	 * @param string orderBy	Specifies the field on which to sort the results. Allowed values: uuid, email, createdOn, 
	 * 							totalPoints, pointsSpent, pointsBalance, totalSpend, totalCouponSpend, avgSpend, avgCouponSpend, 
	 * 							rewards, purchases, couponPurchases, coupons, isMember, lastSeenOn, memberSince
	 * @param string order		Specifies the order in which to sort the results. Allowed values: asc, desc
	 * @param boolean withInternalPoints	Whether internalOnly points should be returned in the response
	 * @return
	 */
	public static function searchUsers( $siteUrl, $query, $tags = null, $page = null, $count = null, 
										$orderBy = null, $order = null, $withInternalPoints = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( is_null( $query ) || empty( $query ) )
		{
			trigger_error( "The query string must not be null", E_USER_ERROR );
		}

		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::USER_SEARCH_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->tags( $tags )
						  ->page( $page )
						  ->count( $count )
						  ->orderBy( $orderBy )
						  ->order( $order )
						  ->query( $query )
						  ->withInternalPoints( $withInternalPoints )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
}

?>