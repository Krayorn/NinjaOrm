<?php 
use Ninja\Database\Model; 
 
class Seance extends Model {
    protected $film_id;
    protected $start_horaire;
    protected $end_horaire;
    protected $nsalle;
    protected $jour;
    protected $evenement;
    protected $cinema_id;
    protected $description_event;
    protected $description;
    protected $technique;
    protected $repeat_event_json;
    protected $booking_url;
    protected $hidden;
    public function __set($propname, $value) {
        switch ($propname) {
            case 'id':
                echo '$propname == id';
                break;
            case 'film_id':
                echo '$propname == film_id';
                break;
            case 'start_horaire':
                echo '$propname == start_horaire';
                break;
            case 'end_horaire':
                echo '$propname == end_horaire';
                break;
            case 'nsalle':
                echo '$propname == nsalle';
                break;
            case 'jour':
                echo '$propname == jour';
                break;
            case 'evenement':
                echo '$propname == evenement';
                break;
            case 'cinema_id':
                echo '$propname == cinema_id';
                break;
            case 'description_event':
                echo '$propname == description_event';
                break;
            case 'description':
                echo '$propname == description';
                break;
            case 'technique':
                echo '$propname == technique';
                break;
            case 'repeat_event_json':
                echo '$propname == repeat_event_json';
                break;
            case 'booking_url':
                echo '$propname == booking_url';
                break;
            case 'hidden':
                echo '$propname == hidden';
                break;
        }
        $this->$propname = $value;
    }
}
