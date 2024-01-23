<?php

namespace App\Models;

use App\Utils\Filter\AbstractFilter;
use App\Utils\Filter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string|int $id
 * @property string $name
 * @property string $desc
 * @property string $updated_at
 * @property string $created_at
 *
 * @method Builder filter(AbstractFilter $filter)
 */
final class Task extends Model
{
    use Filterable, HasFactory;

    protected $guarded = [];
}
