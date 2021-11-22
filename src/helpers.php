<?php

if ( ! function_exists('success_response')) {
    /**
     * Generate username from random string
     *
     * @param array|null|Object $data
     * @param int $code
     * @param string $message
     * 
     * @return array
     */
    function success_response($data = null, int $code = 200, string $message = 'Action performed successfully'): array {
        return [
            'code'      => $code,
            'status'    => 'success',
            'message'   => $message,
            'data'      => $data,
        ];
    }
}

if ( ! function_exists('failure_response')) {
    /**
     * Generate username from random string
     *
     * @param array|null|Object $data
     * @param int $code
     * @param string $message
     * 
     * @return array
     */
    function failure_response($data = null, int $code = 0, string $message = 'Action attempted failed'): array {
        return [
            'code'      => $code,
            'status'    => 'failed',
            'message'   => $message,
            'data'      => $data,
        ];
    }
}