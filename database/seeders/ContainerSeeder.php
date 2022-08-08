<?php

namespace Database\Seeders;

use App\Models\ConservationTime;
use App\Models\ConservationType;
use App\Models\DocumentValue;
use App\Models\InformationType;
use App\Models\SelectionTechnique;
use Illuminate\Database\Seeder;

class ContainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Document Values
        DocumentValue::factory([
            "name" => "Administrativo",
            "code" => "A"
        ])->create();
        DocumentValue::factory([
            "name" => "Legal",
            "code" => "L"
        ])->create();
        DocumentValue::factory([
            "name" => "Contable",
            "code" => "C"
        ])->create();

        //Conservation Times
        ConservationTime::factory([
            "name" => "Trámite",
            "code" => "AT"
        ])->create();
        ConservationTime::factory([
            "name" => "Concentración",
            "code" => "AC"
        ])->create();
        ConservationTime::factory([
            "name" => "Histórico",
            "code" => "AH"
        ])->create();

        //Selection Techniques
        SelectionTechnique::factory([
            "name" => "Eliminación",
            "code" => "E"
        ])->create();
        SelectionTechnique::factory([
            "name" => "Conservación",
            "code" => "C"
        ])->create();
        SelectionTechnique::factory([
            "name" => "Muestreo",
            "code" => "M"
        ])->create();

        //Conservation Types
        ConservationType::factory([
            "name" => "Físico",
            "code" => "F"
        ])->create();
        ConservationType::factory([
            "name" => "Electrónico",
            "code" => "E"
        ])->create();

        //Information Types
        InformationType::factory([
            "name" => "Pública",
            "code" => "P"
        ])->create();
        InformationType::factory([
            "name" => "Reservada",
            "code" => "R"
        ])->create();
        InformationType::factory([
            "name" => "Confidencial",
            "code" => "C"
        ])->create();

    }
}
