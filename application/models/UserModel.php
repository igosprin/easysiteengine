<?php

namespace App\Models;

/** Registration/login — the session/cookie mechanics live in Easysite\Library\Auth, this is just users. */
class UserModel extends BaseModel
{
    public function findByEmail(string $email): ?array
    {
        return $this->db->fetchOne('SELECT * FROM users WHERE email = :e LIMIT 1', ['e' => $email]) ?: null;
    }

    public function findById(int $id): ?array
    {
        return $this->db->fetchOne('SELECT * FROM users WHERE id = :id LIMIT 1', ['id' => $id]) ?: null;
    }

    public function emailExists(string $email): bool
    {
        return $this->findByEmail($email) !== null;
    }

    public function create(string $email, string $passwordHash, string $name): int
    {
        return (int) $this->db->insert('users', [
            'email'         => $email,
            'password_hash' => $passwordHash,
            'name'          => $name,
            'plan'          => 'FREE',
            'role'          => 'user',
            'created_at'    => $this->now(),
        ]);
    }
}
