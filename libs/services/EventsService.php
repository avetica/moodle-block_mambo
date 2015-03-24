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
 * The MamboEventsService class handles all Event related requests
 * to the Mambo API.
 */
class MamboEventsService extends MamboBaseAbstract
{
	/**
	 * Event service end point URI
	 * @var string
	 */
	const EVENTS_SITE_URI = "/v1/{site}/events";
	const EVENTS_ID_URI = "/v1/events/{id}";
	
	/**
	 * This method is used to track and reward a user for performing
	 * a behaviour. For more information see the request data.
	 * 
	 * @param string siteUrl			The site to which the user and behaviour belong to
	 * @param EventRequestData data		The data sent to the API in order to create an event
	 * @return
	 */
	public static function create( $siteUrl, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof EventRequestData ) )
		{
			trigger_error( "The data should be of type EventRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getUrl( self::EVENTS_SITE_URI, $siteUrl ), MamboClient::POST, $data->getJsonString() );
	}
	
	
	/**
	 * Get an event by it's ID
	 * 
	 * @param string id			The ID of the event to retrieve
	 * @return
	 */
	public static function get( $id )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getWithId( self::EVENTS_ID_URI, $id ), MamboClient::GET );
	}
	
	
	/**
	 * Get the list of events for the specified site
	 * 
	 * @param string siteUrl	The site for which to retrieve the list of events
	 * @param integer page		Specifies the page of results to retrieve
	 * @param integer count		Specifies the number of results to retrieve, up to a maximum of 100
	 * @return
	 */
	public static function getEvents( $siteUrl, $page = null, $count = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL with page and count
		$urlAppendix = ( !is_null( $page ) && !is_null( $count ) ) ? '?page=' . $page . '&count=' . $count : '';
		
		// Make the request
		return self::$client->request( self::getUrl( self::EVENTS_SITE_URI, $siteUrl ) . $urlAppendix, MamboClient::GET );
	}
}

?>