<?php
     //Development connection or local database
     //define('DB_HOST', 'localhost');
     //define('DB_USER', 'root');
     //define('DB_PASSWORD', '');
     //define('DB_NAME', 'taxiclubdatabase');

    define('DB_HOST', 'remotemysql.com');
    define('DB_USER', 'CO5BFd6rax');
    define('DB_PASSWORD', 'LOw7yW8kV7');
    define('DB_NAME', 'CO5BFd6rax');

    define('USER_CREATED', 101);
    define('USER_EXISTS', 102);
    define('USER_FAILURE', 103);

    define('DRIVER_CREATED', 101);
    define('DRIVER_EXISTS', 102);
    define('DRIVER_FAILURE', 103);

    define('TRIP_CREATED', 101);
    define('TRIP_EXISTS', 102);
    define('TRIP_FAILURE', 103);

    define('ASSIGNMENT_CREATED', 101);
    define('ASSIGNMENT_EXISTS', 102);
    define('ASSIGNMENT_FAILURE', 103);

    define('USER_AUTHENTICATED', 201);
    define('USER_NOT_FOUND', 202);
    define('USER_PASSWORD_DO_NOT_MATCH', 203);

    define('PASSWORD_CHANGED', 301);
    define('PASSWORD_DO_NOT_MATCH', 302);
    define('PASSWORD_NOT_CHANGED', 303);