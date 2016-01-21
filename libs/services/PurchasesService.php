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
 * The MamboPurchasesService class handles all Purchase related requests
 * to the Mambo API.
 */
class MamboPurchasesService extends MamboBaseAbstract
{
	/**
	 * Purchase service end point URI
	 * @var string
	 */
	const PURCHASES_SITE_URI = "/v1/{site}/purchases";
	const PURCHASES_ORDERNUMBER_URI = "/v1/{site}/purchases/{orderNumber}";
	
	
	/**
	 * This method is used to register a new purchase for a user. If a Mambo related coupon
	 * is passed in the PurchaseRequestData, then the system will redeem the coupon for the user.
	 * Note: this is the only API that can be used to redeem a coupon for a specified purchase. Not
	 * using this API will allow the user to use the same coupon's repeatedly as the validation
	 * will not consider them as redeemed.
	 * 
	 * @param string siteUrl				The site to which the purchase belongs to
	 * @param PurchaseRequestData data		The data sent to the API in order to create a purchase
	 * @return
	 */
	public static function create( $siteUrl, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof PurchaseRequestData ) )
		{
			trigger_error( "The data should be of type PurchaseRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getUrl( self::PURCHASES_SITE_URI, $siteUrl ), MamboClient::POST, 
				$data->getJsonString() );
	}
	
	
	/**
	 * Update an existing purchase by order number. The only field which cannot be updated is the Order Date.
	 * 
	 * @param string siteUrl			The site to which the purchase belongs
	 * @param string orderNumber		The Order Number of the purchase to update
	 * @param PurchaseRequestData data	The data with which to update the specified purchase object
	 * @return
	 */
	public static function update( $siteUrl, $orderNumber, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof PurchaseRequestData ) )
		{
			trigger_error( "The data should be of type PurchaseRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getUrlWithOrderNumber( 
				self::PURCHASES_ORDERNUMBER_URI, $siteUrl, $orderNumber ), 
				MamboClient::PUT, $data->getJsonString() );
	}
	
	/**
	 * Get a purchase
	 * 
	 * @param string siteUrl		The site from which you want to retrieve the purchase
	 * @param string orderNumber	The Order Number of the purchase to retrieve
	 * @return
	 */
	public static function get( $siteUrl, $orderNumber )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getUrlWithOrderNumber( 
				self::PURCHASES_ORDERNUMBER_URI, $siteUrl, $orderNumber ), MamboClient::GET );
	}
	
	
	/**
	 * Delete a purchase
	 * 
	 * @param string siteUrl		The site from which to delete the purchase
	 * @param string orderNumber	The Order Number of the purchase to delete
	 * @return
	 */
	public static function delete( $siteUrl, $orderNumber )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getUrlWithOrderNumber( 
				self::PURCHASES_ORDERNUMBER_URI, $siteUrl, $orderNumber ), MamboClient::DELETE );
	}
	
	
	/**
	 * Get the list of purchases for the specified site
	 * 
	 * @param string siteUrl	The site for which to retrieve the list of purchases
	 * @param integer page		Specifies the page of results to retrieve
	 * @param integer count		Specifies the number of results to retrieve, up to a maximum of 100
	 * @return
	 */
	public static function getPurchases( $siteUrl, $page = null, $count = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL with page and count
		$urlAppendix = ( !is_null( $page ) && !is_null( $count ) ) ? '?page=' . $page . '&count=' . $count : '';
		
		// Make the request
		return self::$client->request( self::getUrl( self::PURCHASES_SITE_URI, $siteUrl ) . $urlAppendix, MamboClient::GET );
	}
}

?>