<?php 
use Ninja\Database\Model; 
 
class Cinema extends Model {
    protected $tableName = 'cinema';
    public static $has;
    protected $fillable = ['name' => ['nullable' => 'NO', 'type' =>'string'], 
                            'address' => ['nullable' => 'YES', 'type' =>'string'], 
                            'zip_code' => ['nullable' => 'YES', 'type' =>'string'], 
                            'city' => ['nullable' => 'YES', 'type' =>'string']];
    public static function has($data) {
        Cinema::$has = $data;
    }
}
