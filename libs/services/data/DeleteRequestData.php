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
 * This object captures the data required by the APIs in
 * order to delete multiple models simultaneously.
 */
class DeleteRequestData
{
	private $ids = array();

	
	/**
	 * The ID of the models that are to be deleted.
	 * The ID corresponds to the $model->id property
	 */
	public function setIds( array $ids ) { $this->ids = $ids; }
	public function addId( $id ) { array_push( $this->ids, (string) $id ); }
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonString()
	{
		return json_encode( array( 'ids' => $this->ids ) );
	}
}
?>