<?php

namespace Modules\Wpbox\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Log;
use App\Models\User;

class LogsTable extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';
    public $userId = '';

    protected $queryString = ['userId'];

    public function updatingUserId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::orderBy('name')->get();
        $logsQuery = Log::query()->with('user');
        if ($this->userId) {
            $logsQuery->where('user_id', $this->userId);
        } 
        $logs = $logsQuery->orderByDesc('last_activity')->paginate(10);
        return view('wpbox::Livewire.logs.logs-table', [
            'logs' => $logs,
            'users' => $users,
        ]);
    }
}
