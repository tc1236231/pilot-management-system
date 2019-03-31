<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Models\Pilot;
use App\Models\Role;
use DB;
use PDO;
use Symfony\Component\Yaml\Yaml;

/**
 * Class DevCommands
 */
class DevCommands extends Command
{
    protected $signature = 'dev {cmd} {param?}';
    protected $description = 'Developer commands';

    /**
     * DevCommands constructor.
     *
     * @param DatabaseService $dbSvc
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Run dev related commands
     */
    public function handle()
    {
        $command = trim($this->argument('cmd'));

        if (!$command) {
            $this->error('No command specified!');
            exit();
        }

        $commands = [
            'make-admin'    => 'makeAdmin',
            'compile-assets' => 'compileAssets',
            'db-attrs'       => 'dbAttrs',
            'manual-insert'  => 'manualInsert',
            'xml-to-yaml'    => 'xmlToYaml',
        ];

        if (!array_key_exists($command, $commands)) {
            $this->error('Command not found!');
            exit();
        }

        $this->{$commands[$command]}();
    }

    protected function makeAdmin()
    {
        $callsign = $this->argument('param');
        $pilot = Pilot::where('callsign',$callsign,'=')->first();
        $role = Role::where('name', 'admin')->first();
        if(!$pilot)
        {
            $this->error('callsign not found!');
            exit();
        }
        if($pilot->hasRole('admin'))
        {
            $this->error('callsign is admin!');
            exit();
        }
        $pilot->attachRole($role);
        $this->info('Done!');
    }


    /**
     * Delete all the data from the ACARS and PIREP tables
     */
    protected function clearUsers()
    {
        if (config('database.default') === 'mysql') {
            DB::statement('SET foreign_key_checks=0');
        }

        DB::statement('TRUNCATE `role_user`');
        Pilot::truncate();

        if (config('database.default') === 'mysql') {
            DB::statement('SET foreign_key_checks=1');
        }

        $this->info('Users cleared!');
    }

    /**
     * Compile all the CSS/JS assets into their respective files
     * Calling the webpack compiler
     */
    protected function compileAssets()
    {
        $this->runCommand('npm update');
        $this->runCommand('npm run dev');
    }

    /**
     * Output DB prepares versions
     */
    protected function dbAttrs()
    {
        $pdo = DB::connection()->getPdo();
        $emulate_prepares_below_version = '5.1.17';
        $server_version = $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
        $emulate_prepares = version_compare($server_version, $emulate_prepares_below_version, '<');

        $this->info('Database Server Version: '.$server_version);
        $this->info('Emulate Prepares: '.$emulate_prepares);

        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, $emulate_prepares);
    }

    /**
     * Convert the sequelpro xml export to yaml
     */
    protected function xmlToYaml()
    {
        $file = $this->argument('param');
        $this->info('Reading '.$file);

        $xml_str = file_get_contents($file);
        $xml = new \SimpleXMLElement($xml_str);

        $yaml = [];
        $table_name = (string) $xml->database->table_data['name'];
        $this->info('Writing table "'.$table_name.'"');

        $count = 0;
        $yaml[$table_name] = [];

        foreach ($xml->database->table_data->row as $row) {
            $yaml_row = [];
            foreach ($row->field as $field) {
                $fname = (string) $field['name'];
                $fvalue = (string) $field;

                $yaml_row[$fname] = $fvalue;
            }

            $yaml[$table_name][] = $yaml_row;
            $count++;
        }

        $this->info('Exporting '.$count.' rows');

        $file_name = $table_name.'.yml';
        file_put_contents(storage_path($file_name), Yaml::dump($yaml, 4, 2));
        $this->info('Writing yaml to storage: '.$file_name);
    }

    /**
     * Insert the rows from the file, manually advancing each row
     */
    protected function manualInsert(): void
    {
        $file = $this->argument('param');
        $this->info('Reading '.$file);

        if (!file_exists($file)) {
            $this->error('File '.$file.' doesn\'t exist');
            exit;
        }

        $yml = Yaml::parse(file_get_contents($file));
        foreach ($yml as $table => $rows) {
            $this->info('Importing table '.$table);
            $this->info('Number of rows: '.\count($rows));

            foreach ($rows as $row) {
                try {
                    $this->dbSvc->insert_row($table, $row);
                } catch (\Exception $e) {
                    $this->error($e);
                }

                $this->confirm('Insert next row?', true);
            }
        }
    }
}
