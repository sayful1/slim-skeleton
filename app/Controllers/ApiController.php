<?php

namespace App\Controllers;

class ApiController extends BaseController
{
    /**
     * Handle the response and put it into a standard JSON structure
     *
     * @param boolean $status Pass/fail status of the request
     * @param string $message Message to put in the response [optional]
     * @param array $addl Set of additional information to add to the response [optional]
     *
     * @return string
     */
    public function jsonResponse($status, $message = null, array $addl = [])
    {
        $output = ['success' => $status];
        if ($message !== null) {
            $output['message'] = $message;
        }
        if ( ! empty($addl)) {
            $output = array_merge($output, $addl);
        }

        $response = $this->response->withHeader('Content-type', 'application/json');
        $body     = $response->getBody();
        $body->write(json_encode($output));

        return $response;
    }

    /**
     * Handle a failure response
     *
     * @param string $message Message to put in response [optional]
     * @param array $addl Set of additional information to add to the response [optional]
     *
     * @return string
     */
    public function jsonFail($message = null, array $addl = [])
    {
        return $this->jsonResponse(false, $message, $addl);
    }

    /**
     * Handle a success response
     *
     * @param string $message Message to put in response [optional]
     * @param array $addl Set of additional information to add to the response [optional]
     *
     * @return string
     */
    public function jsonSuccess($message = null, array $addl = [])
    {
        return $this->jsonResponse(true, $message, $addl);
    }
}