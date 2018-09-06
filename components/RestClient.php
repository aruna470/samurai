<?php
/**
 * RestClient class
 *
 * Rest client which can be used to communicate with 3party APIs
 *
 * @author  Aruna Attanayake <aruna@keeneye.solutions>
 */

namespace app\components;

use Yii;
use yii\base\Component;

class RestClient extends Component
{
	// Mailjet Api key and secret
	private $apiKey = '';
    private $secretKey = '';

	// Mailjet API end point
	private $apiUrl = '';

	public $response = '';
	public $errorCode;

    /**
     * Class constructor
     * @param string $apiKey API key
     * @param string $secretKey API password
     * @param string $apiUrl API Url
     */
	public function __construct($apiKey, $secretKey, $apiUrl)
	{
		$this->apiKey = $apiKey;
		$this->secretKey = $secretKey;
		$this->apiUrl = $apiUrl;
	}

    /**
     * Make HTTP request using curl
     * @param string $url Endpoint URL
     * @param array $curlOptions Possible curl options
     * @param integer $timeout curl timeout
     */
	private function httpRequest($url, $curlOptions=array(), $timeout=60)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_USERPWD, "{$this->apiKey}:{$this->secretKey}");

		foreach ($curlOptions as $key => $value) {
			curl_setopt($ch, $key, $value);
		}

		$this->response = curl_exec($ch);
		$this->errorCode = curl_errno($ch);
		curl_close($ch);
	}

    /**
     * Prepare the HTTP request to be made
     * @param string $endPoint action. ex:user/create
     * @param array $params Request parameters
     * @param string $method HTTP request method
     */
	public function sendRequest($endPoint, $params, $method='GET')
	{
		$curlOptions = array();
		$requestUri = '';

		switch ($method) {
			case 'POST':
				$queryString = $this->buildQueryString($params);
				$pramCount = count(explode('&',$queryString));
				$curlOptions[CURLOPT_POST] = $pramCount;
				$curlOptions[CURLOPT_POSTFIELDS] = $queryString;
				$requestUri = $this->apiUrl . $endPoint;
				break;

			case 'GET':
				$queryString = $this->buildQueryString($params);
				$requestUri = $this->apiUrl . $endPoint . '?' . $queryString;
				break;

			case 'POST_JSON':
				$jsonParams = json_encode($params);
				$curlOptions[CURLOPT_HTTPHEADER] = array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($jsonParams)
				);
				$curlOptions[CURLOPT_POSTFIELDS] = $jsonParams;
				$requestUri = $this->apiUrl . $endPoint;
                break;

			case 'DELETE':
				$curlOptions[CURLOPT_CUSTOMREQUEST] = "DELETE";
				$requestUri = $this->apiUrl . $endPoint;
				break;
		}

		return $this->httpRequest($requestUri, $curlOptions);
	}

    /**
     * Build query string
     * @param array $params Request parameters
     * @return string query string
     */
	private function buildQueryString($params)
	{
		$queryString = '';
		foreach ($params as $key => $value) {
			if (is_array($value) && 'multiple' == $value[0]) {
				$queryString .= "{$value[1]}&";
			} else {
				$queryString .= "{$key}={$value}&";
			}
		}

		return rtrim($queryString, '&');
	}
}
