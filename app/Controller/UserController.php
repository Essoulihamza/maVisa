<?php 
class UserController extends Controller {
    private $userModel;
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }
    public function processRequest(string $method, ?int $id = 0) : void 
    {
        if($id) $this->processResourceRequest($method, $id);
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
                $errors = $this->getValidationErrors($data, false);
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
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $errors = $this->getValidationErrors($data);
                if( ! empty($errors) ) {
                    http_response_code(422);
                    echo json_encode(['errors' => $errors]);
                    break; 
                }
                $id = $this->userModel->create($data);
                http_response_code(201);
                echo json_encode([
                    'message' => "User created successfully",
                    'id' => $id
                ]);
                break;
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }
    private function getValidationErrors(array $data, bool $isNew = true) : array
    {
        $errors = [];
        $dataElements = array_keys($data);
        foreach ($dataElements as $element)
        {
            if( $isNew && empty($data[$element]))
                $errors[$element] = $element . " is required";
        }
        // $dataElements = ["last name", "first name", "birth date", "nationality", "family situation", "address", "visa type", "start date", "end date", "travel type"];
        // if (empty($data['last name']))
        //     $errors['last name'] = "last name is required";
        // if (empty($data['first name']))
        //     $errors['first name'] = "first name is required";
        // if (empty($data['birth date']))
        //     $errors['birth date'] = "birth date  is required";
        // if (empty($data['nationality']))
        //     $errors['nationality'] = "nationality  is required";
        // if (empty($data['family situation']))
        //     $errors['family situation'] = "family situation  is required";
        // if (empty($data['address']))
        //     $errors['address'] = "address  is required";
        // if (empty($data['visa type']))
        //     $errors['visa type'] = "visa type  is required";
        // if (empty($data['start date']))
        //     $errors['start date'] = "start date  is required";
        // if (empty($data['end date']))
        //     $errors['end date'] = "end date  is required";
        // if (empty($data['travel type']))
        //     $errors['travel type'] = "travel type  is required";
        return $errors;
    }

}
