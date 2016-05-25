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
 * Utility class used to build the relevant query strings
 */
class APIUrlBuilder
{
	private $queryString = "";
	private $url = null;


	public function url( $url ) {
		$this->url = $url;
		return $this;
	}


	public function page( $page )
	{
		if( is_null( $page ) )
			return $this;

		$this->queryString .= "&page=";
		$this->queryString .= $page;
		return $this;
	}


	public function count( $count )
	{
		if( is_null( $count ) )
			return $this;

		$this->queryString .= "&count=";
		$this->queryString .= $count;
		return $this;
	}


	public function tags( $tags )
	{
		if( is_null( $tags ) || !is_array( $tags ) || empty( $tags ) )
			return $this;

		foreach( $tags as $tag ) {
			$this->queryString .= "&tags=";
			$this->queryString .= $tag;
		}
		return $this;
	}


	public function tagUuid( $tagUuid )
	{
		if( is_null( $tagUuid ) )
			return $this;

		$this->queryString .= "&tagUuid=";
		$this->queryString .= $tagUuid;
		return $this;
	}


	public function period( $period )
	{
		if( is_null( $period ) )
			return $this;
			
		if( strcmp( $period, 'day') != 0 && 
			strcmp( $period, 'week') != 0 && 
			strcmp( $period, 'month') != 0 && 
			strcmp( $period, 'all') != 0 )
		{
			trigger_error( "The value specified for period is invalid. Allowed values: day, week, month, all", E_USER_ERROR );
		}

		$this->queryString .= "&period=";
		$this->queryString .= $period;
		return $this;
	}


	public function withUsers( $withUsers )
	{
		if( is_null( $withUsers ) )
			return $this;

		$this->queryString .= "&withUsers=";
		$this->queryString .= $withUsers;
		return $this;
	}


	public function withPersonalization( $withPersonalization )
	{
		if( is_null( $withPersonalization ) )
			return $this;

		$this->queryString .= "&withPersonalization=";
		$this->queryString .= $withPersonalization;
		return $this;
	}


	public function withActivities( $withActivities )
	{
		if( is_null( $withActivities ) )
			return $this;

		$this->queryString .= "&withActivities=";
		$this->queryString .= $withActivities;
		return $this;
	}


	public function withRewardsOnly( $withRewardsOnly )
	{
		if( is_null( $withRewardsOnly ) )
			return $this;

		$this->queryString .= "&withRewardsOnly=";
		$this->queryString .= $withRewardsOnly;
		return $this;
	}


	public function withTargetUser( $withTargetUser )
	{
		if( is_null( $withTargetUser ) )
			return $this;

		$this->queryString .= "&withTargetUser=";
		$this->queryString .= $withTargetUser;
		return $this;
	}


	public function withInternalPoints( $withInternalPoints )
	{
		if( is_null( $withInternalPoints ) )
			return $this;

		$this->queryString .= "&withInternalPoints=";
		$this->queryString .= $withInternalPoints;
		return $this;
	}


	public function withExceptions( $withExceptions )
	{
		if( is_null( $withExceptions ) )
			return $this;

		$this->queryString .= "&withExceptions=";
		$this->queryString .= $withExceptions;
		return $this;
	}


	public function orderBy( $orderBy )
	{
		if( is_null( $orderBy ) )
			return $this;
			
		if( strcmp( $orderBy, 'uuid') != 0 && strcmp( $orderBy, 'email') != 0 &&
				strcmp( $orderBy, 'createdOn') != 0 && strcmp( $orderBy, 'totalPoints') != 0 &&
				strcmp( $orderBy, 'totalSpend') != 0 && strcmp( $orderBy, 'totalCouponSpend') != 0 &&
				strcmp( $orderBy, 'avgSpend') != 0 && strcmp( $orderBy, 'avgCouponSpend') != 0 &&
				strcmp( $orderBy, 'achievements') != 0 && strcmp( $orderBy, 'levels') != 0 &&
				strcmp( $orderBy, 'missions') != 0 && strcmp( $orderBy, 'rewards') != 0 &&
				strcmp( $orderBy, 'purchases') != 0 && strcmp( $orderBy, 'couponPurchases') != 0 &&
				strcmp( $orderBy, 'coupons') != 0 && strcmp( $orderBy, 'isMember') != 0 &&
				strcmp( $orderBy, 'lastSeenOn') != 0 && strcmp( $orderBy, 'memberSince') != 0 &&
				strcmp( $orderBy, 'pointsSpent') != 0 && strcmp( $orderBy, 'pointsBalance') != 0 )
		{
			trigger_error( "The value specified for orderBy is invalid. Allowed values: uuid, email,
					createdOn, totalPoints, pointsSpent, pointsBalance, totalSpend, totalCouponSpend,
					avgSpend, avgCouponSpend, achievements, levels, missions, rewards, purchases,
					couponPurchases, coupons, isMember, lastSeenOn, memberSince, pointsSpent, pointsBalance", E_USER_ERROR );
		}			

		$this->queryString .= "&orderBy=";
		$this->queryString .= $orderBy;
		return $this;
	}


	public function order( $order )
	{
		if( is_null( $order ) )
			return $this;
			
		if( strcmp( $order, 'desc') != 0 && 
			strcmp( $order, 'asc') != 0 )
		{
			trigger_error( "The value specified for order is invalid. Allowed values: asc, desc", E_USER_ERROR );
		}

		$this->queryString .= "&order=";
		$this->queryString .= $order;
		return $this;
	}


	public function query( $query )
	{
		if( is_null( $query ) )
			return $this;

		$this->queryString .= "&query=";
		$this->queryString .= $query;
		return $this;
	}


	public function rewardIds( $rewardIds )
	{
		if( is_null( $rewardIds ) || !is_array( $rewardIds ) || empty( $rewardIds ) )
			return $this;

		foreach( $rewardIds as $rewardId ) {
			$this->queryString .= "&rewardIds=";
			$this->queryString .= $rewardId;
		}
		return $this;
	}


	public function behaviourIds( $behaviourIds )
	{
		if( is_null( $behaviourIds ) || !is_array( $behaviourIds ) || empty( $behaviourIds ) )
			return $this;

		foreach( $behaviourIds as $behaviourId ) {
			$this->queryString .= "&behaviourIds=";
			$this->queryString .= $behaviourId;
		}
		return $this;
	}


	public function build()
	{
		if( is_null( $this->url ) ) {
			trigger_error( "Did you forget to add a URL?", E_USER_ERROR );
		}

		return $this->url . $this->getFormattedQueryString();
	}


	private function getFormattedQueryString()
	{
		if( empty( $this->queryString ) )
			return "";
			
		return preg_replace( '/&/', '?', $this->queryString, 1 );
	}
}
?>