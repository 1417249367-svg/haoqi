<?php
/**
Copyright 2020. Huawei Technologies Co., Ltd. All rights reserved.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
 */

/**
 * function: two kinds of method to send notification msg: 
 *              1) sendPushMsgMessageByMsgType(code class object);
 *              2) sendPushMsgRealMessage(text msg)
 */
include_once (dirname(__FILE__) . '/push_common/test_sample_push_msg_common.php');
include_once (dirname(__FILE__) . '/../push_admin/Constants.php');
use push_admin\Constants;

//HuaweiPushSingleDeviceNotification("0862537032636308300002744700CN01",1,"fg","hgfh");
function HuaweiPushSingleDeviceNotification($CID,$PlatForm,$FcName,$UserText)
{
$testPushMsgSample = new TestPushMsgCommon();
$testPushMsgSample->sendPushMsgMessageByMsgType(Constants::PUSHMSG_NOTIFICATION_MSG_TYPE);


$message = '{
	"notification": {
		"title": "'.$FcName.'",
		"body": "'.$UserText.'"
	},
	"android": {
		"category": "IM",
		"notification": {
			"click_action": {
				"type": 3
			}
    
		}
	},
	"token": ["'.$CID.'"]
}';


$testPushMsgSample->sendPushMsgRealMessage(json_decode($message));

}

function HuaweiPushDeviceListMultipleNotification($CID,$PlatForm,$FcName,$UserText)
{
$testPushMsgSample = new TestPushMsgCommon();
$testPushMsgSample->sendPushMsgMessageByMsgType(Constants::PUSHMSG_NOTIFICATION_MSG_TYPE);
$deviceList=join('","', $CID);

$message = '{
	"notification": {
		"title": "'.$FcName.'",
		"body": "'.$UserText.'"
	},
	"android": {
		"category": "IM",
		"notification": {
			"click_action": {
				"type": 3
			}
    
		}
	},
	"token": ["'.$deviceList.'"]
}';


$testPushMsgSample->sendPushMsgRealMessage(json_decode($message));

}