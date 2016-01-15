<?php

namespace App\Repositories\User;

use App\Repositories\Role\Role;
use App\Repositories\Team\Team;
use Illuminate\Auth\Authenticatable;
use App\Repositories\Account\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * User Account
     *
     * @return Relationship
     */
    public function account()
    {
        return $this->hasOne(Account::class);
    }

    /**
     * User Roles
     *
     * @return Relationship
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if user has role
     *
     * @param  string  $role
     * @return boolean
     */
    public function hasRole($role)
    {
        $teamIds = [];
        foreach ($this->teams->toArray() as $team) {
            array_push($teamIds, $team->id);
        }
        return in_array($id, $teamIds);
    }

    /**
     * Teams
     *
     * @return Relationship
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    /**
     * Team member
     *
     * @return boolean
     */
    public function isTeamMember($id)
    {
        return in_array($id, array_fetch($this->teams->toArray(), 'id'));
    }

    /**
     * Team admin
     *
     * @return boolean
     */
    public function isTeamAdmin($id)
    {
        $team = $this->teams->find($id);
        return (int)$team->user_id === (int)$this->id;
    }
}