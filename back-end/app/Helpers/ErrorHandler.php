<?php
class ErrorHandler 
{
    public static function handleException(Throwable $exception) : void
    {
        http_response_code(500);
        
        echo json_encode(
            [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(), 
                'line' => $exception->getLine(),
            ]
        );
    }
    public static function handleError(
        int $errno,
        string $errstr,
        string $errfile,
        int $errline
    ) : bool
    {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
    public static function getValidationErrors(array $data, bool $isNew = true) : array
    {
        $errors = [];
        $dataElements = array_keys($data);
        if(count($dataElements) < 11 && $isNew) {
            $errors['data-errors'] = "all data are required";
            return $errors;
        }
        foreach ($dataElements as $element)
        {
            $data[$element] = Validation::dataValidation($data[$element]);
            if( $isNew &&  empty($data[$element]) )
                $errors[$element] = $element . " is required";
        }
        return $errors;
    }
}