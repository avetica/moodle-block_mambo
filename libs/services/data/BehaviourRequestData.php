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
 * This object captures the data required by the Behaviour API in
 * order to create / update behaviours.
 */
class BehaviourRequestData extends AbstractHasTagRequestData
{

	/**
	 * Whether the image associated to the Behaviour should be removed
	 * @return boolean removeImage
	 */
	public function getRemoveImage() { return $this->data['removeImage']; }
	public function setRemoveImage( $removeImage ) { $this->data['removeImage'] = $removeImage; }

	/**
	 * The Behaviour's name
	 * @return
	 */
	public function getName() { return $this->data['name']; }
	public function setName( $name ) { $this->data['name'] = $name; }

	/**
	 * The Behaviour's verb. This is used when tracking an
	 * event.
	 * @return
	 */
	public function getVerb() { return $this->data['verb']; }
	public function setVerb( $verb ) { $this->data['verb'] = $verb; }

	/**
	 * The Behaviour's points. The points will assigned to a
	 * user who performs this behaviour.
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
	 * The Behaviour's coolOff period. The time in seconds which must
	 * elapse before the user can earn points for this behaviour again.
	 * @return
	 */
	public function getCoolOff() { return $this->data['coolOff']; }
	public function setCoolOff( $coolOff ) { $this->data['coolOff'] = $coolOff; }

	/**
	 * The Behaviour's hint. This is displayed to the end user when you
	 * wish to make them aware of what behaviours you are rewarding.
	 * @return
	 */
	public function getHint() { return $this->data['hint']; }
	public function setHint( $hint ) { $this->data['hint'] = $hint; }

	/**
	 * Whether the Behaviour's hint should be shown or not.
	 * @return
	 */
	public function getHideHint() { return $this->data['hideHint']; }
	public function setHideHint( $hideHint ) { $this->data['hideHint'] = $hideHint; }

	/**
	 * Whether the Behaviour can be tracked directly through the Events JavaScript API
	 * @return
	 */
	public function getJsTrackable() { return $this->data['jsTrackable']; }
	public function setJsTrackable( $jsTrackable ) { $this->data['jsTrackable'] = $jsTrackable; }

	/**
	 * Indicates that this behaviour should be awarded to a user only if one of the
	 * following criteria is matched: 
	 * 1) User and Behaviour have at least one personalization tag that matches
	 * 2) Behaviour has no personalization tags
	 * 3) User has no personalization tags
	 * @return
	 */
	public function getTagFilter() { return $this->data['tagFilter']; }
	public function setTagFilter( $tagFilter ) { $this->data['tagFilter'] = $tagFilter; }

	/**
	 * The attributes of the behaviour. There are currently two types of
	 * attributes: SimpleAttrs and FlexibleAttrs.
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
	 * The activity object is used to define the text to be used
	 * in the activity stream.
	 * @return
	 */
	public function getActivity() { return $this->data['activity']; }
	public function setActivity( Activity $activity ) {
		if( !is_null( $activity ) )
			$this->data['activity'] = $activity->getJsonArray();
		else
			$this->data['activity'] = $activity;
	}
}
?>