<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseType;

class CourseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseType::create(['course_id' => 1, 'name' => 'Auto CAD']);
        CourseType::create(['course_id' => 1, 'name' => 'Auto CAD Electrical']);
        CourseType::create(['course_id' => 1, 'name' => 'Revit Architecture']);
        CourseType::create(['course_id' => 1, 'name' => 'Revit Structure']);
        CourseType::create(['course_id' => 1, 'name' => 'Revit MEP']);
        CourseType::create(['course_id' => 1, 'name' => 'SketchUp']);
        CourseType::create(['course_id' => 1, 'name' => '3ds Max']);
        CourseType::create(['course_id' => 1, 'name' => 'Lumion']);
        CourseType::create(['course_id' => 1, 'name' => 'STAAD. Pro']);
        CourseType::create(['course_id' => 1, 'name' => 'ETABS']);
        CourseType::create(['course_id' => 1, 'name' => 'BIM 360']);
        CourseType::create(['course_id' => 1, 'name' => 'Primavera']);
        CourseType::create(['course_id' => 1, 'name' => 'MSP']);
        CourseType::create(['course_id' => 1, 'name' => 'Microstation']);

        CourseType::create(['course_id' => 2, 'name' => 'AutoCAD']);
        CourseType::create(['course_id' => 2, 'name' => 'Solidworks']);
        CourseType::create(['course_id' => 2, 'name' => 'Solidworks Motion']);
        CourseType::create(['course_id' => 2, 'name' => 'Creo']);
        CourseType::create(['course_id' => 2, 'name' => 'Creo Simulate']);
        CourseType::create(['course_id' => 2, 'name' => 'Catia']);
        CourseType::create(['course_id' => 2, 'name' => 'Catia Kinematics']);
        CourseType::create(['course_id' => 2, 'name' => 'Inventor']);
        CourseType::create(['course_id' => 2, 'name' => 'NX CAD']);
        CourseType::create(['course_id' => 2, 'name' => 'NX CAM']);
        CourseType::create(['course_id' => 2, 'name' => 'NX Nastran']);
        CourseType::create(['course_id' => 2, 'name' => 'ANSYS Workbench']);
        CourseType::create(['course_id' => 2, 'name' => 'Hypermesh']);
        CourseType::create(['course_id' => 2, 'name' => 'Fusion 360']);
        CourseType::create(['course_id' => 2, 'name' => 'GD & T']);
        CourseType::create(['course_id' => 2, 'name' => 'PDMS']);
        CourseType::create(['course_id' => 2, 'name' => 'HVAC']);
        CourseType::create(['course_id' => 2, 'name' => 'ANSYS FLUID']);
        CourseType::create(['course_id' => 2, 'name' => 'Navisworks']);

        CourseType::create(['course_id' => 3, 'name' => 'Adobe Photoshop']);
        CourseType::create(['course_id' => 3, 'name' => 'Adobe Premier Pro']);
        CourseType::create(['course_id' => 3, 'name' => 'Adobe Illustrator']);
        CourseType::create(['course_id' => 3, 'name' => 'Adobe Animate']);
        CourseType::create(['course_id' => 3, 'name' => 'Adobe InDesign']);

        CourseType::create(['course_id' => 4, 'name' => 'Maya']);
        CourseType::create(['course_id' => 4, 'name' => '3ds Max']);
        CourseType::create(['course_id' => 4, 'name' => 'Nuke']);
        CourseType::create(['course_id' => 4, 'name' => 'Fusion']);
        CourseType::create(['course_id' => 4, 'name' => 'Cinema 4D']);
        CourseType::create(['course_id' => 4, 'name' => 'Adobe After Effects']);

        CourseType::create(['course_id' => 5, 'name' => 'Unity']);
        CourseType::create(['course_id' => 5, 'name' => 'Unreal Engine']);
        CourseType::create(['course_id' => 5, 'name' => 'Blender']);
        CourseType::create(['course_id' => 5, 'name' => 'Game Maker']);
        CourseType::create(['course_id' => 5, 'name' => 'ZBrush']);
        CourseType::create(['course_id' => 5, 'name' => 'Godot']);
    }
}
