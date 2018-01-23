<?php
/**
 * Created by PhpStorm.
 * User: d.granovskis
 * Date: 2018.01.22.
 * Time: 15:02
 */

class RequestRegistration
{
    static $httpHeaderContentType = '\'Content-Type\'';
    static $httpHeaderApplicationType = '\'application/json\'';
    static $url = '/v1/register';
    static $email;
    static $phone;
    static $pwd;
    static $birthDate;
    static $description;

    static $country;
    static $city;
    static $state;
    static $zip;
    static $street;

    static function setData($email, $phone, $pwd, $birthDate, $description){
        self::$email = $email;
        self::$phone = $phone;
        self::$pwd = $pwd;
        self::$birthDate = $birthDate;
        self::$description = $description;
    }

    static function setAddress($country, $city, $state, $zip, $street){
        self::$country = $country;
        self::$city = $city;
        self::$state = $state;
        self::$zip = $zip;
        self::$street = $street;
    }

    static function getPostData(){
    $postData = self::$url . ', [';

    if (self::$email <> null) {
        $postData = $postData . '\'email\' => ' . self::$email .',';
    }

    if (self::$phone <> null) {
        $postData = $postData . '\'phone\' => \'' . self::$phone . '\',';
    }

    if (self::$pwd <> null) {
        $postData = $postData . '\'pwd\' => \'' . self::$pwd . '\',';
    }

    if (self::$birthDate <> null) {
        $postData = $postData . '\'birthDate\' => \'' . self::$birthDate . '\',';
    }

    if (self::$description <> null) {
        $postData = $postData . '\'description\' => \'' . self::$description . '\',';
    }

    if (self::$country <> null) {
        $postData = $postData . '\'address\' => [
                    \'country\' => \'' . self::$country . '\',
                    \'city\' => \'' . self::$city . '\',
                    \'state\' => \'' . self::$state . '\',
                    \'zip\' => \'' . self::$zip . '\',
                    \'street\' => \'' . self::$street . '\']';
    }

    $postData = $postData . ']';

    return $postData;

    /*
    '/v1/register',
            [
                'email' => $email,
                'phone' => '+371 6111111',
                'pwd' => '111aaa',
                'birthDate' => '1988-06-25T00:00:00.000Z',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'address' => [
                    'country' => 'US',
                    'city' => 'New York',
                    'state' => 'John Doe',
                    'zip' => 'LV-1011',
                    'street' => 'Ropazu 10']
            ]
    */
    }
}