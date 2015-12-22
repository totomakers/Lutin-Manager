<?php 
namespace App\Http\Middleware;

use Auth;
use Lang;
use Closure;

class AuthRank 
{
    public function handle($request, Closure $next, $rank)
    {
        $response = $next($request);
        
        $user = Auth::user();
        (!$user) ? $langKey = 'auth.shouldBeLogged' : $langKey = 'auth.rankTooLow';
        
        if(!$user || $user->rank < $rank)
            return redirect()->route('auth::login')->with(['error' => true, 'messages' => [Lang::get($langKey)] ]);
        
        return $response; //continue
    }
}