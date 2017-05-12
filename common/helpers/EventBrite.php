<?php
namespace common\helpers;
use yii\base\Exception;
use common\helpers\CurlHelper;
/**
 * Description of meta
 * This is to get meta values from the tables created for the users information
 *
 * @author Roop Kumar <kartique79@gmail.com>
 * 
 * sample event data to be send in createEvent
 * ['event'=>[
        'event.name.html' => 'Testing event',
        'event.description.html' => 'Description of event',
        'event.organizer_id' => $eventbrite_org_id, // can generate by register organizer function
        'event.start.timezone' => 'Asia/Kolkata',
        'event.start.utc' => '2017-03-09T23:00:32Z',
        'event.end.timezone' => 'Asia/Kolkata',
        'event.end.utc' => '2017-04-09T23:00:32Z',
        'event.currency' => 'USD',
        'event.listed' => True,
        'event.shareable' => True,
        'event.invite_only' => False,
        'event.capacity' => 20,
        'event.show_remaining' => True
    ],'ticket_class'=>[
        'ticket_class.name' => 'Testing',
        'ticket_class.description'=> 'Ticket Description',
        'ticket_class.quantity_total'=> 20,
        'ticket_class.cost'=> 'USD,5000'
    ]]
 * 
 * function registerOrganizer
 * required parameters for register organizer are ['organizer.name'=> Organizername]
 * here organizer name should be unique always, alphanumerics can be used to create a unique
 * organizer name/id. It will return an array of data from eventbrite. 
 * 
 */
class EventBrite {   
    
    private $api_key = "RDCIEI3EG25PRQCSSZAW";
    
    private $version = "v3";
    
    public function createEvent($eventbrite_org_id,$data){
        $result["event"]=$result["ticket"]=$result["published"]=$tickets=[];
        
        if(empty($data) AND !isset($data['tickets']))return;

        foreach($data["tickets"] as $ticket){
            if($ticket["price"]==0){
                $tickets[]=[
                    'ticket_class.name' => $ticket["name"],
                    'ticket_class.description'=> $ticket["description"],
                    'ticket_class.quantity_total'=> $ticket["qty"],
                    'ticket_class.free'=> true
                ];
                continue;
            }
            $tickets[]=[
                'ticket_class.name' => $ticket["name"],
                'ticket_class.description'=> $ticket["description"],
                'ticket_class.quantity_total'=> $ticket["qty"],
                'ticket_class.cost'=> 'USD,'.($ticket["price"]*100)
            ];
        }
        $latlong=$data["latitude"].",".$data["longitude"];
        $timezone= json_decode(\common\helpers\Timezone::getTimezone($latlong, "1489038500"))->timeZoneId;
        
        $data=['event'=>[
            'event.name.html' => $data["title"],
            'event.description.html' => $data["title"],
            'event.organizer_id' => $eventbrite_org_id,
            'event.start.timezone' => $timezone,
            'event.start.utc' => $data["start_date"].'T'.$data["start_time"].'Z',
            'event.end.timezone' => $timezone,
            'event.end.utc' => $data["end_date"].'T'.$data["end_time"].'Z',
            'event.currency' => 'USD',
            'event.listed' => True,
            'event.shareable' => True,
            'event.invite_only' => False,
            'event.capacity' => $data["capacity"],
            'event.show_remaining' => True
        ],'ticket_class'=>$tickets];
        
        
        $result["event"]=$this->makeEvent($data);
        if(isset($result["event"]["id"]) && isset($data["ticket_class"])){
            foreach($data["ticket_class"] as $ticket){
                $result["ticket"][]=$this->makeTicket($result["event"]["id"],$ticket);
            }
        }
        if(count($result["ticket"]) && isset($result["event"]["id"])){
            $result["published"]=$this->publishEvent($result["event"]["id"]);
        }
        return $result;
    }
    
    public function makeEvent($data){
        $data=(isset($data["event"]))?$data["event"]:$data;
        $curl=new CurlHelper();
        $curl->setEndPoint("https://www.eventbriteapi.com/".$this->version."/events/?token=".$this->api_key)
             ->setCurlType("ARRAY")->setParam_filter($data);
        return (array)json_decode($curl->send()->response_json);
    }
    
    public function makeTicket($event_id,$ticket_data){
        $curl=new CurlHelper();
        $curl->setEndPoint("https://www.eventbriteapi.com/".$this->version."/events/".$event_id."/ticket_classes/?token=".$this->api_key)
             ->setCurlType("ARRAY")->setParam_filter($ticket_data);
        return (array)json_decode($curl->send()->response_json);
    }
    
    public function decreaseTickets($event_id,$ticket_id,$qty){
        $event=\common\models\EventMeta::find()->where(["event_id"=>$event_id,"meta_key"=>"eventbrite_event_id"])->one();
        $ticket=\common\models\Tickets::find()->Where(["id"=>$ticket_id])->one();
        if($event){
            $event_id=$event->meta_value;
            $curl=new CurlHelper();
            $curl->setEndPoint("https://www.eventbriteapi.com/".$this->version."/events/".$event_id."/ticket_classes/?token=".$this->api_key)
                 ->setCurlType("GET");
           
            $data=json_decode($curl->send()->response_json);
            foreach($data->ticket_classes as $t){
                if($t->name == $ticket->name && $qty>0){
                    $this->updateTicket($t->event_id,$t->id,['ticket_class.quantity_total'=> ($t->quantity_total-$qty)]);
                }
            }
        }
        
    }

    public function updateTicket($event_id,$ticket_id,$ticket_data){
        $curl=new CurlHelper();
        $curl->setEndPoint("https://www.eventbriteapi.com/".$this->version."/events/".$event_id."/ticket_classes/".$ticket_id."/?token=".$this->api_key)
             ->setCurlType("ARRAY")->setParam_filter($ticket_data);
        return $curl->send()->response_json;
    }
    
    public function publishEvent($event_id){
        $curl=new CurlHelper();
        $curl->setEndPoint("https://www.eventbriteapi.com/".$this->version."/events/".$event_id."/publish/?token=".$this->api_key)
            ->setCurlType("ARRAY")->setParam_filter([]);
        return (array)json_decode($curl->send()->response_json);
    }

    public function registerOrganizer($organizer){
        $curl=new CurlHelper();
        $curl->setEndPoint("https://www.eventbriteapi.com/".$this->version."/organizers/?token=".$this->api_key)
            ->setCurlType("ARRAY")->setParam_filter($organizer);
        return (array)json_decode($curl->send()->response_json);
    }
}