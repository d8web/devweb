<?php

namespace core\helpers;
use Exception;

class Functions {

    /**
     * @param array $structures
     * @param array|null $data
     * @return void 
    */
    public static function Render(array $structures, $data = null): void {
        // Verificar se a estrutura é um array, neste caso se não for retornamos um erro!
        if(!is_array($structures)) {
            throw new Exception("Erro na estrutura de views");
        }

        // Variáveis
        if(!empty($data) && is_array($data)) {
            extract($data); // https://www.w3schools.com/php/func_array_extract.asp
        }

        // Apresentar as views
        foreach($structures as $structure) {
            include("../core/views/site/$structure.php");
        }
    }

    /**
     * @param array $structures
     * @param array|null $data
     * @return void 
    */
    public static function RenderAdmin(array $structures, $data = null): void {
        // Verificar se a estrutura é um array, neste caso se não for retornamos um erro!
        if(!is_array($structures)) {
            throw new Exception("Erro na estrutura de views");
        }

        // Variáveis
        if(!empty($data) && is_array($data)) {
            extract($data); // https://www.w3schools.com/php/func_array_extract.asp
        }

        // Apresentar as views
        foreach($structures as $structure) {
            include("../../core/views/admin/$structure.php");
        }
    }

    /**
     * @param string $route
     * @param bool $admin
     * @return void 
    */
    public static function Redirect(string $route = "", bool $admin = false): void {
        // Redirecionar para a rota desejada
        if(!$admin) {
            header("Location: " . BASE_URL . "$route");
            exit;
        } else {
            header("Location: " . BASE_URL . "admin/$route");
        }
    }

    /**
     * @return bool 
    */
    public static function LoggedAdmin(): bool {
        return isset($_SESSION["token"]);
    }

    /**
     * @param array $file
     * @param int $w
     * @param int $h
     * @param string $folder 
     * @return string
    */
    public static function cutImage(array $file, int $w, int $h, string $folder): string {
        list($widthOrig, $heightOrig) = getimagesize($file["tmp_name"]);
        $ratio = $widthOrig / $heightOrig;

        $newWidth = $w;
        $newHeight = $newWidth / $ratio;

        if($newHeight < $h) {
            $newHeight = $h;
            $newWidth = $newHeight * $ratio;
        }

        $x = $w - $newWidth;
        $y = $h - $newHeight;
        $x = $x < 0 ? $x / 2 : $x;
        $y = $y < 0 ? $y / 2 : $y;

        $finalImage = imagecreatetruecolor($w, $h);
        switch($file["type"]) {
            case "image/jpeg":
            case "image/jpg":
                $image = imagecreatefromjpeg($file["tmp_name"]);
            break;
            case "image/png":
                $image = imagecreatefrompng($file["tmp_name"]);
            break;
        }
   
        imagealphablending( $finalImage, false );
        imagesavealpha( $finalImage, true );

        imagecopyresampled(
            $finalImage, $image,
            $x, $y, 0, 0,
            $newWidth, $newHeight, $widthOrig, $heightOrig
        );

        $fileName = md5(time().rand(0,9999)).".png";

        imagepng($finalImage, $folder."/".$fileName);

        return $fileName;
    }

    /**
     * @param int $loggedAdmin 
    */
    public static function verifyPermission(int $loggedAdmin) {

        if(key_exists($loggedAdmin, PERMISSIONS)) {
            return PERMISSIONS[$loggedAdmin];
        }

        return PERMISSIONS[0];

    }

    /**
     * @param string $urlString 
    */
    public static function createSlug($string) {
        $string = preg_replace('/[\t\n]/', ' ', $string);
        $string = preg_replace('/\s{2,}/', ' ', $string);
        $list = [
            'Š' => 'S',
            'š' => 's',
            'Đ' => 'Dj',
            'đ' => 'dj',
            'Ž' => 'Z',
            'ž' => 'z',
            'Č' => 'C',
            'č' => 'c',
            'Ć' => 'C',
            'ć' => 'c',
            'À' => 'A',
            'Á' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Ä' => 'A',
            'Å' => 'A',
            'Æ' => 'A',
            'Ç' => 'C',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ñ' => 'N',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'O',
            'Ø' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',
            'Þ' => 'B',
            'ß' => 'Ss',
            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',
            'æ' => 'a',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ð' => 'o',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ø' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ý' => 'y',
            'ý' => 'y',
            'þ' => 'b',
            'ÿ' => 'y',
            'Ŕ' => 'R',
            'ŕ' => 'r',
            '/' => '-',
            ' ' => '-',
            '.' => '-',
            ',' => '',
            ':' => '',
            '|' => ''
        ];
    
        $string = strtr($string, $list);
        $string = preg_replace('/-{2,}/', '-', $string);
        $string = strtolower($string);
    
        return $string;
    }

    /**
     * @param string $value
     * @return string 
    */
    public static function aesEncrypt(string $value) {
        return bin2hex(openssl_encrypt($value, "aes-256-cbc", AES_KEY, OPENSSL_RAW_DATA, AES_IV));
    }

    /**
     * @param string $value
     * @return string
    */
    public static function aesDescrypt(string $value) {
        return openssl_decrypt(hex2bin($value), "aes-256-cbc", AES_KEY, OPENSSL_RAW_DATA, AES_IV);
    }

}