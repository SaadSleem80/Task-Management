<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'parent_id',
        'status',
        'due_date'
    ];

    protected $casts = [
        'title'         => 'string',
        'description'   => 'string',
        'user_id'       => 'integer',
        'parent_id'     => 'integer',
        'status'        => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function allChildrenCompleted(): bool
    {
        foreach ($this->children as $child) {
            if ($child->status !== 'completed' || !$child->allChildrenCompleted()) {
                return false;
            }
        }
        return true;
    }

    public function scopeSearch($query, $search)
    {
        $query->when(isset($search), function ($query) use ($search) {
            return $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
        });
    }
    

    public function scopeStatus($query, $status)
    {
        $query->when(isset($status), function ($query) use ($status) {
            return $query->where('status', $status);
        });
    }

    public function scopeUser($query, $user_id)
    {
        $query->when(isset($user_id), function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        });
    }

    public function scopeParent($query, $parent_id)
    {
        $query->when(isset($parent_id), function ($query) use ($parent_id) {
            return $query->where('parent_id', $parent_id);
        });
    }

    public function scopeDueDate($query, $start_date = null, $end_date = null)
    {
        return $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            $query->whereBetween('due_date', [$start_date, $end_date]);
        });
    }
    
}
