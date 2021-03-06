<?php

namespace Mattmangoni\NovaBlogifyTool\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function author() : BelongsTo
    {
        return $this->belongsTo(config('nova-blogify-tool.model'), 'user_id');
    }
}
