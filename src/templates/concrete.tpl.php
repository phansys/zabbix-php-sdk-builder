<?php

/*
 * This file is part of PhpZabbixApi.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @copyright The MIT License (MIT)
 * @author confirm IT solutions GmbH, Rathausstrase 14, CH-6340 Baar
 */

namespace Confirm\ZabbixApi;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\InvalidArgumentException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

final class <CLASSNAME_CONCRETE> implements <CLASSNAME_INTERFACE>, TokenCacheAwareInterface
{
    /**
     * Boolean if requests/responses should be printed out (JSON).
     *
     * @var bool
     */
    private $printCommunication = false;

    /**
     * API URL.
     *
     * @var string|null
     */
    private $apiUrl;

    /**
     * Default params.
     *
     * @var array
     */
    private $defaultParams = [];

    /**
     * @var string|null
     */
    private $user;

    /**
     * @var string|null
     */
    private $password;

    /**
     * Auth string.
     *
     * @var string|null
     */
    private $authToken;

    /**
     * Request ID.
     *
     * @var string
     */
    private $id;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * Response object.
     *
     * @var \stdClass|array
     */
    private $responseDecoded;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var array<string, mixed>
     */
    private $requestOptions = [];

    /**
     * @var string|null
     */
    private $tokenCacheDir;

    /**
     * @param string|null $apiUrl API url (e.g. https://FQDN/zabbix/api_jsonrpc.php)
     * @param string|null $user Username for Zabbix API
     * @param string|null $password Password for Zabbix API
     * @param string|null $httpUser Username for HTTP basic authorization
     * @param string|null $httpPassword Password for HTTP basic authorization
     * @param string|null $authToken Already issued auth token (e.g. extracted from cookies)
     * @param array $clientOptions Client options
     */
    public function __construct($apiUrl = null, $user = null, $password = null, $httpUser = null, $httpPassword = null, $authToken = null, ClientInterface $client = null, array $clientOptions = [])
    {
        if (null !== $client && !empty($clientOptions)) {
            throw new \InvalidArgumentException('If argument 7 is provided, argument 8 must be omitted or passed with an empty array as value');
        }

        if (null !== $apiUrl) {
            $this->setApiUrl($apiUrl);
        }

        $clientOptions['base_uri'] = $apiUrl;

        if (null !== $httpUser && null !== $httpPassword) {
            $this->setBasicAuthorization($httpUser, $httpPassword);
        }

        $this->client = null !== $client ? $client : new Client($clientOptions);

        if (null !== $authToken) {
            $this->setAuthToken($authToken);
        } elseif (null !== $user && null !== $password) {
            $this->user = $user;
            $this->password = $password;
        }
    }

    /**
     * Returns the API url for all requests.
     *
     * @return string API url
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * Sets the API url for all requests.
     *
     * @param string $apiUrl API url
     *
     * @return <CLASSNAME_INTERFACE>
     */
    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    /**
     * Sets the API authorization ID.
     *
     * @param string $authToken API auth ID
     *
     * @return <CLASSNAME_INTERFACE>
     */
    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;

