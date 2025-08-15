<?php

namespace Modules\CertificateBuilder\database\seeders;

use Illuminate\Database\Seeder;

class CertificateBuilderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certificate_builder_items = array(
            array(
                "id" => 1,
                "element_id" => "title",
                "x_position" => "326.99993896484375",
                "y_position" => "208",
                "created_at" => NULL,
                "updated_at" => "2024-05-16 05:00:14",
            ),
            array(
                "id" => 2,
                "element_id" => "sub_title",
                "x_position" => "377.00006103515625",
                "y_position" => "249",
                "created_at" => NULL,
                "updated_at" => "2024-05-16 10:05:19",
            ),
            array(
                "id" => 3,
                "element_id" => "description",
                "x_position" => "25",
                "y_position" => "306",
                "created_at" => NULL,
                "updated_at" => "2024-05-16 10:45:02",
            ),
            array(
                "id" => 4,
                "element_id" => "signature",
                "x_position" => "401",
                "y_position" => "412.99998474121094",
                "created_at" => NULL,
                "updated_at" => "2024-05-16 10:14:05",
            ),
        );
    
        \DB::table('certificate_builder_items')->insert($certificate_builder_items);
    }
}
