<?php

namespace App\Seeders;

use App\Core\Database;

class UserSeeder
{
    public function run()
    {
        $db = Database::connect();

        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => password_hash('password', PASSWORD_BCRYPT)
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => password_hash('password', PASSWORD_BCRYPT)
            ],
            [
                'name' => 'Jasper',
                'email' => 'jasper@gmail.com',
                'password' => password_hash('password', PASSWORD_BCRYPT)
            ],
        ];

        foreach ($users as $user) {
            // Check if user already exists
            $checkStmt = $db->prepare("SELECT id FROM users WHERE email = :email");
            $checkStmt->execute([':email' => $user['email']]);
            
            if ($checkStmt->rowCount() === 0) {
                $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
                $stmt->execute($user);
            }
        }
    }
}
