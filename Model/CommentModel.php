<?php

    namespace App\Model;

    use Framework\Model;
    use \PDO;

    class CommentModel extends Model{

        public function all(){
            $db = $this->getDb();
            $stmt = $db->prepare('SELECT * FROM `comment`');
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $comments;
        }

        public function findById($ticket_id){

            $response = [];

            $db = $this->getDb();
            $stmt = $db->prepare('SELECT * FROM `ticket_has_comment` WHERE ticket_id = :ticket_id');
            $stmt->execute([
                "ticket_id" => $ticket_id
            ]);
            $all_comments_id = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($all_comments_id as $comment_id) {
                $stmt = $db->prepare('SELECT * FROM `comment` WHERE id = :comment_id');
                $stmt->execute([
                    "comment_id" => $comment_id["comment_id"]
                ]);
                $comments = $stmt->fetch(PDO::FETCH_ASSOC);
                array_push( $response , $comments);
            }
            return $response;
        }

        public function create($content, $ticket_id){

            $init_createdAt = date("Y/m/d H:i:s");

            $db = $this->getDb();
            $stmt = $db->prepare('SELECT * FROM `ticket` WHERE id = :ticket_id');
            $stmt->execute([
                "ticket_id" => $ticket_id
            ]);
            $current_ticket = $stmt->fetch(PDO::FETCH_ASSOC);

            if($current_ticket){

                $stmt = $db->prepare('INSERT INTO `comment`(`content`, `date`) VALUES (:content,:date)');
                $stmt->execute([
                    "content" => $content,
                    "date" => $init_createdAt
                ]);
    
                $stmt = $db->prepare('SELECT * FROM `comment` WHERE date = :created_at');
                $stmt->execute([
                    "created_at" => $init_createdAt
                ]);
    
                $current_comment = $stmt->fetch(PDO::FETCH_ASSOC);
    
                $stmt = $db->prepare('INSERT INTO `ticket_has_comment`(`comment_id`, `ticket_id`) VALUES (:comment_id, :ticket_id)');
                $stmt->execute([
                    "comment_id" => $current_comment["id"],
                    "ticket_id" => $ticket_id
                ]);
                return [
                    $current_ticket,
                    $current_comment
                ];
            } else {

                return false;

            }
        }

    }

?>