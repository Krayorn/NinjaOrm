<?php 
use Ninja\Database\Model; 
 
class Cinema extends Model {
    protected $tableName = 'cinema';
    protected $id;
    protected $fillable = ['name' => ['nullable' => 'NO', 'type' =>'string'], 
                            'address' => ['nullable' => 'YES', 'type' =>'string'], 
                            'zip_code' => ['nullable' => 'YES', 'type' =>'string'], 
                            'city' => ['nullable' => 'YES', 'type' =>'string']];
}
