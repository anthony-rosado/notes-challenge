<?php

namespace App\Http\Controllers\Api;

use App\Entities\Group;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GroupCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => ['sometimes', 'integer'],
        ]);

        $perPage = $request->get('per_page') ?? 10;
        $groups = Group::query()->withCount('members')->paginate($perPage);

        return new GroupCollection($groups);
    }

    public function join($id)
    {
        /**@var Group $group*/
        $group = Group::findOrFail($id);

        $userId = Auth::id();

        if ($group->members()->find($userId)) {
            return ApiResponse::noContent();
        }

        $group->members()->attach($userId);

        return ApiResponse::success(null, __('messages.user.joined', ['group-name' => $group->name]));
    }
}
