<?php 

    namespace App\Controller;

    require_once(__DIR__.'/../Model/CommentModel.php');

    use Framework\Controller;
    use App\Model\CommentModel;

    class CommentController{

        public function findAll():string{
            $allComments = new CommentModel();
            $comments = $allComments->All();
            if($comments){
                $response = [
                    "status" => 200,
                    "result" => $comments
                ];
            } else {
                $response = [
                    "status" => 400,
                    "message" => "No comment !"
                ];
            }
            echo(json_encode($response));
            return json_encode($response);
        }

        public function findById(int $comment_id):string{
            $commentModel = new CommentModel();
            $comments = $commentModel->findById($comment_id);
            if($comments){
                $response = [
                    "status" => 200,
                    "result" => $comments
                ];
            } else {
                $response = [
                    "status" => 400,
                    "message" => "No comment for this ticket !"
                ];
            }
            echo(json_encode($response));
            return json_encode($response);
        }

        public function create(int $ticket_id):string{

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            $json_to_array = (array)$data;

            $errors = [];

            if(isset($json_to_array["content"]) === false || $data->content === ""){
                $errors[] = "content cannot be null";
            }

            if(count($errors) === 0){
                $commentModel = new CommentModel();
                $comment = $commentModel->create($data->content, $ticket_id);
                if($comment){
                    $response = [
                        "status" => 200,
                        "results" => $comment
                    ];
                }     
            }else{
                $response = [
                    "status" => 400,
                    "results" => "This ticket doesn't exist",
                    "details" => $errors
                ];
            }

            echo(json_encode($response));
            return json_encode($response);
        }

    }
?>