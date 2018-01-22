<?php
/**
 * Created by PhpStorm.
 * User: d.granovskis
 * Date: 2018.01.22.
 * Time: 12:26
 */

class RequestAuthorization
{
    private $httpHeaderContentType = '\'Content-Type\'';
    private $httpHeaderApplicationType = '\'application/json\'';
    private $url = '/v1/authorize';
    private $login;
    private $password;

    function getHttpHeaderContentType() {
        return $this->httpHeaderContentType;
    }

    function getHttpHeaderApplicationType() {
        return $this->httpHeaderApplicationType;
    }

    function getPostData(){
        $postData = $this->url . ',
        [
            \'login\'=> \'' . $this->login . '\',
            \'pwd\' => \'' . $this->password . '\'
        ]';
        return $postData;
    }

    function setLogin($login){
        $this->login = $login;
    }

    function setPassword($password){
        $this->password = $password;
    }
}