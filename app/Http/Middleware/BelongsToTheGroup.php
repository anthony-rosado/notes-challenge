<?php

namespace App\Http\Middleware;

use App\Entities\User;
use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Support\Facades\Auth;

class BelongsToTheGroup
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
        $request->validate([
            'group_id' => ['required', 'integer', 'exists:groups,id']
        ]);

        $groupId = $request->get('group_id');

        /**@var User $user*/
        $user = Auth::user();
        $isMember = $user->groups()->find($groupId);

        if (is_null($isMember)) {
            return ApiResponse::failed(null, __('messages.user.not-member'));
        }

        return $next($request);
    }
}
