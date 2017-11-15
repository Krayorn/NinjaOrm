<?php 
use Ninja\Database\Model; 
 
class Cinema extends Model {
    protected $fillable = ['name', 'address', 'zip_code', 'city'];
    protected $tableName = 'cinema';
}
