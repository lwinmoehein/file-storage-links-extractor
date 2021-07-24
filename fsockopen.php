<?php
# fsockopen.php

// In HTTP, lines have to be terminated with "\r\n" because of
// backward compatibility reasons
$request = "GET / HTTP/1.1\r\n";
$request .= "Host: www.google.com\r\n";
$request .= "\r\n"; // We need to add a last new line after the last header

// We open a connection to www.example.com on the port 80 
$connection = fsockopen('www.google.com', 80);

// The information stream can flow, and we can write and read from it
fwrite($connection, $request);

// As long as the server returns something to us...
while(!feof($connection)) {
    // ... print what the server sent us
    echo fgets($connection);
}

// Finally, close the connection
fclose($connection);
