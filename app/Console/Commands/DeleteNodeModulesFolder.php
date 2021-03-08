<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteNodeModulesFolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vapor-deploy:remove-node-modules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the node module folder when deploying with vapor';

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

        $this->info('Deleting Node Modules');
        $this->info($this->delete('node_modules'));

        $this->info('Deleting Storage');
        $this->info($this->delete('public/storage'));

        return 0;
    }

    private function delete($dirname)
    {
        if (is_dir($dirname)) {
            $dir_handle = opendir($dirname);
        } else {
            return 'Cannot find the folder';
        }
        if (!$dir_handle)
            return 'Cannot open the folder';
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file))
                    unlink($dirname . "/" . $file);
                else
                    $this->delete($dirname . '/' . $file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return 'Folder deleted';
    }
}
