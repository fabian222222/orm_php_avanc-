<?php

    namespace App\Model;

    use Framework\Model;
    use \PDO;

    class TicketModel extends Model{

        public function all(){
            $db = $this->getDb();
            $stmt = $db->prepare('SELECT * FROM `ticket`');
            $stmt->execute();
            $tickets =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ($tickets);
        }

        public function findById($ticket_id){
            $db = $this->getDb();
            $stmt = $db->prepare('SELECT * FROM `ticket` WHERE id = :ticket_id');
            $stmt->execute([
                "ticket_id" => $ticket_id
            ]);
            $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($ticket);
        }

        public function create($service, $title, $description){

            $init_createdAt = date("Y/m/d H:i:s");
            $init_state = "En cours";

            $db = $this->getDb();
            $stmt = $db->prepare('INSERT INTO `ticket`(`service`, `title`, `description`, `createdAt`, `state`) VALUES (:service,:title,:description,:createdAt,:state)');
            $stmt->execute([
                "service" => $service,
                "title" => $title,
                "description" => $description,
                "createdAt" => $init_createdAt,
                "state" => $init_state
            ]);

            return true;
        }

        public function findComments($ticket_id){
            $db = $this->getDb();
            $stmt = $db->prepare('SELECT * FROM `ticket` WHERE id = :ticket_id');
            $stmt->execute([
                "ticket_id" => $ticket_id
            ]);
            $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

            if($ticket){
                $stmt = $db->prepare('SELECT * FROM `ticket_has_comment` WHERE ticket_id = :ticket_id');
                $stmt->execute([
                    "ticket_id" => $ticket_id
                ]);
                $comments_id = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            $result = [];

            foreach ($comments_id as $comment) {
                $stmt = $db->prepare('SELECT * FROM `comment` WHERE id = :comment_id');
                $stmt->execute([
                    "comment_id" => $comment["comment_id"]
                ]);
                $comment = $stmt->fetch(PDO::FETCH_ASSOC);
                array_push($result, $comment);
            }

            $data = [
                $ticket,
                $result
            ];
            return $data;
        }

    }

?>