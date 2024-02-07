<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use URL;
class PreventEditDelete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if($request->method() == 'POST'){
            if(Auth::user()->role == '1' or Auth::user()->role == '2'){
                $backurl = URL::previous();

                // return back()->with(json_encode(['msg'=>'You have not permisson to edit']));
                return response()->json(array('status'=>302,'msg' => 'You are not authroize for this action','backurl' => $backurl));
            }
        }
        return $next($request);
    }
}
