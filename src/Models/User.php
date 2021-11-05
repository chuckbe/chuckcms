<?php

namespace Chuckbe\Chuckcms\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property string $name
 * @property string $email
 * @property string $token
 */
class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active', 'token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guard_name = 'web';

    public function deleteById($id)
    {
        $user = $this->where('id', $id)->first();
        if ($user) {
            $roles = $user->getRoleNames();
            $permissions = $user->getDirectPermissions();

            foreach ($roles as $role) {
                $user->removeRole($role);
            }
            foreach ($permissions as $permission) {
                $user->removePermissionTo($permission);
            }

            if ($user->delete()) {
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return 'false';
        }
    }
}
