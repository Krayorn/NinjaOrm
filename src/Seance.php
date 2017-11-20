<?php 
use Ninja\Database\Model; 
 
class Seance extends Model {
    protected $tableName = 'seance';
    public static $has;
    protected $fillable = ['film_id' => ['nullable' => 'NO', 'type' =>'int'], 
                            'start_horaire' => ['nullable' => 'NO', 'type' =>'datetime'], 
                            'end_horaire' => ['nullable' => 'NO', 'type' =>'datetime'], 
                            'nsalle' => ['nullable' => 'NO', 'type' =>'int'], 
                            'jour' => ['nullable' => 'NO', 'type' =>'datetime'], 
                            'evenement' => ['nullable' => 'YES', 'type' =>'string'], 
                            'cinema_id' => ['nullable' => 'NO', 'type' =>'int'], 
                            'description_event' => ['nullable' => 'YES', 'type' =>'string'], 
                            'description' => ['nullable' => 'YES', 'type' =>'string'], 
                            'technique' => ['nullable' => 'NO', 'type' =>'string'], 
                            'repeat_event_json' => ['nullable' => 'YES', 'type' =>'string'], 
                            'booking_url' => ['nullable' => 'YES', 'type' =>'string'], 
                            'hidden' => ['nullable' => 'NO', 'type' =>'int']];
    public static function has($data) {
        Seance::$has = $data;
    }
}
