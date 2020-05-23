<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Test_search extends Model
{
    use Searchable;

    protected $table = 'test_search';
    public $asYouType = true;
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'age', 'school'];

    public function searchableAs()
    {
        return 'test_search_index';
    }
}
