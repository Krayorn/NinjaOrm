<?php 
use Ninja\Database\Model; 
 
class Seance extends Model {
    protected $fillable = ['film_id', 'start_horaire', 'end_horaire', 'nsalle', 'jour', 'evenement', 'cinema_id', 'description_event', 'description', 'technique', 'repeat_event_json', 'booking_url', 'hidden'];
    protected $tableName = 'seance';
}
