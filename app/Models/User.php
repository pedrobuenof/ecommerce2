<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{

    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password'];

    public function getNomeAttribute()
    {
        return ucfirst($this->attributes['name']);
    }

    public function setpasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
