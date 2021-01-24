<?php
$route[] =['/', 'HomeController@index'];
$route[] =['/bienes', 'BienesController@index'];
// $route[] =['/bienes/{id}/show', 'BienesController@show'];
$route[] =['/bienes/store', 'BienesController@store'];
$route[] =['/bienes/delete/{id}', 'BienesController@destroy'];
$route[] =['/data', 'HomeController@consume_data'];
return $route;