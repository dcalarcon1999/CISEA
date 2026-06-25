<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'rut', 'email', 'rol', 'cod_funcionario', 'apellidos', 'nombres', 'grado', 'unidad', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    /**
     * Formato institucional: "ALARCÓN LAGOS, Carlos Daniel"
     * Apellidos en mayúsculas + coma + nombres en Title Case.
     */
    public function getNombreDisplayAttribute(): string
    {
        if ($this->apellidos && $this->nombres) {
            return strtoupper($this->apellidos) . ', ' . mb_convert_case(strtolower($this->nombres), MB_CASE_TITLE, 'UTF-8');
        }
        return $this->name;
    }

    /**
     * Nombre completo en mayúsculas para almacenar en la evidencia como snapshot.
     */
    public function getNombreSnapshotAttribute(): string
    {
        if ($this->apellidos && $this->nombres) {
            return strtoupper($this->apellidos) . ' ' . strtoupper($this->nombres);
        }
        return strtoupper($this->name);
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->rol, $roles);
    }
}
