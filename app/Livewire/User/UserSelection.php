<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class UserSelection extends Component
{
    /**
     * Query builder
     *
     * @var Builder
     */
    protected Builder $query;
    public string $search_input = '';
    public bool $only_staff = false;

    public ?User $selected = null;

    public string $view_mode = 'normal';

    /**
     * The event which should be fired when an user selected in this component
     *
     * @var string
     */
    public string $selection_event = 'userSelected';

    /**
     * Event listenter which is responsible for setting the selected user from parent components
     *
     * @var array
     */
    protected $listeners = [
        'setSelectedUser'
    ];

    public function mount($selection_event = 'userSelected')
    {
        $this->selection_event = $selection_event;
    }

    public function setSelectedUser(int $user) {
        $this->selected = User::find($user);
    }

    protected function getUsers()
    {
        $this->query = User::query()
            ->with('role')
            ->limit(10)
            ->latest();

        if ($this->only_staff) {
            $this->query->where('role_id', '!=', 0);
        }

        if (!empty($this->search_input)) {
            $this->query->where(function ($query) {
                $query->where('id', 'LIKE', $this->search_input)
                    ->orWhere('number', 'LIKE', '%' . $this->search_input . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->search_input . '%')
                    ->orWhere('full_name', 'LIKE', '%' . $this->search_input . '%');
            });
        }

        return $this->query->get();
    }

    public function selectUser(int $user_id)
    {
        // deselect if the id is same:
        if ($this->selected && $user_id === $this->selected->id) {
            $this->selected = null;
        } else {
            $user = User::find($user_id);
            if ($user) $this->selected = $user;
        }

        $this->dispatch($this->selection_event, $this->selected->id ?? null);
    }

    public function render()
    {
        $users = $this->getUsers();

        return view('livewire.user.user-selection', compact('users'));
    }
}