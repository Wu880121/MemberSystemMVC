<?php

require_once __DIR__ . '/../../vendor/autoload.php'; // 確保能使用 composer 套件
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private static $secretKey;
    private static $algo;

    public static function init() {
        self::$secretKey = getenv('SUPER_SECRET_KEY');
        self::$algo = getenv('JWT_ALGO');
    }


    // 產生 Token
    public static function encode(array $payload, $expireInSeconds = 3600)
    {
		
		        // 確保 init() 已執行
        if (!self::$secretKey || !self::$algo) {
            self::init();
        }
		
        $issuedAt = time();
        $expireAt = $issuedAt + $expireInSeconds;

        $payload['iat'] = $issuedAt;
        $payload['exp'] = $expireAt;

        return JWT::encode($payload, self::$secretKey, self::$algo);
    }

         // 驗證 Token
        public static function decode($token)
         {
              if (!self::$secretKey || !self::$algo) {
              self::init();
          }

          return JWT::decode($token, new Key(self::$secretKey, self::$algo));
         }
}
