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
 * This object captures the data required by the User API in
 * order to create or update a User.
 */
class UserRequestData extends AbstractHasTagRequestData
{
	/**
	 * The Unique User ID of the User. This parameter uniquely identifies this 
	 * user in the system and is used in a number of user related API calls. 
	 * You should use the value you currently use and store to identify unique 
	 * users in your system as this will facilitate the retrieval of that user's 
	 * information. A good example would be the use of an email: user@acme.com. 
	 * If you don't like the idea of using the email in the API URIs, then you 
	 * could encode the email, for example: TWFuIGlzIGRpc3@acme.com.
	 * @return
	 */
	public function getUuid() { return $this->data['uuid']; }
	public function setUuid( $uuid ) { $this->data['uuid'] = $uuid; }
	
	/**
	 * Whether the user is taking part in the rewards program. By default
	 * all user's are active members of the rewards program. However, this can be set
	 * to false and the users can be explicitly asked to take part in the rewards program.
	 * @return
	 */
	public function getIsMember() { return $this->data['isMember']; }
	public function setIsMember( $isMember ) { $this->data['isMember'] = $isMember; }
	
	/**
	 * The URL of the user's profile picture. This should be a fully qualified 
	 * URL, for example: http://www.acme.com/user.png.
	 * @return
	 */
	public function getPictureUrl() { return $this->data['pictureUrl']; }
	public function setPictureUrl( $pictureUrl ) { $this->data['pictureUrl'] = $pictureUrl; }
	
	/**
	 * The URL of the user's profile. This should be a fully qualified 
	 * URL, for example: http://www.acme.com/user
	 * @return
	 */
	public function getProfileUrl() { return $this->data['profileUrl']; }
	public function setProfileUrl( $profileUrl ) { $this->data['profileUrl'] = $profileUrl; }

	/**
	 * The user's details. This includes email, first name, last name, etc.
	 * @return
	 */
	public function getDetails() { return $this->data['details']; }
	public function setDetails( UserDetails $userDetails ) { 
		if( !is_null( $userDetails ) )
			$this->data['details'] = $userDetails->getJsonArray();
		else
			$this->data['details'] = $userDetails;
	}

	/**
	 * The user's Facebook details.
	 * @return
	 */
	public function getFacebook() { return $this->data['facebook']; }
	public function setFacebook( FacebookDetails $facebookDetails ) {
		if( !is_null( $facebookDetails ) )
			$this->data['facebook'] = $facebookDetails->getJsonArray();
		else
			$this->data['facebook'] = $facebookDetails;
	}

	/**
	 * The user's Twitter details.
	 * @return
	 */
	public function getTwitter() { return $this->data['twitter']; }
	public function setTwitter( TwitterDetails $twitterDetails ) {
		if( !is_null( $twitterDetails ) )
			$this->data['twitter'] = $twitterDetails->getJsonArray();
		else
			$this->data['twitter'] = $twitterDetails;
	}
}
?>