<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

// Preciso implememtar o JWTSubject no qual o sujeito e o proprio usuário
class User extends Authenticatable implements JWTSubject

{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    // Ao implementar o JWTSubject adiciono  a função getJWTIdentifier e getJWTCustomClaims
    public function getJWTIdentifier()
    {
            //para identificar o sujeito e o uso proprio ID dele
            return $this->id;
    }

    public function getJWTCustomClaims()
    {
        // Sao informacoes que vai esta contida no proprio token
        // Nao deve colocar informacoes sensiveis, pois, se alguem capturar o token vai ter acesso a todo os dados.
            return [
                'email' => $this->email,
                'name' => $this->name
            ];
    }
}