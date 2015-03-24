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
	 * Activities service end point URI
	 * @var string
	 */
	const REWARD_ACTIVITIES_RESOURCE_URI = "/v1/{site}/activities/rewards";
	
	
	/**
	 * Get the list of reward activities for the specified site
	 * 
	 * @param string siteUrl	The site for which to retrieve the list of reward activities
	 * @param integer page		Specifies the page of results to retrieve
	 * @param integer count		Specifies the number of results to retrieve, up to a maximum of 100
	 * @return
	 */
	public static function getRewardActivities( $siteUrl, $page = null, $count = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL
		$urlAppendix = ( !is_null( $page ) && !is_null( $count ) ) ? '?page=' . $page . '&count=' . $count : '';
		
		// Make the request
		return self::$client->request( self::getUrl( self::REWARD_ACTIVITIES_RESOURCE_URI, $siteUrl ) . $urlAppendix, MamboClient::GET );
	}
}

?>