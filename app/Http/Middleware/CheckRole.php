<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\API\Traits\ApiResponseTrait;

class CheckRole
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response|mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        // التحقق إذا كان المستخدم غير موجود أو ليس له صلاحية
        if (!$user || !$user->hasRole($role)) {
            // إذا لم يكن لديه صلاحية، أرجع استجابة مخصصة
            return $this->apiResponse(null, __('You do not have role to access this api'), Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
