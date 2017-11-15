<?php 
use Ninja\Database\Model; 
 
class Film extends Model {
    protected $fillable = ['title', 'release_date', 'director'];
    protected $tableName = 'film';
}
