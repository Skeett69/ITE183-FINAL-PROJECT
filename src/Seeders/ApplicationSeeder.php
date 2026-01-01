<?php

namespace App\Seeders;

use App\Core\Database;

class ApplicationSeeder
{
    public function run()
    {
        $db = Database::connect();

        $applications = [
            [
                'user_id' => 1, // User ID
                'job_id' => 1, // Job ID
                'other_details' => 'Applied on referral',
            ],
            [
                'user_id' => 2, // User ID
                'job_id' => 2, // Job ID
                'other_details' => 'Applied through LinkedIn',
            ],
        ];

        foreach ($applications as $application) {
            // Check if application already exists
            $checkStmt = $db->prepare("SELECT id FROM application WHERE user_id = :user_id AND job_id = :job_id");
            $checkStmt->execute([':user_id' => $application['user_id'], ':job_id' => $application['job_id']]);
            
            if ($checkStmt->rowCount() === 0) {
                $stmt = $db->prepare(
                    "INSERT INTO application (user_id, job_id, other_details) 
                    VALUES (:user_id, :job_id, :other_details)"
                );
                $stmt->execute($application);
            }
        }
    }
}
