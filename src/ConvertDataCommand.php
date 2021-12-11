<?php

namespace Amrdevac\Datatojson;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amr:convert {table : Table Name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exporting data as JSON to 1 file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $table = $this->argument('table');
        $path = public_path("amrdevac/$table");
        $filename = "file_$table.json";

        $this->line("Converting To Data <fg=green>$table.</fg=green>");
        $this->line(" Your file name would be <bg=blue;>$filename</bg=blue;>");

        if (!is_dir($path)) {
            mkdir($path, 777);
        } else {
            array_map('unlink', glob("$path/*"));
            rmdir($path);
            mkdir($path, 777);
        }

        $dataToInsert = [];

        DB::table($table)->orderBy("created_at")->chunk(100000, function ($datas) use ($dataToInsert) {

            $table = $this->argument('table');
            $path = public_path("amrdevac/$table");

            $filename = "file_$table.json";

            $myfile = "";
            if (file_exists($path . "/$filename")) {
                $filename = "file_$table" . time() . ".json";
                $myfile = fopen($path . "/$filename", "w") or die("Unable to open file!");
            } else {
                $myfile = fopen($path . "/$filename", "w") or die("Unable to open file!");
            }

            foreach ($datas as  $data) {
                $dataToInsert[] = $data;
            }

            fwrite($myfile, json_encode($dataToInsert));
        });

        return Command::SUCCESS;
    }
};
