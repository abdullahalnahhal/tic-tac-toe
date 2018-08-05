<?php

namespace App\Http\Middleware;

use Closure;
// use App\Players;

class APIToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('Authorization')){
            $token = explode("Bearer ", $request->header('Authorization'))[1];
            $is_player = \App\Players::getByToken($token);
            if ($is_player) {
                $request->merge(['user', $is_player]);
                $request->setUserResolver(function () use ($is_player) {
                    return $is_player;
                });
                return $next($request);
            }else{
                return response()->json([
                    'message' => 'There No Player Like These.',
                ], 401);
            }
        }
        return response()->json([
            'message' => 'Not a valid API request.',
        ], 401);
    }
}
