<?php
$url='https://lordmorgoth.net/APIs/conjugation/conjugate?verb=tenir&mode=indicative&tense=perfect-tense';
// using file() function to get content
$lines_array=file($url);
// turn array into one variable
$lines_string=implode('',$lines_array);

$json = json_decode($lines_string);
//output, you can also save it locally on the server?>
<p><?php var_dump($json->conjugation); ?></p>