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
 * order to associate activity stream text to a BehaviourRequestData.
 */
class ActivityStream
{
	private $data = array();


	/**
	 * The text that prefixes the content object in the activity stream.
	 * The activity stream has the following format:
	 * User [contentPrefix] content-object [targetPrefix] target-object
	 * For example: John Doe [has posted] an article [to their] wall
	 * See the behaviours page in administration panel for more information.
	 * @return
	 */
	public function getContentPrefix() { return $this->data['contentPrefix']; }
	public function setContentPrefix( $contentPrefix ) { $this->data['contentPrefix'] = $contentPrefix; }


	/**
	 * The text that prefixes the target object in the activity stream.
	 * The activity stream has the following format:
	 * User [contentPrefix] content-object [targetPrefix] target-object
	 * For example: John Doe [has posted] an article [to their] wall
	 * See the behaviours page in administration panel for more information.
	 * @return
	 */
	public function getTargetPrefix() { return $this->data['targetPrefix']; }
	public function setTargetPrefix( $targetPrefix ) { $this->data['targetPrefix'] = $targetPrefix; }
	
	
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