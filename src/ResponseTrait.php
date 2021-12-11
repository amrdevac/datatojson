<?php

namespace Amrdevac\Datatojson;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

trait ResponseTrait
{
    public $file_not_found = "
    <bg=red>File not found !</bg=red>  
    <fg=green>
        Please select file existed on public/amrdevac
    </fg=green>
            ";
    public $method_not_found = "
    <bg=red>Method not found , please select between:</bg=red> 
    <fg=green>
        update / wipe
    </fg=green>
            ";

    public $done = "
    <fg=green>Data Succesfuly Imported !</fg=green> 
            ";
}
