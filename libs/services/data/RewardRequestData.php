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
 * This object captures the data required by the Reward API in
 * order to create / update rewards.
 */
class RewardRequestData extends AbstractHasTagRequestData
{

	/**
	 * Whether the image associated to the Behaviour should be removed
	 * @return boolean removeImage
	 */
	public function getRemoveImage() { return $this->data['removeImage']; }
	public function setRemoveImage( $removeImage ) { $this->data['removeImage'] = $removeImage; }

	/**
	 * The name of the reward. See the achievement or level pages in
	 * administration panel for more information.
	 * @return
	 */
	public function getName() { return $this->data['name']; }
	public function setName( $name ) { $this->data['name'] = $name; }

	/**
	 * Indicates whether the reward is active or not. See the achievement
	 * or level pages in administration panel for more information.
	 * @return
	 */
	public function getActive() { return $this->data['active']; }
	public function setActive( $active ) { $this->data['active'] = $active; }

	/**
	 * The message associated with the reward. See the achievement or
	 * level pages in administration panel for more information.
	 * @return
	 */
	public function getMessage() { return $this->data['message']; }
	public function setMessage( $message ) { $this->data['message'] = $message; }

	/**
	 * The hint associated with the reward. See the achievement or level
	 * pages in administration panel for more information.
	 * @return
	 */
	public function getHint() { return $this->data['hint']; }
	public function setHint( $hint ) { $this->data['hint'] = $hint; }

	/**
	 * Indicates whether the reward's hint should be hidden or not. See the
	 * achievement or level pages in administration panel for more information.
	 * @return
	 */
	public function getHideHint() { return $this->data['hideHint']; }
	public function setHideHint( $hideHint ) { $this->data['hideHint'] = $hideHint; }

	/**
	 * The Reward's points. The points will assigned to a
	 * user who unlocks this reward.
	 * @return
	 */
	public function getPoints() { return $this->data['points']; }
	public function setPoints( array $points ) {
		if( is_null( $points ) ) {
			$this->data['points'] = $points;
			return;
		}
		
		$this->data['points'] = array();
		foreach( $points as $point ) {
			array_push( $this->data['points'], $point->getJsonArray() );
		}
	}
	public function addPoints( ExpiringPoint $point ) {
		if( !isset( $this->data['points'] ) )
			$this->data['points'] = array();
		
		if( !is_null( $point ) )
			array_push( $this->data['points'], $point->getJsonArray() );
		else
			array_push( $this->data['points'], $point );
	}

	/**
	 * This represents the date from which this reward can be unlocked by users.
	 * If no date is specified, the reward can always be unlocked.
	 * This must be a UTC timestamp in ISO 8601 format with
	 * millisecond precision: YYYY-MM-DDTHH:MM:SS.MMMZ.
	 * See the achievement or level pages in administration panel for more information.
	 * @return
	 */
	public function getStartDate() { return $this->data['startDate']; }
	public function setStartDate( $startDate ) { $this->data['startDate'] = $startDate; }

	/**
	 * This represents the date from which this reward can no longer be unlocked by users
	 * If no date is specified, the reward can always be unlocked.
	 * This must be a UTC timestamp in ISO 8601 format with
	 * millisecond precision: YYYY-MM-DDTHH:MM:SS.MMMZ.
	 * See the achievement or level pages in administration panel for more information.
	 * @return
	 */
	public function getEndDate() { return $this->data['endDate']; }
	public function setEndDate( $endDate ) { $this->data['endDate'] = $endDate; }

	/**
	 * The attributes of the reward. There are currently three types of
	 * attributes: AchievementAttrs, LevelAttrs and MissionAttrs.
	 * @return
	 */
	public function getAttrs() { return $this->data['attrs']; }
	public function setAttrs( $attrs ) {
		if( !is_null( $attrs ) )
			$this->data['attrs'] = $attrs->getJsonArray();
		else
			$this->data['attrs'] = $attrs;
	}

	/**
	 * If this reward has an associated coupon, this should contain
	 * the coupon's ID.
	 * @return
	 */
	public function getCouponId() { return $this->data['couponId']; }
	public function setCouponId( $couponId ) { $this->data['couponId'] = (string) $couponId; }

	/**
	 * If this reward has an associated coupon, this determines if
	 * the coupon information should be displayed in the widgets.
	 * If this is set to false then the coupon model should be null.
	 * @return
	 */
	public function getHideCoupon() { return $this->data['hideCoupon']; }
	public function setHideCoupon( $hideCoupon ) { $this->data['hideCoupon'] = $hideCoupon; }
}
?>