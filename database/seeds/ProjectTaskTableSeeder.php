<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 17/01/2017
 * Time: 18:29
 */

use Illuminate\Database\Seeder;

class ProjectTaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \CodeProject\Entities\ProjectTask::truncate();
        factory(\CodeProject\Entities\ProjectTask::class, 10)->create();
    }
}