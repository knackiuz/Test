<?php
//test: birth date is obligate field
$I = new ApiTester($scenario);
$I->wantTo('register a user via API');
$I->haveHttpHeader('Content-Type', 'application/json');
$email = time() . '@mail.com';
$I->sendPOST(
    '/v1/register',
    [
        'email' => $email,
        'phone' => '+371 6111111',
        'pwd' => '111aaa',
        //'birthDate' => '1988-06-25T00:00:00.000Z',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
        'address' => [
            'country' => 'US',
            'city' => 'New York',
            'state' => 'John Doe',
            'zip' => 'LV-1011',
            'street' => 'Ropazu 10']
    ]);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); // 400
$I->seeResponseIsJson();
$I->seeResponseContains('{"Result":0,"Details":"Field birthDate missed"}');
?>