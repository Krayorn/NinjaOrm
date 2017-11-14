<?php 
use Ninja\Database\Model; 
 
class Film extends Model {
    protected $title;
    protected $release_date;
    protected $director;
    public function __set($propname, $value) {
        switch ($propname) {
            case 'id':
                echo '$propname == id';
                break;
            case 'title':
                echo '$propname == title';
                break;
            case 'release_date':
                echo '$propname == release_date';
                break;
            case 'director':
                echo '$propname == director';
                break;
        }
        $this->$propname = $value;
    }
}