        return $this;
    }

    /**
     * Sets the username and password for the HTTP basic authorization.
     *
     * @param string $user HTTP basic authorization username
     * @param string $password HTTP basic authorization password
     *
     * @return <CLASSNAME_INTERFACE>
     */
    public function setBasicAuthorization($user, $password)
    {
        $this->requestOptions[RequestOptions::AUTH] = [$user, $password];

        return $this;
    }

    /**
     * Returns the default params.
     *
     * @return array Array with default params
     */
    public function getDefaultParams()
    {
        return $this->defaultParams;
    }

    /**
     * Sets the default params.
     *
     * @param array $defaultParams Array with default params
     *
     * @throws Exception
     *
     * @return <CLASSNAME_INTERFACE>
     */
    public function setDefaultParams(array $defaultParams)
    {
        $this->defaultParams = $defaultParams;

        return $this;
    }

    /**
     * Sets the flag to print communication requests/responses.
     *
     * @param bool $print Boolean if requests/responses should be printed out
     *
     * @return <CLASSNAME_INTERFACE>
     */
    public function printCommunication($print = true)
    {
        $this->printCommunication = (bool) $print;

        return $this;
    }

    public function setTokenCacheDir($directory)
    {
        $this->tokenCacheDir = $directory;
    }

    /**
     * Sends are request to the Zabbix API and returns the response as object.
     *
     * @param string $method Name of the API method
     * @param array|mixed|null $params Additional parameters
     * @param string|null $resultArrayKey
     * @param bool $assoc Return the result as an associative array
     * @param bool $auth Enable authentication (default true)
     * @param int $remainingAuthAttempts Number of remaining authentication attempts before failing
     *
     * @return mixed API JSON response
     */
    public function request($method, $params = null, $resultArrayKey = null, $assoc = true, $auth = true, $remainingAuthAttempts = 1)
    {
        // Sanity check and conversion for params array.
        if (!$params) {
            $params = [];
        } elseif (!is_array($params)) {
            $params = [$params];
        }

        // Generate request ID.
        $this->id = number_format(microtime(true), 4, '', '');

        // Build request payload.
        $requestPayload = [
            'jsonrpc' => '2.0',
            'method' => $method,
            'params' => $params,
            'id' => $this->id,
        ];

        // Add auth token if required.
        if ($auth && null !== $this->user) {
            $requestPayload['auth'] = $this->getAuthToken();
        }

        if ($this->printCommunication) {
            $this->requestOptions[RequestOptions::DEBUG] = true;
        }

        try {
            $this->response = $this->client->request('POST', $this->apiUrl, $this->requestOptions + [
                RequestOptions::HEADERS => ['Content-type' => 'application/json-rpc'],
                RequestOptions::JSON => $requestPayload,
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $this->response = $e->getResponse();

                throw new Exception(sprintf('%s: %s', $e->getMessage(), $this->response->getBody()->getContents()), $e->getCode(), $e);
            }

            throw new Exception($e->getMessage(), $e->getCode(), $e);
        } catch (TransferException $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        } finally {
            // Debug logging.
            if ($this->printCommunication) {
                echo $this->response->getBody()."\n";
            }
        }

        try {
            $response = $this->decodeResponse($this->response, $resultArrayKey, $assoc);
        } catch (Exception $e) {
            // If the request is not authorized due an authentication issue, attempt to login again and retry the operation.
            if ($auth && self::UNAUTHORIZED_ERROR_CODE === $e->getCode() && self::UNAUTHORIZED_ERROR_MESSAGE === $e->getMessage() &&
                $remainingAuthAttempts > 0 && null !== $this->user && null !== $this->password
            ) {
                $this->getAuthToken(false);

                return $this->request($method, $params, $resultArrayKey, $auth, $assoc, --$remainingAuthAttempts);
            }

            throw $e;
        }

        return $response;
    }

    /**
     * Returns the last JSON API response.
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Logout from the API.
     *
     * This will also reset the auth Token.
     *
     * The $params Array can be used, to pass parameters to the Zabbix API.
     * For more information about these parameters, check the Zabbix API
     * documentation at https://www.zabbix.com/documentation/.
     *
     * The $arrayKeyProperty can be used to get an associative instead of an
     * indexed array as response. A valid value for the $arrayKeyProperty is
     * is any property of the returned JSON objects (e.g. "name", "host",
     * "hostid", "graphid", "screenitemid").
     *
     * @param array $params Parameters to pass through
     * @param string|null $arrayKeyProperty Object property for key of array
     * @param bool $assoc Return the value as an associative array instead of an instance of stdClass
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function userLogout($params = [], $arrayKeyProperty = null, $assoc = true)
    {
        $params = $this->getRequestParamsArray($params);
        $response = $this->request('user.logout', $params, $arrayKeyProperty, $assoc);
        $this->authToken = null;

        return $response;
    }
<!START_API_METHOD>
    /**
     * Requests the Zabbix API and returns the response of the method "<API_METHOD>".
     *
     * The $params Array can be used, to pass parameters to the Zabbix API.
     * For more information about these parameters, check the Zabbix API
     * documentation at https://www.zabbix.com/documentation/.
     *
     * The $arrayKeyProperty can be used to get an associative instead of an
     * indexed array as response. A valid value for the $arrayKeyProperty is
     * is any property of the returned JSON objects (e.g. "name", "host",
     * "hostid", "graphid", "screenitemid").
     *
     * @param mixed $params Zabbix API parameters
     * @param string|null $arrayKeyProperty Object property for key of array
     * @param bool $assoc Return the value as an associative array instead of an instance of stdClass
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function <PHP_METHOD>($params = [], $arrayKeyProperty = null, $assoc = true)
    {
        return $this->request('<API_METHOD>', $this->getRequestParamsArray($params), $arrayKeyProperty, $assoc, <IS_AUTHENTICATION_REQUIRED>);
    }
<!END_API_METHOD>
    /**
     * Returns the array or the instance of `\stdClass` indexed by the given parameter or property
     * name.
     *
     * @param array|\stdClass|mixed $objectOrArray Indexed array with objects
     * @param string $useObjectProperty Object property to use as array key
     *
     * @return array<string, mixed>|\stdClass
     */
    private function convertToAssociatveArray($objectOrArray, $useObjectProperty)
    {
        if (is_array($objectOrArray)) {
            // Sanity check.
            if (!empty($objectOrArray) && !isset(current($objectOrArray)[$useObjectProperty])) {
                throw new \InvalidArgumentException(sprintf('Parameter "%s" does not exist in the given elements.', $useObjectProperty));
            }

            // Return associative array.
            return array_column($objectOrArray, null, $useObjectProperty);
        }

        if (is_object($objectOrArray)) {
            $objectVars = get_object_vars($objectOrArray);

            // Sanity check.
            if (!empty($objectVars) && !property_exists(current($objectVars), $useObjectProperty)) {
                throw new \InvalidArgumentException(sprintf('Property "%s" does not exist in the given elements.', $useObjectProperty));
            }

            // Loop through array and replace keys.
            $newObject = new \stdClass();
            foreach ($objectVars as $key => $object) {
                $newObject->{$object->{$useObjectProperty}} = $object;
            }

            // Return object indexed by the given property value.
            return $newObject;
        }

        throw new \InvalidArgumentException(sprintf('Argument 1 passed to "%s()" must be of type "array" or an instance of "\stdClass", "%s" given.', __METHOD__, gettype($objectOrArray)));
    }

    /**
     * Returns a params array for the request.
     *
     * This method will automatically convert all provided types into a correct
     * array. Which means:
     *
     *      - arrays will not be converted (indexed & associative)
     *      - scalar values will be converted into an one-element array (indexed)
     *      - other values will result in an empty array
     *
     * Afterwards the array will be merged with all default params, while the
     * default params have a lower priority (passed array will overwrite default
     * params). But there is an Exception for merging: If the passed array is an
     * indexed array, the default params will not be merged. This is because
     * there are some API methods, which are expecting a simple JSON array (aka
     * PHP indexed array) instead of an object (aka PHP associative array).
     * Example for this behavior are delete operations, which are directly
     * expecting an array of IDs '[ 1,2,3 ]' instead of '{ ids: [ 1,2,3 ] }'.
     *
     * @param mixed $params Params array
     *
     * @return array
     */
    private function getRequestParamsArray($params)
    {
        if (is_scalar($params)) {
            // If params is a scalar value, turn it into an array.
            $params = [$params];
        } elseif (!is_array($params)) {
            // If params isn't an array, create an empty one (e.g. for booleans, null).
            $params = [];
        }

        $paramsCount = count($params);

        // If array isn't indexed, merge array with default params.
        if (0 === $paramsCount || array_keys($params) !== range(0, $paramsCount - 1)) {
            $params = array_merge($this->getDefaultParams(), $params);
        }

        return $params;
    }

    /**
     * @param string|null $resultArrayKey
     * @param bool $assoc
     *
     * @throws Exception
     *
     * @return mixed The decoded JSON data
     */
    private function decodeResponse(ResponseInterface $response, $resultArrayKey = null, $assoc = true)
    {
        $content = $response->getBody();

        try {
            $this->responseDecoded = \GuzzleHttp\json_decode($content, $assoc);
        } catch (InvalidArgumentException $ex) {
            throw new Exception(sprintf('Response body could not be parsed since the JSON structure could not be decoded: %s', $content), $ex->getCode(), $ex);
        }

        if ($assoc) {
            if (isset($this->responseDecoded['error'])) {
                throw new Exception($this->responseDecoded['error']['data'], $this->responseDecoded['error']['code']);
            }
            if (null !== $resultArrayKey) {
                return $this->convertToAssociatveArray($this->responseDecoded['result'], $resultArrayKey);
            }

            return $this->responseDecoded['result'];
        }

        if (property_exists($this->responseDecoded, 'error') && $error = $this->responseDecoded->error) {
            throw new Exception($error->data, $error->code);
        }

        if (null !== $resultArrayKey) {
            return $this->convertToAssociatveArray($this->responseDecoded->result, $resultArrayKey);
        }

        return $this->responseDecoded->result;
    }

    private function getAuthToken($fromCache = true)
    {
        if ($fromCache && null !== $this->authToken) {
            return $this->authToken;
        }

        $tokenCacheDir = null !== $this->tokenCacheDir ? $this->tokenCacheDir : sys_get_temp_dir();
        $tokenCacheFile = null;

        // Build filename for cached auth token.
        if ($tokenCacheDir && is_dir($tokenCacheDir)) {
            $uid = function_exists('posix_getuid') ? posix_getuid() : -1;
            $tokenCacheFile = $tokenCacheDir.'/.zabbixapi-token-'.md5($this->user.'|'.$uid);
        }

        if ($fromCache) {
            // Try to read cached auth token.
            if (null !== $tokenCacheFile && is_file($tokenCacheFile)) {
                $cachedToken = @file_get_contents($tokenCacheFile);

                if (false === $cachedToken) {
                    // Unlink corrupted cached token file.
                    @unlink($tokenCacheFile);

                    throw new Exception('Failed to read cached token.');
                }

                $this->authToken = $cachedToken;
            }
        }

        // No cached token found so far, so login.
        if (null === $this->authToken) {
            // login to get the auth token
            $params = $this->getRequestParamsArray(['user' => $this->user, 'password' => $this->password]);
            $this->authToken = $this->userLogin($params);

            // Persist cached auth token.
            if (null !== $tokenCacheFile) {
                @file_put_contents($tokenCacheFile, $this->authToken);
                @chmod($tokenCacheFile, 0600);
            }
        }

        return $this->authToken;
    }
}
