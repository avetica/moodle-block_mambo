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
 * The MamboNotificationsService class handles all Notification related requests
 * to the Mambo API.
 */
class MamboNotificationsService extends MamboBaseAbstract
{
	/**
	 * Notification service end point URI
	 * @var string
	 */
	const NOTIFICATIONS_ACTIVITY_ID_URI = "/v1/notifications/activity/{id}";
	const NOTIFICATIONS_ID_URI = "/v1/notifications/{id}";
	const CLEAR_NOTIFICATIONS_ID_URI = "/v1/notifications/{id}/clear";
	const CLEAR_NOTIFICATIONS_URI = "/v1/notifications/clear";

	const NOTIFICATIONS_SITE_URI = "/v1/{site}/points";
	
	
	/**
	 * Clear a notification by it's ID
	 * 
	 * @param string id		The ID of the notification to clear
	 * @return
	 */
	public static function clearNotification( $id )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getWithId( self::CLEAR_NOTIFICATIONS_ID_URI, $id ), MamboClient::POST );
	}
	
	
	/**
	 * Clear a list of notifications by their ID
	 * 
	 * @param ClearNotificationRequestData data		The list of IDs of the notification to clear
	 * @return
	 */
	public static function clearNotifications( $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof ClearNotificationsRequestData ) ) {
			trigger_error( "The data should be of type ClearNotificationsRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::CLEAR_NOTIFICATIONS_URI, MamboClient::POST, $data->getJsonString() );
	}
	
	
	/**
	 * Get a notification by it's ID
	 * 
	 * @param string id			The ID of the notification to retrieve
	 * @param boolean withActivities	Flag used to indicate whether the activity which triggered the notification should also be returned.
	 * @return
	 */
	public static function get( $id, $withActivities = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getWithId( self::NOTIFICATIONS_ID_URI, $id );
		$fullUrl = $builder->url( $url )
						  ->withActivities( $withActivities )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
	
	
	/**
	 * Get notifications by Activity ID
	 *
	 * @param string activityId	The ID of the activity for which to retrieve notifications
	 * @param boolean withActivities	Flag used to indicate whether the activity which triggered the notification should also be returned.
	 * @return
	 */
	public static function getByActivityId( $activityId, $withActivities = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getWithId( self::NOTIFICATIONS_ACTIVITY_ID_URI, $activityId );
		$fullUrl = $builder->url( $url )
						  ->withActivities( $withActivities )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}	
	
	
	/**
	 * Get the list of notifications for the specified site
	 * 
	 * @param string $siteUrl	The site for which to retrieve the list of notifications
	 * @param array tags		The list of tags to filter by (if any)
	 * @param string tagUuid	The tagUuid to use to filter the list by personalization tags
	 * @param integer page		Specifies the page of results to retrieve
	 * @param integer count		Specifies the number of results to retrieve, up to a maximum of 100
	 * @param boolean withActivities	Flag used to indicate whether the activity which triggered the notification should also be returned.
	 * @return
	 */
	public static function getNotifications( $siteUrl, $tags = null, $tagUuid = null, $page = null, $count = null, $withActivities = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$builder = new APIUrlBuilder();
		$url = self::getUrl( self::NOTIFICATIONS_SITE_URI, $siteUrl );
		$fullUrl = $builder->url( $url )
						  ->page( $page )
						  ->count( $count )
						  ->withActivities( $withActivities )
						  ->tags( $tags )
						  ->tagUuid( $tagUuid )
						  ->build();
		
		// Make the request
		return self::$client->request( $fullUrl, MamboClient::GET );
	}
}

?>