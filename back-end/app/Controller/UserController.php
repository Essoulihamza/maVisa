<?php 
class UserController extends Controller {
    use JWT;
    private $userModel;
    private $tokenModel;
    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->tokenModel = $this->model('Token');
    }
    public function processRequest(string $method, ?int $id = 0) : void 
    {
        if( $id )
            $this->processResourceRequest($method, $id);
        else
            $this->processCollectionRequest($method);
    }
    private function processResourceRequest(string $method, string $id) : void
    {
        $user = $this->userModel->get($id);

        if( ! $user ){
            http_response_code(404);
            echo json_encode(['message' => "User not found"]);
            return;
        }
        switch($method) {
            case 'GET':
                echo json_encode($user);
                break;
            case 'PATCH':
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $errors = ErrorHandler::getValidationErrors($data, false);
                if( ! empty($errors) ) {
                    http_response_code(422);
                    echo json_encode(['errors' => $errors]);
                    break; 
                }
                $rows = $this->userModel->update($user ,$data);
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
                $rows = $this->userModel->delete($id);
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
                print_r(json_encode($this->userModel->getAll()));
                break;
            case 'POST':
                $data = json_decode( file_get_contents("php://input"), true);
                $errors = ErrorHandler::getValidationErrors($data);
                if( ! empty($errors) ) {
                    http_response_code(422);
                    echo json_encode(['errors' => $errors]);
                    break; 
                }
                $id = $this->userModel->create($data);
                $user = $this->userModel->get($id);
                $payload = [
                    'User' => $user
                ];
                $jwt = $this->generate($payload);
                $this->tokenModel->insert($jwt, $id);
                http_response_code(201);
                echo json_encode([
                    'message' => "User created successfully",
                    'userData' => $user,
                    'token' => $jwt
                ]);
                break;
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }
    
}
