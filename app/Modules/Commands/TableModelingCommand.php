<?php

namespace App\Modules\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TableModelingCommand extends Command
{

    protected $signature = 'make:table {module_name} {[field]?} {--model}';
    protected $description = 'Create a folder and files in the app directory';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $moduleName = $this->argument('module_name');
        $ViewModuleName = $this->argument('module_name');
        // $migration = $this->option('m');
        // $seed = $this->option('seed');
        $fields = [];



        // Check if the field argument is provided
        if ($this->hasArgument('[field]') && $this->argument('[field]')) {
            $fieldName = $this->argument('[field]');
            $fieldName = str_replace('[', '', $fieldName);
            $fieldName = str_replace(']', '', $fieldName);
            $fieldName = explode(',', $fieldName);
            foreach ($fieldName as $item) {
                $fields[] =  explode(':', $item);
            }
        }





        $baseDirectory = app_path("Modules/Management/");
        $format_dir = explode('/', $moduleName);
        $module_dir = null;

        if (count($format_dir) > 1) {
            $moduleName = end($format_dir);
            array_pop($format_dir); //if do not make last name folder
            $module_dir = implode('/', $format_dir);
            if (!File::isDirectory($baseDirectory . $module_dir)) {
                mkdir($baseDirectory . $module_dir, 0777, true);
            }
            $baseDirectory = $baseDirectory . $module_dir . '/';
        }

        $table = Str::plural((Str::snake($moduleName)));




        $migrationtable = 'create_' . $table . '_table.php';
        $model = $moduleName . 'Model.php';
        $actionFiles = [
            $model,
            $migrationtable,

        ];



        if ($module_dir != null) {
            $module_name = $module_dir . '/' . $moduleName;
        } else {
            $module_name = $moduleName;
        }



        $ModelDirectory = $baseDirectory  . '/Models';

        if (!File::isDirectory($ModelDirectory)) {
            File::makeDirectory($ModelDirectory);
        }



        $DatabaseDirectory = $baseDirectory  . '/Database';
        if (!File::isDirectory($DatabaseDirectory)) {
            File::makeDirectory($DatabaseDirectory);
        }

        foreach ($actionFiles as $file) {
            if ($file == $model) {

                File::put($ModelDirectory . '/' . $file, TableModel($module_name, $moduleName));
            }
            if ($file == $migrationtable) {

                File::put($DatabaseDirectory  . '/' . $file, TableMigration($module_name, $fields));
            }
        }



        if (true) {
            $table_name = '';
            $formated_module = explode('/', $ViewModuleName);
            if (count($formated_module) > 1) {
                array_pop($formated_module);
                $moduleName = implode('/', $formated_module);
                $moduleName = Str::replace("/", "\\", $moduleName);
                $table_name = Str::plural((Str::snake($formated_module[count($formated_module) - 1])));
            } else {
                $table_name = Str::plural((Str::snake($moduleName)));
                $moduleName = Str::replace("/", "\\", $moduleName);
            }


            $migrationPath = "\App\\Modules\\Management\\{$moduleName}\\Database\\create_{$table_name}_table.php";
            Artisan::call('migrate', ['--path' => $migrationPath]);
        }
    }
}
