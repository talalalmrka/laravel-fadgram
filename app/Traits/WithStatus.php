<?php

namespace App\Traits;

trait WithStatus
{
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    public function scopePublish($query)
    {
        return $query->where('status', 'publish');
    }
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
    public function scopeTrash($query)
    {
        return $query->where('status', 'trash');
    }
}
