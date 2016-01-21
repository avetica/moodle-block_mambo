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
 * This object captures the data required by the Transaction API in
 * order to reject the specified transaction.
 */
class RejectTransactionRequestData
{
	private $data = array();
	
	/**
	 * The reason why the transaction was rejected. This is used to give the user
	 * insight as to why the transaction was rejected.
	 */
	public function getReason() { return $this->data['reason']; }
	public function setReason( $reason ) { $this->data['reason'] = $reason; }
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonString()
	{
		return json_encode( $this->data );
	}
}
?>