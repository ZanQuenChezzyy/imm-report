<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $fillable = ['name', 'guard_name'];
    protected $appends = ['resource']; // Atribut sementara

    public function getResourceAttribute()
    {
        return $this->attributes['resource'] ?? null;
    }

    public function setResourceAttribute($value)
    {
        $this->attributes['resource'] = $value;
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }
}
