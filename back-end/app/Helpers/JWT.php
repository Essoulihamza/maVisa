<?php 
trait JWT {

    /** 
     * Headers for JWT
     * 
     * @var array 
     */
    private $headers = [
        'alg' => 'HS256',
        'typ' => 'JWT'
    ];

    /**
     * Secret for JWT
     * 
     * @var string
     */
    private $secret = 'margaret';

    public function generate(array $payload) : string {
        $headers = $this->encode(json_encode($this->headers));
        $payload['exp'] = time() + 60 * 60 * 24 * 15;
        $payload = $this->encode(json_encode($payload));
        $signature = hash_hmac('SHA256', "$headers.$payload", $this->secret ,true);
        $signature = $this->encode($signature);
        return "$headers.$payload.$signature";
    }

    private function encode(string $str) : string {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }

    public function is_valid(string $jwt) : bool {
        $token = explode('.', $jwt);
        if(!isset($token[1]) && !isset($token[2])) return false;
        $headers = base64_decode($token[0]);
        $payload = base64_decode($token[1]);
        $clientSignature = $token[2];
        if(!json_decode($payload)) return false;
        if( ( ( json_decode($payload)->exp ) - time() ) < 0 ) return false;
        
        $base64_header = $this->encode($headers);
        $base64_payload = $this->encode($payload);

        $signature = hash_hmac('SHA256', "$base64_header.$base64_payload", $this->secret, true);

        $base64_signature = $this->encode($signature);

        return ($base64_signature == $clientSignature);
    }
}