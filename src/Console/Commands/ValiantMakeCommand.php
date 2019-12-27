<?php

namespace Kdion4891\Valiant\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ValiantMakeCommand extends Command
{
    protected $signature = 'valiant:make {model}';
    protected $description = 'Generate new Valiant model scaffolding.';
    private $files;
    private $replaces;
    private $stubs_path = __DIR__ . '/../../../resources/stubs';

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $model_title = trim(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', ' $0', $this->argument('model')));
        $model_titles = Str::plural($model_title);

        $this->replaces = [
            'DummyControllerClass' => $this->argument('model') . 'Controller',
            'DummyModelClass' => $this->argument('model'),
            'DummyMigrationClass' => 'Create' . str_replace(' ', '', $model_titles) . 'Table',
            'DummyModelTitles' => $model_titles,
            'DummyTable' => Str::snake($model_titles),
        ];

        $this->createController();
        $this->createModel();
        $this->createMigration();
        $this->insertNavItem();
        $this->insertRoute();
    }

    private function createController()
    {
        $file = 'Http/Controllers/' . $this->replaces['DummyControllerClass'] . '.php';
        $info = 'app/' . $file;
        $path = app_path($file);

        if ($this->files->exists(($path))) {
            $this->warn('Controller file exists: <info>' . $info . '</info>');
            return;
        }

        $content = $this->files->get($this->stubs_path . '/controllers/ModelController.stub');
        $this->files->put($path, $this->replace($content));
        $this->line('Controller file created: <info>' . $info . '</info>');
    }

    private function createModel()
    {
        $file = $this->replaces['DummyModelClass'] . '.php';
        $info = 'app/' . $file;
        $path = app_path($file);

        if ($this->files->exists(($path))) {
            $this->warn('Model file exists: <info>' . $info . '</info>');
            return;
        }

        $content = $this->files->get($this->stubs_path . '/models/Model.stub');
        $this->files->put($path, $this->replace($content));
        $this->line('Model file created: <info>' . $info . '</info>');
    }

    private function createMigration()
    {
        $suffix = '_create_' . $this->replaces['DummyTable'] . '_table.php';

        if ($existing = glob(database_path('migrations/*' . $suffix))) {
            $info = 'database' . str_replace(database_path(), '', $existing[0]);
            $this->warn('Migration file exists: <info>' . $info . '</info>');
            return;
        }

        $file = date('Y_m_d_His') . $suffix;
        $info = 'database/migrations/' . $file;
        $path = database_path('migrations/' . $file);

        $content = $this->files->get($this->stubs_path . '/migration.stub');
        $this->files->put($path, $this->replace($content));
        $this->line('Migration file created: <info>' . $info . '</info>');
    }

    private function insertNavItem()
    {
        $file = 'views/vendor/valiant/layouts/navs/sidebar.blade.php';
        $info = 'resources/' . $file;
        $path = resource_path($file);

        if (!$this->files->exists($path)) {
            $this->error('Sidebar file missing: <info>' . $info . '</info>');
            return;
        }

        $file_content = $this->files->get($path);
        $stub_content = $this->replace($this->files->get($this->stubs_path . '/nav-item.stub'));

        if (strpos($file_content, $stub_content) !== false) {
            $this->warn('Nav item exists in: <info>' . $info . '</info>');
            return;
        }

        $this->files->prepend($path, $stub_content);
        $this->line('Nav item inserted in: <info>' . $info . '</info>');
    }

    private function insertRoute()
    {
        $file = 'routes/web.php';
        $path = base_path($file);
        $file_content = $this->files->get($path);
        $stub_content = $this->replace($this->files->get($this->stubs_path . '/routes/route.stub'));

        if (strpos($file_content, $stub_content) !== false) {
            $this->warn('Route exists in: <info>' . $file . '</info>');
            return;
        }

        $this->files->append($path, $stub_content);
        $this->line('Route inserted in: <info>' . $file . '</info>');
    }

    public function replace($content)
    {
        foreach ($this->replaces as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }

        return $content;
    }
}
