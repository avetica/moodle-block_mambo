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
 * The MamboTransactionsService class handles all Transaction related requests
 * to the Mambo API.
 */
class MamboTransactionsService extends MamboBaseAbstract
{
	/**
	 * Transaction service end transaction URI
	 * @var string
	 */
	const TRANSACTIONS_URI = "/v1/transactions";
	const TRANSACTIONS_ID_URI = "/v1/transactions/{id}";
	const TRANSACTIONS_REJECT_URI = "/v1/transactions/{id}/reject";
	const TRANSACTIONS_BOUNTY_CANCEL_URI = "/v1/transactions/{id}/bounty/cancel";
	const TRANSACTIONS_BOUNTY_AWARD_URI = "/v1/transactions/{id}/bounty/award/{uuid}";

	const TRANSACTIONS_SITE_URI = "/v1/{site}/transactions";
	
	
	/**
	 * This method is used to create a new transaction.
	 * 
	 * @param string siteUrl				The site to which the transaction belongs to
	 * @param TransactionRequestData data	The data sent to the API in order to create a transaction
	 * @return
	 */
	public static function create( $siteUrl, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof TransactionRequestData ) )
		{
			trigger_error( "The data should be of type TransactionRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getUrl( self::TRANSACTIONS_SITE_URI, $siteUrl ), 
				MamboClient::POST, $data->getJsonString() );
	}
	
	
	/**
	 * Delete a transaction by it's ID
	 * 
	 * @param string id				The ID of the transaction to delete
	 * @return
	 */
	public static function delete( $id )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getWithId( self::TRANSACTIONS_ID_URI, $id ), MamboClient::DELETE );
	}
	
	
	/**
	 * Delete a list of transactions by their ID
	 * 
	 * @param string ids		The list of IDs of the transaction to delete
	 * @return
	 */
	public static function deleteTransactions( $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof DeleteRequestData ) )
		{
			trigger_error( "The data should be of type DeleteRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::TRANSACTIONS_URI, MamboClient::DELETE, $data->getJsonString() );
	}
	
	
	/**
	 * Get a transaction by it's ID
	 * 
	 * @param string id			The ID of the transaction to retrieve
	 * @return
	 */
	public static function get( $id )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getWithId( self::TRANSACTIONS_ID_URI, $id ), MamboClient::GET );
	}
	
	
	/**
	 * Get the list of transactions for the specified site
	 * 
	 * @param string siteUrl	The site for which to retrieve the list of transactions
	 * @param integer page		Specifies the page of results to retrieve
	 * @param integer count		Specifies the number of results to retrieve, up to a maximum of 100
	 * @return
	 */
	public static function getTransactions( $siteUrl, $page = null, $count = null )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Prepare the URL with page and count
		$urlAppendix = ( !is_null( $page ) && !is_null( $count ) ) ? '?page=' . $page . '&count=' . $count : '';
		
		// Make the request
		return self::$client->request( self::getUrl( self::TRANSACTIONS_SITE_URI, $siteUrl ) . $urlAppendix, MamboClient::GET );
	}
	
	
	/**
	 * This method is used to reject the transaction with the specified ID.
	 * 
	 * @param string id								The ID of the transaction to reject
	 * @param RejectTransactionRequestData data		The RejectTransactionRequestData
	 * @return
	 */
	public static function reject( $id, $data )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Check the request data is valid
		if( !( $data instanceof RejectTransactionRequestData ) )
		{
			trigger_error( "The data should be of type RejectTransactionRequestData", E_USER_ERROR );
		}
		
		// Make the request
		return self::$client->request( self::getWithId( self::TRANSACTIONS_REJECT_URI, $id ), MamboClient::POST, $data->getJsonString() );
	}
	
	
	/**
	 * This method is used to cancel the bounty transaction with the specified ID.
	 * 
	 * @param string id		The ID of the bounty transaction to cancel
	 * @return
	 */
	public static function bountyCancel( $id )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getWithId( self::TRANSACTIONS_BOUNTY_CANCEL_URI, $id ), MamboClient::POST );
	}
	
	
	/**
	 * This method is used to award the bounty transaction with the specified ID.
	 * 
	 * @param string id				The ID of the bounty transaction to award
	 * @param string targetUuid		The UUID to whom the bounty should be awarded
	 * @return
	 */
	public static function bountyAward( $id, $targetUuid )
	{
		// Initialise the client if necessary
		self::initClient();
		
		// Make the request
		return self::$client->request( self::getUrlWithIdAndUuid( self::TRANSACTIONS_BOUNTY_AWARD_URI, $targetUuid, $id ), MamboClient::POST );
	}
}

?>