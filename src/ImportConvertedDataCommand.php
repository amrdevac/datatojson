<?php

namespace Amrdevac\Datatojson;

use DirectoryIterator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportConvertedDataCommand extends Command
{
    use ResponseTrait;

    private $method_selected;
    private $path;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amr:import-converted 
        {table : Table Target} 
        {primaryKey : PrimaryKey Table Target} 
    ';
    // {method :  Method to import wipe/update}


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

        ini_set('memory_limit', '-1');
        $this->initializeFile();
        return Command::SUCCESS;
    }

    public function initializeFile()
    {
        $table = $this->argument('table');
        $this->path  = public_path("amrdevac/$table/file_$table.json");
        if (!file_exists($this->path)) {
            $this->line($this->file_not_found);
            dd();
        }
        $this->line("Table Selected <fg=green>$table</fg=green>");
        $dir = new DirectoryIterator(dirname($this->path));
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $this->importingDataToTable($fileinfo->getPathname());
            }
        }
    }
    public function importingDataToTable($file_to_imported)
    {
        $table = $this->argument('table');
        $json_data_to_array =  json_decode(file_get_contents($file_to_imported), true);
        $insert_data = collect($json_data_to_array); 
        
        $chunks = $insert_data->chunk(450);
        foreach ($chunks as $chunk) {
            \DB::table($table)->upsert($chunk->toArray(),$this->argument("primaryKey"));   
        }
    }
}
