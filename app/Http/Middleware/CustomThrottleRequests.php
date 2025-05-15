<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class CustomThrottleRequests extends ThrottleRequests
{
    protected function buildResponse($key, $maxAttempts)
    {
        try {
            $response = parent::buildResponse($key, $maxAttempts);
        } catch (ThrottleRequestsException $e) {
            dd($e);
            return 'adasd';
        }
        $retryAfter = $this->limiter->availableIn($key);

        throw new ThrottleRequestsException(
            response()->json([
                'status' => false,
                'message' => 'عدد المحاولات كبير جدًا، الرجاء المحاولة بعد ' . $retryAfter . ' ثانية.',
                'retry_after' => $retryAfter,
                'code' => 429,
            ], 429)
        );
    }
}
