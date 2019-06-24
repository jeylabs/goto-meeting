<?php

namespace Jeylabs\GoToMeeting;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

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
    /**
     * @var
     */
    private $user;
    /**
     * @var
     */
    private $password;
    /**
     * @var
     */
    private $consumerKey;
    /**
     * @var
     */
    private $consumerSecret;
    /**
     * @var mixed
     */
    private $accessToken;
    /**
     * @var mixed
     */
    private $organizerKey;
    /**
     * @var
     */
    private $dateRange;

    /**
     * GoToMeeting constructor.
     * @param $user
     * @param $password
     * @param $consumerKey
     * @param $consumerSecret
     * @param $dateRange
     * @param null $client
     */
    public function __construct($user, $password, $consumerKey, $consumerSecret, $dateRange, $client = null)
    {
        $this->headers = ['verify' => false];
        $this->client = $client ?: new Client([
            'base_uri' => "https://api.getgo.com",
            'timeout' => self::DEFAULT_TIMEOUT,
            'connect_timeout' => self::DEFAULT_TIMEOUT,
        ]);
        $this->user = $user;
        $this->password = $password;
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $authData = Cache::get('goto_meeting_auth_data', []);
        if (!$authData) {
            $authData = $this->authenticate();
        }

        $this->accessToken = Arr::get($authData, 'access_token');
        $this->organizerKey = Arr::get($authData, 'organizer_key');
        $this->dateRange = $dateRange;
    }

    /**
     * @return mixed
     */
    public function authenticate()
    {
        return Cache::remember('goto_meeting_auth_data', 3600, function () {
            $authorization = base64_encode($this->consumerKey . ":" . $this->consumerSecret);
            $response = $this->client->post('oauth/v2/token', [
                'headers' => [
                    'Content-Type' => "application/x-www-form-urlencoded",
                    'Authorization' => "Basic $authorization"
                ],
                'form_params' => [
                    "grant_type" => 'password',
                    "username" => $this->user,
                    "password" => $this->password
                ]
            ])->getBody()->getContents();
            return json_decode($response, 1);
        });
    }

    /**
     * @param null $start
     * @param null $end
     * @return mixed
     */
    public function getUpcomingWebinars($start = null, $end = null)
    {
        $start = Carbon::parse($start)->toIso8601String();
        $end = Carbon::parse($end)->addMonths($this->dateRange)->toIso8601String();
        $start = urlencode($start);
        $end = urlencode($end);

        $response = $this->client->get("G2W/rest/v2/organizers/$this->organizerKey/webinars?fromTime=$start&toTime=$end&size=3", [
            "headers" => [
                "Authorization" => "Bearer $this->accessToken",
                'Content-Type' => 'application/json'
            ]
        ])->getBody()->getContents();
        return json_decode($response, 1);
    }
}