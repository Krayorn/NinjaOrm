<?php 
use Ninja\Database\Model; 
 
class Seance extends Model {
    protected $tableName = 'seance';
    protected $fillable = ['film_id', 'start_horaire', 'end_horaire', 'nsalle', 'jour', 'evenement', 'cinema_id', 'description_event', 'description', 'technique', 'repeat_event_json', 'booking_url', 'hidden'];
    protected $nullable = ['evenement', 'description_event', 'description', 'repeat_event_json', 'booking_url'];
}
