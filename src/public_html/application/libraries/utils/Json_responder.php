<?php
defined('BASEPATH') OR exit('No direct script access allowed');

final class Json_responder
{
    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function Response($data = array())
    {
        header('Content-type: application/json');
        echo json_encode($data);
    }

    public function Session_expired($requireRedirect)
    {
        header('Content-type: application/json');

        $data['isSessionExpired'] = true;
        $data['requireRedirect'] = $requireRedirect;

        echo json_encode($data);
    }

    public function Error($error = null)
    {
        if (!isset($error)) {
            try {
                throw new Exception('Error occurred. Please find the developer.');
            } catch (Exception $ex) {
                $error = $ex;
            }
        }

        log_message('error', $error->getMessage());

        header('Content-type: application/json');
        $errorResponse = json_encode(array(
            'isSuccess' => false,
            'code' => $error->getCode()
        ));

        log_message('error', $errorResponse);
        echo $errorResponse;
    }
}