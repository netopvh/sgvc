<?php

namespace App\Http\Middleware;

use App\Repositories\Access\Contracts\RoleRepository;
use Closure;

class VerifyUserRole
{

    private $role;

    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()){
            if (auth()->user()->roles()->count() == 0){
                if (auth()->user()->username == 'angelo.neto'){
                    auth()->user()->roles()->attach($this->role->find(1));
                }else{
                    auth()->user()->roles()->attach($this->role->find(3));
                }
            }
        }
        return $next($request);
    }
}
