<?php
//test: user age must be over 21 year for successful registration - test for border: 21 - should valid
$I = new ApiTester($scenario);
$I->wantTo('register a user via API');
$I->haveHttpHeader('Content-Type', 'application/json');
$email = time() . '@mail.com';
//get date = current one - 20 years
$time = strtotime("-21 year", time());
$date = date(DATE_ATOM, $time);
$I->sendPOST(
    '/v1/register',
    [
        'email' => $email,
        'phone' => '+371 6111111',
        'pwd' => '111aaa',
        'birthDate' => $date,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
        'address' => [
            'country' => 'US',
            'city' => 'New York',
            'state' => 'John Doe',
            'zip' => 'LV-1011',
            'street' => 'Ropazu 10']
    ]);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();
$I->seeResponseContains('{"Result":true,"Details":"none"}');
?>