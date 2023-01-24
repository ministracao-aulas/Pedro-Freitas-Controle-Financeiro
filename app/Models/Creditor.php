<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Creditor
 *
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property string|null $doc_type
 * @property string|null $doc
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\CreditorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Creditor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Creditor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Creditor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Creditor whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Creditor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Creditor whereDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Creditor whereDocType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Creditor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Creditor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Creditor whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Creditor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Creditor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active',
        'doc',
        'doc_type',
        'note',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
