<?php

namespace App\Seeders;

use App\Core\Database;

class JobLevelSeeder
{
    public function run()
    {
        $db = Database::connect();

        $levels = [
            ['name' => 'Entry Level', 'other_details' => 'Beginner level'],
            ['name' => 'Mid Level', 'other_details' => 'Intermediate level'],
            ['name' => 'Senior Level', 'other_details' => 'Advanced level'],
        ];

        foreach ($levels as $level) {
            // Check if level already exists
            $checkStmt = $db->prepare("SELECT id FROM job_level WHERE name = :name");
            $checkStmt->execute([':name' => $level['name']]);
            
            if ($checkStmt->rowCount() === 0) {
                $stmt = $db->prepare("INSERT INTO job_level (name, other_details) VALUES (:name, :other_details)");
                $stmt->execute($level);
            }
        }
    }
}
