<?php
/**
 * Created by PhpStorm.
 * User: d.granovskis
 * Date: 2018.01.22.
 * Time: 12:05
 */

require_once ('RequestAuthorization.php');
require_once ('RequestRegistration.php');

class TestsCest
{
    function testAuthorizationFailedCept(ApiTester $I){
        //test: failed to authorize
        $requestAuthorization = new RequestAuthorization();
        $I->wantTo('register a user via API');
        $I->haveHttpHeader($requestAuthorization->getHttpHeaderContentType(), $requestAuthorization->getHttpHeaderApplicationType());
        $requestAuthorization->setLogin('123');
        $requestAuthorization->setPassword('45');
        $I->sendPOST($requestAuthorization->getPostData());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED); // 401
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"Result":0,"Details":"Failed to authorize"}');
    }

    function testBirthDateObligateCept(ApiTester $I) {
        //test: birth date is obligate field
        $I->wantTo('register a user via API');
        $I->haveHttpHeader(RequestRegistration::getHttpHeaderContentType(), RequestRegistration::getHttpHeaderApplicationType());
        $email = time() . '@mail.com';

        RequestRegistration::setData($email, '+371 6111111', '111aaa', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua');
        RequestRegistration::setAddress('US', 'New York', 'John Doe', 'LV-1011', 'Ropazu 10');

        $I->sendPOST(RequestRegistration::getPostData());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); // 400
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"Result":0,"Details":"Field birthDate missed"}');
    }

    function testDescriptionFieldObligateCept(ApiTester $I){
        //test: description is obligate field
        $I->wantTo('register a user via API');
        $I->haveHttpHeader(RequestRegistration::getHttpHeaderContentType(), RequestRegistration::getHttpHeaderApplicationType());
        $email = time() . '@mail.com';

        RequestRegistration::setData($email, '+371 6111111', '111aaa', '1988-06-25T00:00:00.000Z', null);
        RequestRegistration::setAddress('US', 'New York', 'John Doe', 'LV-1011', 'Ropazu 10');

        $I->sendPOST(RequestRegistration::getPostData());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); // 400
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"Result":0,"Details":"Field description missed"}');
    }

    function testEmailFieldObligateCept(ApiTester $I){
        //test: email is obligate field
        $I->wantTo('register a user via API');
        $I->haveHttpHeader(RequestRegistration::getHttpHeaderContentType(), RequestRegistration::getHttpHeaderApplicationType());

        RequestRegistration::setData(null, '+371 6111111', '111aaa', '1988-06-25T00:00:00.000Z', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua');
        RequestRegistration::setAddress('US', 'New York', 'John Doe', 'LV-1011', 'Ropazu 10');

        $I->sendPOST(RequestRegistration::getPostData());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); // 400
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"Result":0,"Details":"Field email missed"}');
    }

    function testNotObligateFieldsCept(ApiTester $I){
        //test for not obligate fields: Country-city-state-zip-street. state not obligate
        $I->wantTo('register a user via API');
        $I->haveHttpHeader(RequestRegistration::getHttpHeaderContentType(), RequestRegistration::getHttpHeaderApplicationType());
        $email = time() . '@mail.com';

        RequestRegistration::setData($email, '+371 6111111', '111aaa', '1988-06-25T00:00:00.000Z', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua');
        RequestRegistration::setAddress(null, null, null, null, null);

        $I->sendPOST(RequestRegistration::getPostData());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"Result":true,"Details":"none"}');
    }

    function testPasswordFieldValidationCept(ApiTester $I){
        //test: Password should contain digits and latin letters only
        $I->wantTo('register a user via API');
        $I->haveHttpHeader(RequestRegistration::getHttpHeaderContentType(), RequestRegistration::getHttpHeaderApplicationType());
        $email = time() . '@mail.com';

        RequestRegistration::setData($email, '+371 6111111', '111aaa@', '1988-06-25T00:00:00.000Z', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua');
        RequestRegistration::setAddress('US', 'New York', 'John Doe', 'LV-1011', 'Ropazu 10');

        $I->sendPOST(RequestRegistration::getPostData());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); // 400
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"Result":0,"Details":"Field pwd bad format"}');
    }

    function testSuccessRegistrationCept(ApiTester $I){
        //test successful registration
        $I->wantTo('register a user via API');
        $I->haveHttpHeader(RequestRegistration::getHttpHeaderContentType(), RequestRegistration::getHttpHeaderApplicationType());
        $email = time() . '@mail.com';

        RequestRegistration::setData($email, '+371 6111111', '111aaa', '1988-06-25T00:00:00.000Z', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua');
        RequestRegistration::setAddress('US', 'New York', 'John Doe', 'LV-1011', 'Ropazu 10');

        $I->sendPOST(RequestRegistration::getPostData());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"Result":true,"Details":"none"}');
    }

    function testUserAge20Cept(ApiTester $I){
        //test: user age must be over 21 year for successful registration - test for border: 20 - not valid
        //$I = new ApiTester($scenario);
        $I->wantTo('register a user via API');
        $I->haveHttpHeader(RequestRegistration::getHttpHeaderContentType(), RequestRegistration::getHttpHeaderApplicationType());
        $email = time() . '@mail.com';
        //get date = current one - 20 years
        $time = strtotime("-20 year", time());
        $date = date(DATE_ATOM, $time);

        RequestRegistration::setData($email, '+371 6111111', '111aaa', $date, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua');
        RequestRegistration::setAddress('US', 'New York', 'John Doe', 'LV-1011', 'Ropazu 10');

        $I->sendPOST(RequestRegistration::getPostData());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); // 400
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"Result":0,"Details":"Field birthDate bad format"}');
    }

    function testUserAge21Cept(ApiTester $I){
        //test: user age must be over 21 year for successful registration - test for border: 21 - should valid
        //$I = new ApiTester($scenario);
        $I->wantTo('register a user via API');
        $I->haveHttpHeader(RequestRegistration::getHttpHeaderContentType(), RequestRegistration::getHttpHeaderApplicationType());
        $email = time() . '@mail.com';
        //get date = current one - 20 years
        $time = strtotime("-21 year", time());
        $date = date(DATE_ATOM, $time);

        RequestRegistration::setData($email, '+371 6111111', '111aaa', $date, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua');
        RequestRegistration::setAddress('US', 'New York', 'John Doe', 'LV-1011', 'Ropazu 10');

        $I->sendPOST(RequestRegistration::getPostData());
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"Result":true,"Details":"none"}');
    }
}