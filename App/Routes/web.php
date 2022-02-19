<?php

$start->router->run('/', 'PageController@home');
$start->router->run('/addproduct', 'PageController@addproduct');
$start->router->run('/deneme', function(){
    echo "Deneme sayfa";
});