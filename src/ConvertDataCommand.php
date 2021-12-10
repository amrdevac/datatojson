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

        $path = public_path("amrdevac");
        $table = $this->argument('table');
        $filename = "file_$table.json";

        $this->line("Converting To Data <fg=green>$table.</fg=green>");
        $this->line(" Your file name would be <bg=blue;>$filename</bg=blue;>");
        if (!is_dir($path)) mkdir($path, 777);

        $myfile = fopen($path . "/$filename", "w") or die("Unable to open file!");
        $txt = DB::table($table)->get();
        fwrite($myfile, $txt);


        return Command::SUCCESS;
    }
}
