<?php

namespace App\Livewire\Table;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\WithPagination;
use Laravel\SerializableClosure\SerializableClosure;

class Table extends Component
{
    use WithPagination;
    public Model $model;

    public string $operation = 'none';
    // public bool $deletable = false;
    public int $selected_id = 0;

    public array $actions = [];
    public array $columns = [];

    public array $filters = [
        'limit' => 25
    ];

    public array $errors = [];

    public function mount(array $columns)
    {
        foreach ($columns as $key => $value) {
            if (isset($value['callback'])) {
                $columns[$key]['callback'] = serialize(new SerializableClosure($columns[$key]['callback']));
            }
        }
        $this->columns = $columns;
        
        foreach ($this->actions as $key => $value) {
            $this->actions[$key] = serialize(new SerializableClosure($value));
        }
    }

    public function load()
    {
        // $this->columns = cache()->get('columns');
    }

    protected function queryBuilder()
    {
        $query = $this->model::query();

        // $query->select(array_keys($this->columns));

        return $query->paginate($this->filters['limit']);
    }

    public function toggleHiddenColumn($key)
    {
        $this->columns[$key]['hidden'] = !$this->columns[$key]['hidden'];
    }

    public function deleteModel(int $id)
    {
        if ($this->selected_id == $id && $this->operation == 'delete') {
            $this->model::whereId($id)->delete();
            $this->operation = 'none';

            return true;
        }

        $this->selected_id = $id;
        $this->operation = 'delete';
    }

    public function render()
    {
        return view('livewire.table.table', ['datas' => $this->queryBuilder()]);
    }
}
