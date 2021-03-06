<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('edit_profile', 'UserInfoController');
Router::get('settings', 'UserInfoController');
Router::get('swipe', 'ProfilesController');
Router::get('giveLike', 'ProfilesController');
Router::get('chats','ChatsController');
Router::get('profile', 'UserInfoController');
Router::get('chat', 'ChatsController');
Router::get('select_gender', 'UserInfoController');
Router::get('select_location', 'UserInfoController');
Router::get('interested_in', 'UserInfoController');
Router::get('select_hobbies','DefaultController');
Router::post('login', 'SecurityController');
Router::post('sendMessage', 'ChatsController');
Router::post('sendMessageJS', 'ChatsController');
Router::post('register', 'SecurityController');
Router::post('uploadPhoto', 'UserInfoController');
Router::post('updateUserDetails', 'UserInfoController');
Router::post('updateUserLocation', 'UserInfoController');
Router::post('updateUserBio', 'UserInfoController');
Router::post('updateUserGender', 'UserInfoController');
Router::post('updateUserInterest', 'UserInfoController');
Router::get('logout', 'SecurityController');
Router::get('chatJS', 'ChatsController');

Router::run($path);