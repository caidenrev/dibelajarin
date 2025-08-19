<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['quiz_id', 'question_text', 'options', 'correct_answer'];
    protected $casts = ['options' => 'array']; // Otomatis konversi JSON ke array

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
