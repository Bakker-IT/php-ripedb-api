<?php
namespace Bakkerit\PhpRipedbApi\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\RequestOptions;

class QueryBuilder
{
    private $queryParams = [];

    private string $baseUri;
    private string $source;
    private string $objectType;
    /**
     * @var mixed|null
     */
    private mixed $key;

    public function __construct($baseUri, $source, $objectType, $key = null) {
        $this->baseUri = $baseUri;
        $this->source = $source;
        $this->objectType = $objectType;
        $this->key = $key;
    }

//
//    public function select($fields) {
//        $this->queryParams['fields'] = $fields;
//        return $this;
//    }
//
//    public function where($condition) {
//        $this->queryParams['where'] = $condition;
//        return $this;
//    }
//
//    public function orderBy($field, $direction) {
//        $this->queryParams['orderBy'] = ['field' => $field, 'direction' => $direction];
//        return $this;
//    }

    public function get() {
        $response = $this->callApi('GET');
    }

    public function build() {
        $url = $this->endpoint() . '?' . http_build_query($this->queryParams);

        // Perform the API request using a library like cURL or Guzzle
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    private function endpoint()
    {
        $uri = '/' . $this->source . '/' . $this->objectType;
        if(!is_null($this->key)) {
            $uri .= '/' . $this->key;
        }

        return $uri;
    }

    private function callApi($method, $parameters = [])
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        var_dump($client);

        $options =  [
            RequestOptions::HEADERS => [
                'accept' => 'application/json',
            ],
        ];

        $options[RequestOptions::JSON] = $parameters;

        try {
            $httpResponse = $client->request($method, $this->endpoint(), $options);

            $statusCode = $httpResponse->getStatusCode();
            $body = $httpResponse->getBody()->getContents();
            $responseData = json_decode($body, true);

            var_dump($statusCode, $body, $responseData);

        } catch (ClientException|ServerException|GuzzleException $e) {

        }
    }


}
