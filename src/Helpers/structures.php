<?php

if (!function_exists('response_default')) {
    function response_default($data, int $statusCode)
    {

        return response()
            ->json($data, 200);

    }
}

if (!function_exists('response_exception')) {
    function response_exception(
        string $message,
        int $statusCode,
        string $file,
        int $line,
        string $trace = null,
        array $fields = [],
        bool $exceptionUntreated = false
    )
    {

        $message = [
            'message' => $message,
        ];

        if ($exceptionUntreated === true && config('app.debug') === false) {
            $message = [
                'message' => 'Internal error',
            ];
        }

        if (!empty($fields)) {

            $fieldsMessage = [
                'requirements' => $fields
            ];

            $message = array_merge($message, $fieldsMessage);
        }

        if (config('app.debug') === true) {

            $fileAndLine = [
                'file' => $file,
                'line' => $line,
            ];

            $message = array_merge($message, $fileAndLine);

        }

        if (config('app.debug') === true and config('app.debug_trace') === true) {

            $trace = [
                'trace' => $trace
            ];

            $message = array_merge($message, $trace);

        }

        $response = [
            'error' => $message
        ];

        return response()->json($response, $statusCode);

    }
}
