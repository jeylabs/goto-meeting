<?php

namespace Jeylabs\GoToMeeting;

use GuzzleHttp\Client;

/**
 * Class GoToMeeting
 * @package Jeylabs\GoToMeeting
 */
class GoToMeeting
{
    const SUBSCRIBE_USER = 'api/subscribe-user';
    const DEFAULT_TIMEOUT = 15;
    /**
     * @var array
     */
    protected $headers = [];
    /**
     * @var Client
     */
    protected $client;
    private $user;
    private $password;
    private $consumerKey;
    private $consumerSecret;
    private $accessToken;

    /**
     * GoToMeeting constructor.
     * @param $user
     * @param $password
     * @param $consumerKey
     * @param $consumerSecret
     * @param null $client
     */
    public function __construct($user, $password, $consumerKey, $consumerSecret, $client = null)
    {
        $this->headers = ['verify' => false];
        $this->client = $client ?: new Client([
            'base_uri' => "https://api.getgo.com/",
            'timeout' => self::DEFAULT_TIMEOUT,
            'connect_timeout' => self::DEFAULT_TIMEOUT,
        ]);
        $this->user = $user;
        $this->password = $password;
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
    }

    public function authenticate()
    {
        $authorization = base64_encode($this->consumerKey . ":" . $this->consumerSecret);
        $response = $this->client->post('oauth/v2/token', [
            'headers' => [
                'Content-Type' => "application/x-www-form-urlencoded",
                'Authorization' => "Basic $authorization"
            ],
            'body' => [
                "grant_type" => 'password',
                "username" => $this->user,
                "password" => $this->password
            ]
        ]);
        dd($response);
    }
}