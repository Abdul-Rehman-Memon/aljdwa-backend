<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole {


      public function handle(Request $request, Closure $next, string $roleName)
      {
          // Check if the user is authenticated
          if (!Auth::check()) {
              return response()->json(['message' => 'Unauthorized'], 401);
          }
  
          // Get the authenticated user
          $user = Auth::user();
  
          // Check if the user has the required role
          if (!$user->hasRole($roleName)) {
              return response()->json(['message' => 'Forbidden'], 403);
          }
  
          return $next($request);
      }
}
