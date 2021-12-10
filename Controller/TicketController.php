<?php 

    namespace App\Controller;

    require_once(__DIR__.'/../Model/TicketModel.php');

    use Framework\Controller;
    use App\Model\TicketModel;

    class TicketController{

        public function findAll():string{

            $allTicket = new TicketModel();
            $tickets = $allTicket->all();
            if($tickets){
                $result = [
                    "status" => 200,
                    "result" => $tickets
                ];
            }
            echo(json_encode($result));
            return json_encode($result);
        }

        public function findById(int $ticket_id):string{
            
            $ticketModel = new TicketModel();
            $ticket = $ticketModel->findById($ticket_id);
            if ($ticket){
                $result = [
                    "status" => 200,
                    "result" => $ticket
                ];
            } else {
                $result = [
                    "status" => 400,
                    "result" => "no ticket exist !"
                ];
            }
            echo(json_encode($result));
            return(json_encode($result));
        }

        public function create():string{
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            
            $errors = [];

            $json_to_array = (array)$data;
            
            if(isset($json_to_array['title']) === false || $data->title === ""){
                $errors[] = "title cannot be null";
            }
            if(isset($json_to_array['service']) === false || $data->service === ""){
                $errors[] = "service cannot be null";
            }
            if(isset($json_to_array['description']) === false || $data->description === null || $data->description === ""){
                $errors[] = "description cannot be null";
            }

            if(count($errors) === 0){
                $ticketModel = new TicketModel();
                $ticket = $ticketModel->create($data->service, $data->title, $data->description);

                if ($ticket){
                    $result = [
                        "status" => 200,
                        "result" => "ticket created !"
                    ];
                }
            } else {
             
                $result = [
                    "status" => 400,
                    "result" => "problem occured!",
                    "details" => $errors
                ];

            }

            echo(json_encode($result));
            return(json_encode($result));
        }

        public function createFile(int $ticket_file){
            $ticketModel = new TicketModel();
            $ticket = $ticketModel->findComments($ticket_file);

            $ticket_text = "Ticket id #{$ticket[0]['id']}\rService : {$ticket[0]['service']}\rTitle : {$ticket[0]['title']}\rDescription : {$ticket[0]['description']}\rCreated at : {$ticket[0]['createdAt']}\rState : {$ticket[0]['state']}\r\rAll comments \r\r";

            $file_name = __DIR__."/../trame.txt";

            if(!file_exists($file_name)){
                touch($file_name);
            }

            $my_file = fopen($file_name, "w");
            fwrite($my_file, $ticket_text);

            foreach ($ticket[1] as $comment) {
                $comment = "comment#{$comment["id"]}\rcontent : {$comment["content"]}\rdate : {$comment["date"]}\r\r";
                fwrite($my_file, $comment);
            }

            fclose($my_file);

            $result = [
                "status" => 200,
                "result" => "now go get your trame !"
            ];

            echo(json_encode($result));
        }

    }

?>