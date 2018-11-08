<?php

if(class_exists('wlJSOEncryptor')) {
    return;
}

/**
 * WiseLoop JavaScript Obfuscator Encryptor class definition<br/>
 *
 * @author WiseLoop
 */
class wlJSOEncryptor
{
    /**
     * Encrypts the given JavaScript code.
     * @note
     * - Encryption enlarges payload sizes. The larger encryption level is set, the higher protection is achieved and the larger processed obfuscated code will result.
     * - The browser needs valid JavaScript code to run, and the encrypted code is a valid JavaScript also.
     * This is the reason that the encryption is made using a public key and a JavaScript boot loader function in order the be able to self-decrypt when the browser runs the encrypted code.
     * There is no other way to make the encryption safer.
     * If the browser manages to decrypt the encrypted code, also an ambitious thief can try this by using its own intelligence or some specialized tools.<br/>
     * In conclusion, the encryption feature does not ensure bulletproof protection due to the public nature of JavaScript code.<br/>
     * Keep in mind that all the world's obfuscation techniques are meant to discourage the code thief and cannot guarantee a full bulletproof protection
     * against theft due to the public and open architecture of JavaScript and web browser combination.
     * @param string $js the input JavaScript source code
     * @param int $strength the encryption strength (0 means no encryption)
     * @return string the encrypted JavaScript code
     */
    public static function encrypt($js, $strength = 1) {
        if(strpos($js, 'function(w,i,s,e)') === false) {
            $jsBogus = "//\r\n";
            $jsBogus = self::encrypt1($jsBogus, 3);
            $jsReal = self::encrypt2($js, 1);
            for($level = 0; $level < $strength; $level ++) {
                $js = self::encrypt2($jsBogus . '; ' . $jsReal, 2);
            }
        }
        return $js;
    }

    /**
     * Encrypts (method 1) the given JavaScript code.
     * @param string $js the input JavaScript source code
     * @param int $strength the encryption strength (0 means no encryption)
     * @return string the encrypted JavaScript code
     */
    private static function encrypt1($js, $strength = 1) {
        $jsEncoder = __DIR__ . '/template/js-encrypt-b36plain.jst';
        if(file_exists($jsEncoder)) {
            $jsEncoder = file_get_contents($jsEncoder);
        }else {
            $jsEncoder = '';
        }
        if(!$jsEncoder) {
            return $js;
        }
        $jsEncoder = wlJSOMinifier::minifyJsCode($jsEncoder);

        $jss = '';
        for($level = 0; $level < $strength; $level++) {
            for($i = 0; $i < strlen($js); $i++) {
                $new = ord($js[$i]);
                $new = base_convert($new, 10, 36);
                if(strlen($new) == 1) {
                    $new = '0' . $new;
                }
                $jss .= $new;
            }
            $js = str_replace(
                array('{JS-W}', '{JS-I}', '{JS-S}', '{JS-E}'),
                array($jss, '', '', ''),
                $jsEncoder);
        }
        return $js;
    }

    /**
     * Encrypts (method 2) the given JavaScript code.
     * @param string $js the input JavaScript source code
     * @param int $strength the encryption strength (0 means no encryption)
     * @return string the encrypted JavaScript code
     */
    private static function encrypt2($js, $strength = 1) {
        $jsEncoder = __DIR__ . '/template/js-encrypt-b36arr.jst';
        if(file_exists($jsEncoder)) {
            $jsEncoder = file_get_contents($jsEncoder);
        }else {
            $jsEncoder = '';
        }
        if(!$jsEncoder) {
            return $js;
        }
        $jsEncoder = wlJSOMinifier::minifyJsCode($jsEncoder);

        for($level = 0; $level < $strength; $level++) {
            $key = substr(md5(date('s') . rand()), 0, 15);
            $keyLength = strlen($key);
            $jss = array('', '', '');

            $k = 0;
            for($i = 0; $i < $keyLength; $i++) {
                $jss[$k] .= $key[$i];
                $k++;
                if($k > 2) {
                    $k = 0;
                }
            }

            $j = 0;
            $k = 0;
            for($i = 0; $i < strlen($js); $i++) {
                $new = (ord($js[$i]) + (ord($key[$j]) % 2 ? 1 : -1));
                $new = base_convert($new, 10, 36);
                if(strlen($new) == 1) {
                    $new = '0' . $new;
                }
                for($l = 0; $l < 2; $l++) {
                    $jss[$k] .= $new[$l];
                    $k++;
                    if($k > 2) {
                        $k = 0;
                    }
                }

                $j++;
                if($j >= $keyLength) {
                    $j = 0;
                }
            }
            $js = str_replace(
                array('{JS-W}', '{JS-I}', '{JS-S}', '{JS-E}'),
                array($jss[0], $jss[1], $jss[2], md5(date('Y-m-d-s'))),
                $jsEncoder);
        }
        return $js;
    }
}
