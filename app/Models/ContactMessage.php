<?php
// app/Models/ContactMessage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['name','email','subject','message','consent','meta'];
    protected $casts = [
        'consent' => 'bool',
        'is_read' => 'bool',
        'replied_at' => 'datetime',
        'meta' => 'array',
    ];
}


