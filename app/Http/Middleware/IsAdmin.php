<?php
  
namespace App\Http\Middleware;
  
use Closure;
use Auth;
use Redirect;
   
class IsAdmin
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
        if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2){
            return $next($request);
        }
        else{
            Auth::logout();
            return Redirect::to('/')->withErrors(['msg' => 'Credentials not match']);
        }
   
        return redirect('/')->with('error',"You don't have admin access.");
    }
}