<?php 
use Ninja\Database\Model; 
 
class Film extends Model {
    protected $tableName = 'film';
    protected $id;
    protected $fillable = ['title', 'release_date', 'director'];
    protected $nullable = ['release_date', 'director'];
}
