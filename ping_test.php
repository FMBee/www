<?php

// Soumettre le ping (0 = machine joignable)  
exec("ping -n 2 51.255.39.154", $output, $return);	//cde Windows ! -c sous Linux

print_r($return);
print_r($output);

/** SI la machine n'est pas joignable **/
if ($return != 0) {
    echo date('H:i')," injoignable";
}
else {
    echo date('H:i')," joignable";
}