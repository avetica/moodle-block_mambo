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
 * This object captures the data required by the Site API in
 * order to create / update sites.
 */
class SiteRequestData
{
	private $data = array();
	
	/**
	 * The name by which this site network is known.
	 * @return string name
	 */
	public function getName() { return $this->data['name']; }
	public function setName( $name ) { $this->data['name'] = $name; }
	
	
	/**
	 * The URL for this specific site network. URLs do not
	 * have to be legitimate domain names. The URLs should
	 * be easily understandable. For example: 
	 * development.acme.com
	 * staging.acme.com
	 * live.acme.com
	 * @return string url
	 */
	public function getUrl() { return $this->data['url']; }
	public function setUrl( $url ) { $this->data['url'] = $url; }
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonString()
	{
		return json_encode( $this->data );
	}
}
?>