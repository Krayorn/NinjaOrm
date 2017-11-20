<?php 
use Ninja\Database\Model; 
 
class Film extends Model {
    protected $tableName = 'film';
    public static $has;
    protected $fillable = ['title' => ['nullable' => 'NO', 'type' =>'string'], 
                            'release_date' => ['nullable' => 'YES', 'type' =>'datetime'], 
                            'director' => ['nullable' => 'YES', 'type' =>'string']];
    public static function has($data) {
        Film::$has = $data;
    }
}
