<?php

namespace App\Controllers;

class ApiController extends BaseController
{
    /**
     * Status Code
     */
    protected $statusCode = 200;

    /**
     * Get status code
     *
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set status code
     *
     * @param mixed $statusCode
     *
     * @return ApiController
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Handle the response and put it into a standard JSON structure
     *
     * @param boolean $status Pass/fail status of the request
     * @param string $message Message to put in the response [optional]
     * @param array $data Set of additional data to add to the response [optional]
     *
     * @return string
     */
    public function jsonResponse($status, $message = null, array $data = [])
    {
        $output         = ['success' => $status];
        $output['code'] = $this->getStatusCode();
        if ($message !== null) {
            $output['message'] = $message;
        }
        if ( ! empty($data)) {
            $output['data'] = $data;
        }

        /** @var \Slim\Http\Response $response */
        $response = $this->response;
        $response = $response->withHeader('Content-type', 'application/json');
        $response = $response->withStatus($this->getStatusCode());
        $response->getBody()->write(json_encode($output));

        return $response;
    }

    /**
     * Handle a failure response
     *
     * @param string $message Message to put in response [optional]
     * @param array $data Set of additional information to add to the response [optional]
     *
     * @return string
     */
    public function respondWithError($message = null, array $data = [])
    {
        return $this->jsonResponse(false, $message, $data);
    }

    /**
     * Handle a success response
     *
     * @param string $message Message to put in response [optional]
     * @param array $data Set of additional information to add to the response [optional]
     *
     * @return string
     */
    public function respondWithSuccess($message = null, array $data = [])
    {
        return $this->jsonResponse(true, $message, $data);
    }

    /**
     * Response validation error message
     *
     * @param  string $message
     * @param  array $data
     *
     * @return string
     */
    public function respondValidationError($message = null, array $data = [])
    {
        return $this->setStatusCode(422)->respondWithError($message, $data);
    }
}