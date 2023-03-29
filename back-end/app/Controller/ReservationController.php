<?php 
class ReservationClass extends Controller {
    use JWT;
    private $reservationModel;
    private $tokenModel;
    public function __construct(){
        $this->reservationModel = $this->model('reservation');
    }
    public function processRequest(string $method, ?int $id = 0) : void 
    {
        if($id) $this->processResourceRequest($method, $id);
        else
            $this->processCollectionRequest($method);
    }
    private function processResourceRequest(string $method, string $id) : void
    {
        $reservation = $this->reservationModel->get($id);

        if( ! $reservation ){
            http_response_code(404);
            echo json_encode(['message' => "User not found"]);
            return;
        }
        switch($method) {
            case 'GET':
                echo json_encode($reservation);
                break;
            case 'PATCH':
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $errors = ErrorHandler::getValidationErrors($data, false);
                if( ! empty($errors) ) {
                    http_response_code(422);
                    echo json_encode(['errors' => $errors]);
                    break; 
                }
                $rows = $this->reservationModel->update($reservation ,$data);
                if($rows == 0) {
                    echo json_encode([
                        'message' => "No new update",
                        'rows' => $rows
                    ]);
                    break; 
                }
                echo json_encode([
                    'message' => "User $id updated",
                    'rows' => $rows
                ]);
                break;
            case 'DELETE':
                $rows = $this->reservationModel->delete($id);
                echo json_encode([
                    'message' => "User $id deleted",
                    'rows' => $rows
                ]);
                break;
            default:
                http_response_code(405);
                header("Allow: GET, PATCH, DELETE");
        }
        
    }

    private function processCollectionRequest(string $method) : void
    {
        switch($method) {
            case 'GET':
                print_r(json_encode($this->reservationModel->getAll()));
                break;
            case 'POST':
                $data = json_decode( file_get_contents("php://input"), true);
                $errors = ErrorHandler::getValidationErrors($data);
                if( ! empty($errors) ) {
                    http_response_code(422);
                    echo json_encode(['errors' => $errors]);
                    break; 
                }
                $id = $this->reservationModel->store($data);
                $payload = [
                    'user_id' => $id
                ];
                $jwt = $this->generate($payload);
                $this->tokenModel->insert($jwt, $id);
                http_response_code(201);
                echo json_encode([
                    'message' => "User created successfully",
                    'id' => $id,
                    'token' => $jwt
                ]);
                break;
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }
}