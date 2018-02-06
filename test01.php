<?php

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