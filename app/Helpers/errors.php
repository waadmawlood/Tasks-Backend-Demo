<?php


if (! function_exists('error'))
{
    /**
     * Response error with status code
     * @param int $code
     * @param string $message
     * @param string|array|null $errors
     * @param  array  $headers
     * @return void
     */
    function error($status_code, $message = "", $errors = null, array $headers = [])
    {
        $array_response = compact('status_code', 'message');
        $array_response['errors'] = $errors;
        $response = response($array_response, $status_code, $headers);

        abort($response);
    }
}

if (! function_exists('error_if'))
{
    /**
     * Response error with status code
     * @param bool $condition
     * @param int $code
     * @param string $message
     * @param string|array|null $errors
     * @param  array  $headers
     * @return void
     */
    function error_if($condition, $status_code, $message = "", $errors = null, array $headers = [])
    {
        $array_response = compact('status_code', 'message');
        $array_response['errors'] = $errors;
        $response = response($array_response, $status_code, $headers);

        abort_if($condition, $response);
    }
}
