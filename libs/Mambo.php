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
 * Import all the relevant Mambo PHP SDK files.
 */

// Require all common Mambo classes
require_once(dirname(__FILE__) . '/common/OAuth.php');
require_once(dirname(__FILE__) . '/common/Client.php');
require_once(dirname(__FILE__) . '/common/BaseAbstract.php');

// Require all API related classes
require_once(dirname(__FILE__) . '/services/ActivitiesService.php');
require_once(dirname(__FILE__) . '/services/BehavioursService.php');
require_once(dirname(__FILE__) . '/services/CouponsService.php');
require_once(dirname(__FILE__) . '/services/EventsService.php');
require_once(dirname(__FILE__) . '/services/LeaderboardsService.php');
require_once(dirname(__FILE__) . '/services/NotificationsService.php');
require_once(dirname(__FILE__) . '/services/PointsService.php');
require_once(dirname(__FILE__) . '/services/PurchasesService.php');
require_once(dirname(__FILE__) . '/services/RewardsService.php');
require_once(dirname(__FILE__) . '/services/SitesService.php');
require_once(dirname(__FILE__) . '/services/TransactionsService.php');
require_once(dirname(__FILE__) . '/services/UsersService.php');

// Services data
require_once(dirname(__FILE__) . '/services/data/BehaviourRequestData.php');
require_once(dirname(__FILE__) . '/services/data/ClearNotificationsRequestData.php');
require_once(dirname(__FILE__) . '/services/data/CouponRequestData.php');
require_once(dirname(__FILE__) . '/services/data/CouponUserRequestData.php');
require_once(dirname(__FILE__) . '/services/data/DeleteRequestData.php');
require_once(dirname(__FILE__) . '/services/data/EventRequestData.php');
require_once(dirname(__FILE__) . '/services/data/LeaderboardRequestData.php');
require_once(dirname(__FILE__) . '/services/data/PointRequestData.php');
require_once(dirname(__FILE__) . '/services/data/PurchaseRequestData.php');
require_once(dirname(__FILE__) . '/services/data/RejectTransactionRequestData.php');
require_once(dirname(__FILE__) . '/services/data/RewardRequestData.php');
require_once(dirname(__FILE__) . '/services/data/SiteRequestData.php');
require_once(dirname(__FILE__) . '/services/data/TransactionRequestData.php');
require_once(dirname(__FILE__) . '/services/data/UserRequestData.php');

require_once(dirname(__FILE__) . '/services/data/nested/SimplePoint.php');
require_once(dirname(__FILE__) . '/services/data/nested/ExpiringPoint.php');
require_once(dirname(__FILE__) . '/services/data/nested/SimpleExpiration.php');
require_once(dirname(__FILE__) . '/services/data/nested/PeriodicExpiration.php');
require_once(dirname(__FILE__) . '/services/data/nested/Period.php');
require_once(dirname(__FILE__) . '/services/data/nested/FacebookDetails.php');
require_once(dirname(__FILE__) . '/services/data/nested/MonetaryValues.php');
require_once(dirname(__FILE__) . '/services/data/nested/Product.php');
require_once(dirname(__FILE__) . '/services/data/nested/TwitterDetails.php');
require_once(dirname(__FILE__) . '/services/data/nested/Units.php');
require_once(dirname(__FILE__) . '/services/data/nested/UserDetails.php');

require_once(dirname(__FILE__) . '/services/data/attributes/SimpleAttrs.php');
require_once(dirname(__FILE__) . '/services/data/attributes/FlexibleAttrs.php');
require_once(dirname(__FILE__) . '/services/data/attributes/AchievementAttrs.php');
require_once(dirname(__FILE__) . '/services/data/attributes/LevelAttrs.php');
require_once(dirname(__FILE__) . '/services/data/attributes/MissionAttrs.php');
require_once(dirname(__FILE__) . '/services/data/attributes/BountyTransactionAttrs.php');
require_once(dirname(__FILE__) . '/services/data/attributes/GiftedTransactionAttrs.php');
require_once(dirname(__FILE__) . '/services/data/attributes/ManualTransactionAttrs.php');