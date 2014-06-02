<?php
$x = 'My '.'string';
$x = 'My '.1234;
$x = 'My '.$y.' test';

echo $data['my'.'index'];
echo $data['my'.4];
echo $data['my'.$x];
echo $data[$x.$y.'My'.'String'];

$code = '$actions = array();'."\n";
$code = "$actions = array();"."\n";

// No errors for these because they are needed in some cases.
$code = ' ?'.'>';
$code = '<'.'?php ';

// the next 2 tests show cases where the strings cannot be concatenated
// because the line length would exceed the limit if they were
$somestring = ".10 chars^.10 chars^.10 chars^.10 chars^.10 chars^" .
        ".10 chars^.10 chars^";

                        $someotherstring = "very small string" .
"but big space before" ;
?>
