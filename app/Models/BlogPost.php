<?php
// app/Models/BlogPost.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class BlogPost extends Model {
protected $fillable = ['user_id','title','slug','excerpt','body','cover','is_published','published_at'];
protected $casts = ['is_published'=>'boolean','published_at'=>'datetime'];
public function author(): BelongsTo { return $this->belongsTo(User::class,'user_id'); }
}
