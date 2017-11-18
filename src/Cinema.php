<?php 
use Ninja\Database\Model; 
 
class Cinema extends Model {
    protected $tableName = 'cinema';
    protected $id;
    protected $fillable = ['name', 'address', 'zip_code', 'city'];
    protected $nullable = ['address', 'zip_code', 'city'];
}
