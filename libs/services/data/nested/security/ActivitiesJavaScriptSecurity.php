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
 * This class encapsulates data related to the security of the
 * activities JavaScript API.
 */
class ActivitiesJavaScriptSecurity
{
	private $data = array();


	/**
	 * Whether behaviour activities can be created via the JavaScript API
	 * @return
	 */
	public function getCanCreateBehaviour() { return $this->data['canCreateBehaviour']; }
	public function setCanCreateBehaviour( $canCreateBehaviour ) { $this->data['canCreateBehaviour'] = $canCreateBehaviour; }


	/**
	 * Whether coupon redeem activities can be created via the JavaScript API
	 * @return
	 */
	public function getCanRedeemCoupon() { return $this->data['canRedeemCoupon']; }
	public function setCanRedeemCoupon( $canRedeemCoupon ) { $this->data['canRedeemCoupon'] = $canRedeemCoupon; }


	/**
	 * Whether coupon refund activities can be created via the JavaScript API
	 * @return
	 */
	public function getCanRefundCoupon() { return $this->data['canRefundCoupon']; }
	public function setCanRefundCoupon( $canRefundCoupon ) { $this->data['canRefundCoupon'] = $canRefundCoupon; }


	/**
	 * Whether point increment activities can be created via the JavaScript API
	 * @return
	 */
	public function getCanIncrementPoints() { return $this->data['canIncrementPoints']; }
	public function setCanIncrementPoints( $canIncrementPoints ) { $this->data['canIncrementPoints'] = $canIncrementPoints; }


	/**
	 * Whether point redeem can be created via the JavaScript API
	 * @return
	 */
	public function getCanRedeemPoints() { return $this->data['canRedeemPoints']; }
	public function setCanRedeemPoints( $canRedeemPoints ) { $this->data['canRedeemPoints'] = $canRedeemPoints; }


	/**
	 * Whether point refund can be created via the JavaScript API
	 * @return
	 */
	public function getCanRefundPoints() { return $this->data['canRefundPoints']; }
	public function setCanRefundPoints( $canRefundPoints ) { $this->data['canRefundPoints'] = $canRefundPoints; }


	/**
	 * Whether bounty start activities can be created via the JavaScript API
	 * @return
	 */
	public function getCanStartBounty() { return $this->data['canStartBounty']; }
	public function setCanStartBounty( $canStartBounty ) { $this->data['canStartBounty'] = $canStartBounty; }


	/**
	 * Whether bounty award activities can be created via the JavaScript API
	 * @return
	 */
	public function getCanAwardBounty() { return $this->data['canAwardBounty']; }
	public function setCanAwardBounty( $canAwardBounty ) { $this->data['canAwardBounty'] = $canAwardBounty; }


	/**
	 * Whether bounty cancel activities can be created via the JavaScript API
	 * @return
	 */
	public function getCanCancelBounty() { return $this->data['canCancelBounty']; }
	public function setCanCancelBounty( $canCancelBounty ) { $this->data['canCancelBounty'] = $canCancelBounty; }


	/**
	 * Whether gift activities can be created via the JavaScript API
	 * @return
	 */
	public function getCanCreateGift() { return $this->data['canCreateGift']; }
	public function setCanCreateGift( $canCreateGift ) { $this->data['canCreateGift'] = $canCreateGift; }

	
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