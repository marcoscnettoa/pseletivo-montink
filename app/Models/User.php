<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\ContabilidadesController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

use App\Trait\UsersIdRequired; // # - MXTera
use App\Trait\PublicHashRequired; // # - MXTera
use App\Trait\PublicHashFilesRequired; // # - MXTera

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use SoftDeletes, HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'login', // # MXTera -
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getRole(){
        return $this->belongsTo(Produtos::class, 'roles_id');
    }

    public function getAdministrador(){
        return $this->belongsTo(Administradores::class, 'administradores_id');
    }

    public function getContabilidade(){
        return $this->belongsTo(Contabilidades::class, 'contabilidades_id');
    }

    public function getCliente(){
        return $this->belongsTo(Clientes::class, 'clientes_id');
    }
}
