<?php 

namespace App\Services\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TaskService
{
    private $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function getAll($filters): mixed
    {
        // Check if user has permission to view any tasks
        Gate::authorize('viewAny', Task::class);
        /** @var User $user */
        $user = Auth::user();
        
        // If user is a user, add user_id filter
        if ($user->hasRole('user'))
            $filters['user_id'] = $user->id;

        $tasks = $this->model->query()
                    ->search($filters['search'] ?? null)
                    ->user($filters['user_id'] ?? null)
                    ->parent($filters['parent_id'] ?? null)
                    ->status($filters['status'] ?? null)
                    ->dueDate($filters['start_date'] ?? null, $filters['end_date'] ?? null)
                    ->orderBy($filters['sort_by'] ?? 'created_at', $filters['sort_type'] ?? 'desc');

        if (isset($filters['paginate']))
            return $tasks->paginate($filters['perPage'] ?? 12);

        return $tasks->get();
    }

    public function create($data): Task
    {
        Gate::authorize('create');
        $task = $this->model->create($data);

        return $task->refresh();
    }

    public function get(int $id): Task
    {
        $task = $this->model->query()
            ->with(['user', 'parent', 'allChildren'])
            ->find($id);

        if (!$task)
            throw new HttpException(404, 'Task not found');

        // Check if user has permission to view task
        Gate::authorize('view', $task);

        return $task;
    }

    public function update(int $id, $data): Task
    {
        $task = $this->model->find($id);

        if (!$task)
            throw new HttpException(404, 'Task not found');

        // Check if user has permission to update task
        Gate::authorize('update', $task);

        // validate compelete task
        if (!empty($data['status']) && $data['status'] === 'completed' && !$task->allChildrenCompleted()) 
            throw new HttpException(400, 'Task cannot be completed as it has subtasks are not completed');

        $task->update($data);

        return $task->refresh();
    }

    public function delete(int $id): void
    {
        $task = $this->model->find($id);

        if (!$task)
            throw new HttpException(404, 'Task not found');

        // Check if user has permission to delete task
        Gate::authorize('delete', $task);

        $task->delete();
    }
}
