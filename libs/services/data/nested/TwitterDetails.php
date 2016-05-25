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
 * order to associate an Twitter details to a UserRequestData.
 */
class TwitterDetails
{
	private $data = array();
	
	/**
	 * The user's Twitter ID.
	 * @return
	 */
	public function getTwitterId() { return $this->data['twitterId']; }
	public function setTwitterId( $twitterId ) { $this->data['twitterId'] = $twitterId; }
	
	/**
	 * The URL to the user's Twitter page, for example: http://www.twitter.com/rogerrabbit
	 * @return
	 */
	public function getTwitterUrl() { return $this->data['twitterUrl']; }
	public function setTwitterUrl( $twitterUrl ) { $this->data['twitterUrl'] = $twitterUrl; }
	
	/**
	 * The user's Twitter Username.
	 * @return
	 */
	public function getTwitterUser() { return $this->data['twitterUser']; }
	public function setTwitterUser( $twitterUser ) { $this->data['twitterUser'] = $twitterUser; }
	
	/**
	 * Returns the current model as an array ready to
	 * be json_encoded
	 */
	public function getJsonArray()
	{
		return $this->data;
	}
}
?>