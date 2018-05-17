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
     * @param array $data Set of additional data to add to the response
     * @param string $message Message to put in the response
     * @param boolean $is_success Pass/fail status of the request
     *
     * @return string
     */
    public function jsonResponse($data = null, $message = null, $is_success = true)
    {
        $output = [
            'success' => $is_success,
            'code'    => $this->getStatusCode(),
        ];
        if ( ! empty($message)) {
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
     * @param string $message Message to put in response
     * @param array $data Set of additional information to add to the response
     *
     * @return string
     */
    public function respondWithError($data = null, $message = null)
    {
        return $this->jsonResponse($data, $message, false);
    }

    /**
     * Handle a success response
     *
     * @param string $message Message to put in response
     * @param array $data Set of additional information to add to the response
     *
     * @return string
     */
    public function respondWithSuccess($data = null, $message = null)
    {
        return $this->jsonResponse($data, $message, true);
    }

    /**
     * 200 OK
     *
     * @param mixed $data
     * @param string $message
     *
     * @return string
     */
    public function respondOK($data = null, $message = 'OK!')
    {
        return $this->respondWithSuccess($data, $message);
    }

    /**
     * 201 Created
     *
     * @param mixed $data
     * @param string $message
     *
     * @return string
     */
    public function respondCreated($data = null, $message = 'Created!')
    {
        return $this->setStatusCode(201)->respondWithSuccess($data, $message);
    }

    /**
     * 202 Accepted
     *
     * @param mixed $data
     * @param string $message
     *
     * @return string
     */
    public function respondAccepted($data = null, $message = 'Accepted!')
    {
        return $this->setStatusCode(202)->respondWithSuccess($data, $message);
    }

    /**
     * 400 Bad Request
     *
     * @param mixed $data
     * @param string $message
     *
     * @return string
     */
    public function respondBadRequest($data = null, $message = 'Bad Request!')
    {
        return $this->setStatusCode(400)->respondWithError($data, $message);
    }

    /**
     * 401 Unauthorized
     *
     * @param mixed $data
     * @param string $message
     *
     * @return string
     */
    public function respondUnauthorized($data = null, $message = 'Unauthorized!')
    {
        return $this->setStatusCode(401)->respondWithError($data, $message);
    }

    /**
     * 402 Payment Required
     *
     * @param mixed $data
     * @param string $message
     *
     * @return string
     */
    public function respondPaymentRequired($data = null, $message = 'Payment Required!')
    {
        return $this->setStatusCode(402)->respondWithError($data, $message);
    }

    /**
     * 403 Payment Required
     *
     * @param mixed $data
     * @param string $message
     *
     * @return string
     */
    public function respondForbidden($data = null, $message = 'Forbidden!')
    {
        return $this->setStatusCode(403)->respondWithError($data, $message);
    }

    /**
     * 404 Not Found
     *
     * @param mixed $data
     * @param string $message
     *
     * @return string
     */
    public function respondNotFound($data = null, $message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($data, $message);
    }

    /**
     * 422 Unprocessable Entity
     *
     * @param  mixed $data
     * @param  string $message
     *
     * @return string
     */
    public function respondUnprocessableEntity($data = null, $message = 'Unprocessable Entity!')
    {
        return $this->setStatusCode(422)->respondWithError($data, $message);
    }
}