<?php
//test successful
$I = new ApiTester($scenario);
$I->wantTo('register a user via API');
$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendPOST(
    '/v1/authorize',
    [
        'login'=> '123',
        'pwd' => '45'
    ]);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED); // 401
$I->seeResponseIsJson();
$I->seeResponseContains('{"Result":0,"Details":"Failed to authorize"}');
?>