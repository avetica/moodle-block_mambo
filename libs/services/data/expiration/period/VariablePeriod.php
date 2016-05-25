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
 * The VariablePeriod is used in order to define the
 * period of time after which an objects expiration needs
 * to be processed.
 */
class VariablePeriod
{
	private $data = array();


	/**
	 * The type indicates the period's units of measure.
	 * Valid types include: days, weeks, months and years.
	 * This field cannot be null.
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getType() { return $this->data['type']; }
	public function setType( $type ) { $this->data['type'] = $type; }


	/**
	 * The value is the number of units of measure after which
	 * the expiration should take place. For example: if the type
	 * is months and the value is 12, then the expiration will take
	 * place after 12 months.
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getValue() { return $this->data['value']; }
	public function setValue( $value ) { $this->data['value'] = $value; }
	
	
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