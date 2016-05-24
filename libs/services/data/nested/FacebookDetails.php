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
 * order to associate an Facebook details to a UserRequestData.
 */
class FacebookDetails
{
	private $data = array();
	
	/**
	 * The user's Facebook ID.
	 * @return
	 */
	public function getFacebookId() { return $this->data['facebookId']; }
	public function setFacebookId( $facebookId ) { $this->data['facebookId'] = $facebookId; }
	
	/**
	 * The URL to the user's Facebook profile, for example: 
	 * http://www.facebook.com/roger.rabbit or http://www.facebook.com/s0m3r34llyB4dC0d3
	 * @return
	 */
	public function getFacebookUrl() { return $this->data['facebookUrl']; }
	public function setFacebookUrl( $facebookUrl ) { $this->data['facebookUrl'] = $facebookUrl; }
	
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