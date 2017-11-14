<?php 
use Ninja\Database\Model; 
 
class Cinema extends Model {
    protected $name;
    protected $address;
    protected $zip_code;
    protected $city;
    public function __set($propname, $value) {
        switch ($propname) {
            case 'id':
                echo '$propname == id';
                break;
            case 'name':
                echo '$propname == name';
                break;
            case 'address':
                echo '$propname == address';
                break;
            case 'zip_code':
                echo '$propname == zip_code';
                break;
            case 'city':
                echo '$propname == city';
                break;
        }
        $this->$propname = $value;
    }
}
