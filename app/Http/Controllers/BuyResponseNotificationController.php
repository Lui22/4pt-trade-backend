<?php

namespace App\Http\Controllers;

use App\Events\RequestApprovedEvent;
use Illuminate\Http\Request;

class BuyResponseNotificationController extends Controller
{
    public static function notify($userId)
    {
        event(new RequestApprovedEvent($userId));

        $beamsClient = new \Pusher\PushNotifications\PushNotifications(array(
            "instanceId" => "7ac2a7b7-28ce-4f85-a2e8-5dedbbe91c0e",
            "secretKey" => "CEEBC8BCF2E79172691B33FF1B2E4C173ECC7C0A55328FEC19E871A23EBF2412",
        ));

        $publishResponse = $beamsClient->publish(
            array($userId."-approved"),
            array("fcm" => array("notification" => array(
                "title" => "Hello",
                "body" => "Hello, World!",
            )),
            ));
    }
}
