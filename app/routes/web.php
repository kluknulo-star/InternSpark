<?php
//require_once APP_ROOT_DIRECTORY . "/app/routes/webCourse.php";
$webRoutes = [
    /** @see \app\Users\Controller\UsersController::index() */
    '' => 'app/Users/Controller/UsersController@index',
    'users' => 'app/Users/Controller/UsersController@index',

    /** @see \app\Users\Controller\SessionController::error() */
    'error' => 'app/Users/Controller/SessionController@error',

    /** @see \app\Users\Controller\UsersController::profile() */
    'profile' => 'app/Users/Controller/UsersController@profile',

    /** @see \app\Users\Controller\UsersController::view() */
    'users/(\d+)/view' => 'app/Users/Controller/UsersController@view',
    'users/(\d+)' => 'app/Users/Controller/UsersController@view',

    /** @see \app\Users\Controller\UsersController::create() */
    'users/create' => 'app/Users/Controller/UsersController@create',
    'create' => 'app/Users/Controller/UsersController@create',

    /** @see \app\Users\Controller\UsersController::edit() */
    'users/(\d+)/edit' => 'app/Users/Controller/UsersController@edit',

    /** @see \app\Users\Controller\UsersController::delete() */
    'users/(\d+)/delete' => 'app/Users/Controller/UsersController@delete',

    /** @see \app\Users\Controller\UsersController::restore() */
    'users/(\d+)/restore' => 'app/Users/Controller/UsersController@restore',

    /** @see \app\Users\Controller\SessionController::login() */
    'login' => 'app/Users/Controller/SessionController@login',

    /** @see \app\Users\Controller\SessionController::logout() */
    'logout' => 'app/Users/Controller/SessionController@logout',

    /** @see \app\Users\Controller\SessionController::register() */
    'register' => 'app/Users/Controller/SessionController@register',

    /** @see \app\Courses\Controller\CourseController::index() */
    'courses' => 'app/Courses/Controller/CourseController@index',


];
