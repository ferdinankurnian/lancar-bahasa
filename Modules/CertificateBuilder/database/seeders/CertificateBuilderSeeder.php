<?php

namespace Modules\CertificateBuilder\database\seeders;

use Illuminate\Database\Seeder;

class CertificateBuilderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certificate_builders = array(
            array(
                "id" => 1,
                "background" => "uploads/website-images/certificate.png",
                "title" => "Awarded to [student_name]",
                "sub_title" => "For completing [course]",
                "description" => "This certificate is awarded to recognize the successful completion of the course [course] offered on the platform [platform_name] by [instructor_name]. The recipient,[student_name], has demonstrated commendable dedication and proficiency.",
                "signature" => "uploads/website-images/signature.png",
                "created_at" => "2024-05-16 03:56:38",
                "updated_at" => "2024-05-16 10:02:12",
            ),
        );
        
        \DB::table('certificate_builders')->insert($certificate_builders);
    }
}
