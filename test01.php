<?php

$str = "le Lapìn CLAUDE SOULIE fait Il pleüt";

$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ',  'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï',  'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï',  'ñ',  'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă',  'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď',  'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'ģ', 'Ĥ', 'ĥ',  'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ',  'Ĵ', 'ĵ', 'Ĺ', 'ĺ',  'Ń', 'ń', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ',  'œ', 'Ŕ', 'ŕ',  'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ',  'Š', 'š', 'Ť',  'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű',  'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ');
$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I',  'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a',   'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D',  'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'g', 'H', 'h',  'I', 'i', 'I', 'i', 'I',  'J', 'j', 'L', 'l',  'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r','R', 'r',  'S', 's', 'S', 's',  'S', 's', 'T',  'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u',  'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u');

$str = str_replace($a, $b, $str);
echo $str;

echo count($a).'<br />';

$fina = array();
$finb = array();

foreach ($a as $i => $c) {
    
    if ( !in_array($c, $fina) )
        
        $fina[] = $c;
        $finb[] = $b[$i];
}

echo implode('', $fina).'<br />';
echo implode('', $finb).'<br />';
echo count($fina);

// for ($i=0 ; $i<count($a) ; $i++) {
    
//     $c = ordutf8($a[$i]);
//     echo $c.' - '.ord($b[$i]).'<br />';
// }




function ordutf8($string) {
    
    $code = ord($string);
    if ($code >= 128) {        //otherwise 0xxxxxxx
        if ($code < 224) $bytesnumber = 2;                //110xxxxx
        else if ($code < 240) $bytesnumber = 3;        //1110xxxx
        else if ($code < 248) $bytesnumber = 4;    //11110xxx
        $codetemp = $code - 192 - ($bytesnumber > 2 ? 32 : 0) - ($bytesnumber > 3 ? 16 : 0);
        for ($i = 2; $i <= $bytesnumber; $i++) {
            $code2 = ord($string) - 128;        //10xxxxxx
            $codetemp = $codetemp*64 + $code2;
        }
        $code = $codetemp;
    }
    return $code;
}

/*
$f = '<br />';
echo __DIR__.$f;
echo dirname(__FILE__).$f;

echo preg_replace('/\//', '/\\/', __DIR__).$f;
echo str_replace('\\', '/', __DIR__);

$Config = array('XXX', 'YYY', 'ZZZ');
 echo "	s.c_art = ?
				 	and (s.date_fac between ? and ?)
				 	and c.c_tarif1 in ('" .implode("','", $Config) ."') "
				 			."group by s.c_art, c.c_tarif1
				 	order by s.c_art, c.c_tarif1";
				 	
*/

?>