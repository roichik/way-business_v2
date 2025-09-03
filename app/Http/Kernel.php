<?php

namespace App\Http;

use App\Dictionaries\MessageCodeDictionary;
use App\Exceptions\CustomException;
use App\Helpers\StringHelper;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Class Kernel
 */
class Kernel extends HttpKernel
{

    /**
     * @param $request
     * @return \Illuminate\Http\Response
     */

    protected function sendRequestThroughRouter($request)
    {
        $response = parent::sendRequestThroughRouter($request);

        if (
            (Route::getCurrentRoute() && substr(Route::getCurrentRoute()->uri(), 0, 5) == 'admin') ||
            $request->getMethod() == 'OPTIONS'
        ) {
            return $response;
        }

        if (property_exists($response, 'original') && $response->original instanceof Throwable) {
            $this->formatResponseError($response);
        } else {
            if ($response->getStatusCode() === 200) {
                $this->formatResponseSuccess($response);
            } else {
                $this->formatResponseError($response);
            }
        }

        $this->handleCORS($response);

        return $response;
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderException($request, Throwable $e)
    {
        $response = parent::renderException($request, $e);
        $this->formatResponseError($response);

        return $response;
    }

    /**
     * @param Response $response
     * @return void
     */
    protected function formatResponseSuccess(Response $response)
    {
        $content = $response->getContent();

        if (StringHelper::isJSON($content)) {
            $content = json_decode($content, true);
        }

        if (!($response instanceof \App\Http\Responses\JsonResponse)) {
            $response->headers->add(['Content-Type' => 'application/json']);
        }

        $content = [
            'status' => 'success',
            'data'   => $content === "" || $content === [] ? null : $content,
        ];

        $response->setContent(json_encode($content));

    }

    /**
     * @param Response $response
     * @return void
     */
    protected function formatResponseError(Response $response)
    {
        $message = 'Internal Server Error';
        $exception = $response->exception ?? $response->original;

        if ($exception instanceof ValidationException) {
            $message = $exception->validator->errors()->messages();
        } else {
            if (
                $exception instanceof CustomException ||
                ($exception instanceof Exception && config('app.debug')) ||
                ($exception instanceof Exception && config('app.debug'))
            ) {
                $message = $exception->getMessage();
            } else {
                if ($exception instanceof QueryException && env('DB_DEBUG', false)) {
                    Log::channel('db')
                        ->error($exception->getSql() . ';' . ($exception->getBindings() ? ' ' . json_encode($exception->getBindings()) : ''));
                }

                //обработка ошибок в логике кода
                if (config('app.debug')) {
                    //выводим только сообщение
                    if (!env('LOG_RESPONSE_TRACE', false)) {
                        $message = $exception->getMessage();
                    } else {
                        $message =
                            [
                                'message' => $exception->getMessage(),
                                'file'    => $exception->getFile(),
                                'line'    => $exception->getLine(),
                                'code'    => $exception->getCode(),
                                'trace'   => [
                                    array_map(function ($trace) {
                                        if (array_key_exists('args', $trace)) {
                                            unset($trace['args']);
                                        }

                                        return $trace;
                                    }, $exception->getTrace())
                                ]
                            ];
                    }
                }
            }
        }

        if (StringHelper::isJSON($message)) {
            $message = json_decode($message);
        }

        if (!($response instanceof JsonResponse)) {
            $response->headers->add(['Content-Type' => 'application/json']);
        }

        $this->formatErrorStatusCode($response, $exception);
        $response->setContent(json_encode(
                [
                    'status'  => 'error',
                    'message' => $message,
                ]
            )
        );
    }

    /**
     * @param Response $response
     * @param Throwable $exception
     * @return void
     */
    private function formatErrorStatusCode(Response $response, Throwable $exception)
    {
        $statusCode = config('app.debug') ? 500 : $response->getCode();
        if ($response->getStatusCode() === 400) {
            $statusCode = 400;
        }
        if ($response->getStatusCode() === 401) {
            $statusCode = 401;
        }
        if ($response->getStatusCode() === 402) {
            $statusCode = 402;
        }
        if ($response->getStatusCode() === 403) {
            $statusCode = 403;
        }
        if ($response->getStatusCode() === 404) {
            $statusCode = 404;
        }

        $response->setStatusCode($statusCode);
    }

    /**
     * @param Response $response
     * @return void
     */
    private function handleCORS(Response $response)
    {
        /*
        $response->headers->add([
            'access-control-allow-origin'      => '*',
            'access-control-allow-methods'     => 'PUT, GET, HEAD, POST, DELETE, OPTIONS',
            'access-control-max-age'           => 1728000,
            'access-control-allow-credentials' => true,
            'access-control-allow-headers'     => 'Origin,Content-Type,Accept,Authorization',
        ]);
        */
    }
}
