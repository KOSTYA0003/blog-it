<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(UpdateUserRequest $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Вы не можете менять роль самому себе.');
        }

        $user->role = $request->validated()['role'];
        $user->save();

        return back()->with('success', "Роль пользователя {$user->name} обновлена.");
    }

    public function toggleBan(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Вы не можете заблокировать собственный аккаунт.');
        }

        $user->is_banned = ! $user->is_banned;
        $user->save();

        $message = $user->is_banned
            ? "Пользователь {$user->name} успешно заблокирован."
            : "Доступ для пользователя {$user->name} восстановлен.";

        return back()->with('success', $message);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Вы не можете удалить свой аккаунт отсюда.');
        }

        $user->delete();

        return back()->with('success', 'Пользователь полностью удален из системы.');
    }
}
