<?php

namespace Database\Seeders;

use App\Models\Background;
use App\Models\DocumentType;
use App\Models\ProductionArea;
use App\Models\Section;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Document types list
        DocumentType::factory([
            "name" => "Carta de no adeudo",
            "code" => "CNA"
        ])->create();
        DocumentType::factory([
            "name" => "Constancia de servicio social",
            "code" => "CSS"
        ])->create();
        DocumentType::factory([
            "name" => "Lista de asistencia",
            "code" => "LDA"
        ])->create();
        DocumentType::factory([
            "name" => "Minuta de reunión",
            "code" => "MDR"
        ])->create();
        DocumentType::factory([
            "name" => "Acta de calificaciones",
            "code" => "ADC"
        ])->create();

        //Backgrounds List
        Background::factory([
            "name" => "Instituto Tecnológico Superior de Lerdo",
            "code" => "ITSL"
        ])->create();

        //Sections list
        Section::factory([
            "name" => "Legislación",
            "code" => "1C"
        ])->create();
        Section::factory([
            "name" => "Asuntos Jurídicos",
            "code" => "2C"
        ])->create();
        Section::factory([
            "name" => "Planeación, Programación, Presupuestación y Evaluación",
            "code" => "3C"
        ])->create();
        Section::factory([
            "name" => "Recursos Humanos",
            "code" => "4C"
        ])->create();
        Section::factory([
            "name" => "Recursos Financieros",
            "code" => "5C"
        ])->create();
        Section::factory([
            "name" => "Servicios Generales",
            "code" => "6C"
        ])->create();
        Section::factory([
            "name" => "Tecnologías de la Información",
            "code" => "7C"
        ])->create();
        Section::factory([
            "name" => "Comunicación",
            "code" => "8C"
        ])->create();
        Section::factory([
            "name" => "Contraloría",
            "code" => "9C"
        ])->create();
        Section::factory([
            "name" => "Transparencia y Acceso a la Información y Protección de Datos Personales",
            "code" => "10C"
        ])->create();
        Section::factory([
            "name" => "Académica",
            "code" => "1S"
        ])->create();
        Section::factory([
            "name" => "Investigación Cientifica y Tecnológica",
            "code" => "2S"
        ])->create();
        Section::factory([
            "name" => "Control Escolar",
            "code" => "3S"
        ])->create();
        Section::factory([
            "name" => "Gobierno",
            "code" => "4S"
        ])->create();

        //Production areas
        ProductionArea::factory([
            "name" => "Dirección General",
            "code" => "DG"
        ])->create();
        ProductionArea::factory([
            "name" => "Dirección Académica",
            "code" => "DA"
        ])->create();
        ProductionArea::factory([
            "name" => "Dirección Administrativa",
            "code" => "DD"
        ])->create();
        ProductionArea::factory([
            "name" => "Planeación, Programación y Presupuestación",
            "code" => "PP"
        ])->create();
        ProductionArea::factory([
            "name" => "Departamento de Compras",
            "code" => "DO"
        ])->create();
        ProductionArea::factory([
            "name" => "Recursos Humanos",
            "code" => "RH"
        ])->create();
        ProductionArea::factory([
            "name" => "División de Servicios Escolares",
            "code" => "SE"
        ])->create();
        ProductionArea::factory([
            "name" => "Departamento de Actividades Extraescolares",
            "code" => "AE"
        ])->create();
        ProductionArea::factory([
            "name" => "Desarrollo Académico",
            "code" => "DC"
        ])->create();
        ProductionArea::factory([
            "name" => "Departamento de Vinculación",
            "code" => "DV"
        ])->create();
        ProductionArea::factory([
            "name" => "Recursos Financieros",
            "code" => "RF"
        ])->create();
        ProductionArea::factory([
            "name" => "Centro de Información",
            "code" => "CI"
        ])->create();
        ProductionArea::factory([
            "name" => "División de Ingeniería Industrial",
            "code" => "DI"
        ])->create();
        ProductionArea::factory([
            "name" => "División de Sistemas Automotrices",
            "code" => "SA"
        ])->create();
        ProductionArea::factory([
            "name" => "Departamento de Comunicación y Difusión",
            "code" => "CD"
        ])->create();
        ProductionArea::factory([
            "name" => "Subdirección de Servicios Informáticos",
            "code" => "SI"
        ])->create();
        ProductionArea::factory([
            "name" => "División de Sistemas",
            "code" => "DS"
        ])->create();
        ProductionArea::factory([
            "name" => "División de Informática",
            "code" => "DF"
        ])->create();
        ProductionArea::factory([
            "name" => "División de Electromecánica",
            "code" => "DM"
        ])->create();
        ProductionArea::factory([
            "name" => "División de Electrónica",
            "code" => "DE"
        ])->create();
        ProductionArea::factory([
            "name" => "Dpto. Centro de Cómputo",
            "code" => "CC"
        ])->create();
        ProductionArea::factory([
            "name" => "División de Ambiental",
            "code" => "DB"
        ])->create();
        ProductionArea::factory([
            "name" => "División de Gestión Empresarial",
            "code" => "GE"
        ])->create();
        ProductionArea::factory([
            "name" => "Subdirección de Planeación",
            "code" => "SP"
        ])->create();
        ProductionArea::factory([
            "name" => "Subdirección de Investigación y Desarrollo Tecnológico",
            "code" => "SD"
        ])->create();
        ProductionArea::factory([
            "name" => "Servicios Estudiantiles",
            "code" => "SS"
        ])->create();
        ProductionArea::factory([
            "name" => "Coordinación de Inglés",
            "code" => "CL"
        ])->create();
        ProductionArea::factory([
            "name" => "Departamento de Gestión de la Calidad",
            "code" => "SG"
        ])->create();
        ProductionArea::factory([
            "name" => "Subdirección Académica",
            "code" => "SC"
        ])->create();
        ProductionArea::factory([
            "name" => "Subdirección Administrativa",
            "code" => "SM"
        ])->create();
        ProductionArea::factory([
            "name" => "Servicios Generales",
            "code" => "MT"
        ])->create();
        ProductionArea::factory([
            "name" => "División de Posgrado",
            "code" => "DP"
        ])->create();
        ProductionArea::factory([
            "name" => "Enlace Interinstitucional",
            "code" => "EI"
        ])->create();
        ProductionArea::factory([
            "name" => "Unidad de Transparencia",
            "code" => "UT"
        ])->create();

    }
}
