<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


require '../vendor/autoload.php';

require '../DatabaseConnection/DbFunctions.php';
$app = new \Slim\App([
    'settings' =>[
        'displayErrorDetails'=>true
    ]
]);


/*
     POST
     endpoint = create driver
     Arguments = Name, Surname, UserType, Email, Cell, Username, Password 
*/
$app->post('/createdriver', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('Name', 'Surname', 'Gender', 'Email', 'Cell', 'DriverType'), $request,$response)){
        $request_data = $request->getParsedBody();
        $Name = $request_data['Name'];
        $Surname = $request_data['Surname'];   
        $Gender = $request_data['Gender'];
        $Email = $request_data['Email'];
        $Cell = $request_data['Cell'];
        $Usertype = "Driver-Type";
        $DriverType = $request_data['DriverType'];
        $UserCreateDate = date("m/d/Y");
        $AccountActive = "true";
        $Password = "NULL";
        $HashedPassword = password_hash($Password, PASSWORD_DEFAULT);
        $db = new DbFunctions;
        $result = $db->createDriver($Name, $Surname, $Gender ,$Email, $Cell, $Usertype, 
        $DriverType, $UserCreateDate,$AccountActive,$HashedPassword);
        if($result == DRIVER_CREATED){              
           $message = array();
           $message['error'] = false;
           $message['message'] = 'Driver created successfully';        
           $response->write(json_encode($message));
           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(201);
        }else if($result == DRIVER_FAILURE){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'NOOO Some error happened';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);

        }else if ($result == DRIVER_EXISTS){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'Email already exsit';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);
        }

    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
});

$app->post('/createpassenger', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('Name', 'Surname','Gender', 'BirthDate', 'Email', 'Cell', 'HomeAddress', 'PickUpLocation', 'DropOffLocation', 'Password'), $request,$response)){
        $request_data = $request->getParsedBody();
        $Name = $request_data['Name'];
        $Surname = $request_data['Surname'];
        $Gender = $request_data['Gender'];
        $BirthDate= $request_data['BirthDate'];
        $Email = $request_data['Email'];
        $Cell = $request_data['Cell'];
        $HomeAddress = $request_data['HomeAddress'];
        $UserCreateDate = date("m/d/Y");
        $Usertype = "Passenger";
        $AccountActive = "true";
        $PickUpLocation = $request_data['PickUpLocation'];
        $DropOffLocation = $request_data['DropOffLocation'];
        $Password = $request_data['Password'];
        $TripID = NULL;
        $Assigned = 0;
        $HashedPassword = password_hash($Password, PASSWORD_DEFAULT);
        $db = new DbFunctions;
        $result = $db->createPassenger($Name, $Surname, $Gender, $BirthDate, $Email, $Cell, $HomeAddress, $UserCreateDate, $Usertype, $AccountActive, $PickUpLocation, $DropOffLocation, $HashedPassword, $TripID, $Assigned);

        if($result == USER_CREATED){        
           $message = array();
           $message['error'] = false;
           $message['message'] = 'User created successfully';        
           $response->write(json_encode($message));
           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(201);
        }else if($result == USER_FAILURE){
           $message = array();
           $message['error'] = true;
           $message['message'] = 'NOOO Some error happened';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);

        }else if ($result == USER_EXISTS){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'Surname already exsit bro';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);
        }

    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
});


$app->post('/mobilecreatepassenger', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('Name', 'Surname', 'BirthDate','Gender', 'HomeAddress', 'Email', 'Cell','Password', 'City'), $request,$response)){
        $request_data = $request->getParsedBody();
        $Name = $request_data['Name'];
        $Surname = $request_data['Surname'];
        $Gender = $request_data['Gender'];
        $BirthDate = $request_data['BirthDate'];
        $HomeAddress = $request_data['HomeAddress'];
        $Email = $request_data['Email'];
        $Cell = $request_data['Cell'];
        $UserCreateDate = date("m/d/Y");
        $Usertype = "Passenger";
        $AccountActive = "true";
        $PickUpLocation = NULL;
        $DropOffLocation = NULL;
        $Password = $request_data['Password'];
        $TripID = NULL;
        $Assigned = 0;
        $City = $request_data['City'];
        $HashedPassword = password_hash($Password, PASSWORD_DEFAULT);
        $db = new DbFunctions;
        $result = $db->MobilecreatePassenger($Name, $Surname, $Gender, $BirthDate, $Email, $Cell, $HomeAddress, $UserCreateDate, $Usertype, $AccountActive, $PickUpLocation, $DropOffLocation, $HashedPassword, $TripID, $Assigned, $City);

        if($result == USER_CREATED){        
           $message = array();
           $message['error'] = false;
           $message['message'] = 'Registration Successfull';        
           $response->write(json_encode($message));
           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(201);
        }else if($result == USER_FAILURE){
           $message = array();
           $message['error'] = true;
           $message['message'] = 'NOOO Some error happened';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);

        }else if ($result == USER_EXISTS){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'Email already exsit';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);
        }

    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
});

$app->post('/createvehicle', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('Name' , 'Description', 'Type', 'Capacity', 'StateDescription', 'Registration'), $request,$response)){
        $request_data = $request->getParsedBody();
        $Name = $request_data['Name'];
        $Description = $request_data['Description'];
        $Type = $request_data['Type'];
        $Capacity = $request_data['Capacity'];

        $State ="Working";
        $StateDescription = $request_data['StateDescription'];
        $DateAdded = date("m/d/Y");
        $Registration = $request_data['Registration'];
        $db = new DbFunctions;
        $result = $db->createVehicle($Name , $Description, $Type, $Capacity, $State, $StateDescription, $DateAdded, $Registration);

        if($result == USER_CREATED){        
           $message = array();
           $message['error'] = false;
           $message['message'] = 'User created successfully';        
           $response->write(json_encode($message));
           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(201);
        }else if($result == USER_FAILURE){
           $message = array();
           $message['error'] = true;
           $message['message'] = 'NOOO Some error happened';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);

        }else if ($result == USER_EXISTS){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'Surname already exsit bro';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);
        }

    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
});



/*
     POST
     endpoint = createtrip
     Arguments = Name, Surname, UserType, Email, Cell, Username, Password 
*/


/*
     POST
     endpoint =  Assign Driver to a trip
     Arguments = DriverID and TripID
*/
$app->post('/createTripTest', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('Bill', 'ArrivalTime', 'DepartureTime'), $request,$response)){
        $request_data = $request->getParsedBody();
        $Bill = $request_data['Bill'];
        $ArrivalTime = $request_data['ArrivalTime'];
        $DepartureTime = $request_data['DepartureTime'];
        
        $db = new DbFunctions ;
        $result = $db->createTripTest($Bill,$ArrivalTime, $DepartureTime);

        if($result == USER_CREATED){        
           $message = array();
           $message['error'] = false;
           $message['message'] = 'User created successfully';        
           $response->write(json_encode($message));
           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(201);
        }else if($result == USER_FAILURE){
           $message = array();
           $message['error'] = true;
           $message['message'] = 'NOOO Some error happened';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);

        }else if ($result == USER_EXISTS){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'Surname already exsit bro';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);
        }

    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
});
$app->post('/createtrip', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('PickUpArea', 'DropOffArea', 'ArrivalTime', 'DepartureTime'), $request,$response)){
        $request_data = $request->getParsedBody();
        $PickUpArea = $request_data['PickUpArea'];
        $DropOffArea = $request_data['DropOffArea'];
      
        
        $ArrivalTime = $request_data['ArrivalTime'];
        $DepartureTime = $request_data['DepartureTime'];
        
        $db = new DbFunctions ;
        $result = $db->createTrip($PickUpArea, $DropOffArea, $ArrivalTime, $DepartureTime);

        if($result == USER_CREATED){        
           $message = array();
           $message['error'] = false;
           $message['message'] = 'User created successfully';        
           $response->write(json_encode($message));
           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(201);
        }else if($result == USER_FAILURE){
           $message = array();
           $message['error'] = true;
           $message['message'] = 'NOOO Some error happened';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);

        }else if ($result == USER_EXISTS){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'Surname already exsit bro';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);
        }

    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
});


$app->post('/createnotification', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('Message', 'PassengerID', 'CreateDate', 'ForWhat'), $request,$response)){
        $request_data = $request->getParsedBody();
        $Message = $request_data['Message'];
        $PassengerID = $request_data['PassengerID'];   
        $CreateDate = $request_data['CreateDate'];
        $ForWhat = $request_data['ForWhat'];

        $db = new DbFunctions ;
        $result = $db->createNotification($Message, $CreateDate, $PassengerID, $ForWhat);

        if($result == USER_CREATED){        
           $message = array();
           $message['error'] = false;
           $message['message'] = 'User created successfully';        
           $response->write(json_encode($message));
           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(201);
        }else if($result == USER_FAILURE){
           $message = array();
           $message['error'] = true;
           $message['message'] = 'NOOO Some error happened';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);

        }else if ($result == USER_EXISTS){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'Surname already exsit bro';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);
        }

    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
});



$app->post('/createpickuparea', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('PickUpArea', 'TimeArrival', 'TimeDepature'), $request,$response)){
        $request_data = $request->getParsedBody();

        $PickUpArea = $request_data['PickUpArea'];
        $TimeArrival = $request_data['TimeArrival'];
        $TimeDepature = $request_data['TimeDepature'];
        $db = new DbFunctions ;

        $result = $db->createPickUpArea($PickUpArea, $TimeArrival, $TimeDepature);

        if($result == USER_CREATED){
                
           $message = array();
           $message['error'] = false;
           $message['message'] = 'User created successfully';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(201);
        }else if($result == USER_FAILURE){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'NOOO Some error happened';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);

        }else if ($result == USER_EXISTS){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'Surname already exsit bro';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);
        }

    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
});


$app->post('/createrequest', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('PassengerID' ,'PickUpLocation', 
    'DropOffLocation', 'PickUpTime', 'DropOffTime', 'SchoolName', 'SchoolAddress',
     'SchoolCell', 'GroupType', 'NumberPassenger', 'TripDate'), $request,$response)){
        $request_data = $request->getParsedBody();

       
        $PassengerID = $request_data['PassengerID'];
        $RequestStatus = "pending";
     
        $PickUpLocation = $request_data['PickUpLocation'];
        $DropOffLocation= $request_data['DropOffLocation'];
        $PickUpTime = $request_data['PickUpTime'];
        $DropOffTime = $request_data['DropOffTime'];
        $SchoolName = $request_data['SchoolName'];
        $SchoolAddress= $request_data['SchoolAddress'];
        $SchoolCell = $request_data['SchoolCell'];
        $GroupType = $request_data['GroupType'];
        $NumberPassenger = $request_data['NumberPassenger'];
        $TripDate = $request_data['TripDate'];
        $db = new DbFunctions ;

        $result = $db->createRequest($PassengerID, $RequestStatus, $PickUpLocation, 
        $DropOffLocation, $PickUpTime, $DropOffTime, $SchoolName, $SchoolAddress,
        $SchoolCell, $GroupType, $NumberPassenger, $TripDate);

        if($result == USER_CREATED){
                
           $message = array();
           $message['error'] = false;
           $message['message'] = 'Request Sent';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(201);
        }else if($result == USER_FAILURE){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'NOOO Some error happened';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);

        }else if ($result == USER_EXISTS){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'Surname already exsit bro';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);
        }

    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
});


$app->post('/createdropoffarea', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('DropOffArea', 'TimeArrival', 'TimeDepature'), $request,$response)){
        $request_data = $request->getParsedBody();
        $DropOffArea = $request_data['DropOffArea'];
        $TimeArrival = $request_data['TimeArrival'];
        $TimeDepature = $request_data['TimeDepature'];
        $db = new DbFunctions ;

        $result = $db->createDropOffArea($DropOffArea, $TimeArrival, $TimeDepature);

        if($result == USER_CREATED){
                
           $message = array();
           $message['error'] = false;
           $message['message'] = 'User created successfully';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(201);
        }else if($result == USER_FAILURE){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'NOOO Some error happened';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);

        }else if ($result == USER_EXISTS){

           $message = array();
           $message['error'] = true;
           $message['message'] = 'Surname already exsit bro';
           
           $response->write(json_encode($message));

           return $response
                       ->withHeader('Content-type', 'application/json')
                       ->withStatus(422);
        }

    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
});


$app->post('/createuser', function(Request $request, Response $response){
     if(!haveEmptyParameters(array('Name', 'Surname', 'UserType', 'Email', 'Cell', 'Username', 'Password'), $request,$response)){
         $request_data = $request->getParsedBody();

         $Name = $request_data['Name'];
         $Surname = $request_data['Surname'];
         $UserType = $request_data['UserType'];
         $Email = $request_data['Email'];
         $Cell = $request_data['Cell'];
         $Username = $request_data['Username'];
         $Password = $request_data['Password'];


        $HashedPassword = password_hash($Password, PASSWORD_DEFAULT);

         $db = new DbFunctions ;

         $result = $db->createUser($Name, $Surname, $UserType, $Email, $Cell, $Username, $HashedPassword);

         if($result == USER_CREATED){
                 
            $message = array();
            $message['error'] = false;
            $message['message'] = 'User created successfully';
            
            $response->write(json_encode($message));

            return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(201);
         }else if($result == USER_FAILURE){

            $message = array();
            $message['error'] = true;
            $message['message'] = 'NOOO Some error happened';
            
            $response->write(json_encode($message));

            return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(422);

         }else if ($result == USER_EXISTS){

            $message = array();
            $message['error'] = true;
            $message['message'] = 'Surname already exsit bro';
            
            $response->write(json_encode($message));

            return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(422);
         }

     }
     return $response
     ->withHeader('Content-type', 'application/json')
     ->withStatus(422);
});



$app->post('/driverlogin', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('Email', 'Password'), $request, $response)){
        $request_data = $request->getParsedBody();

        $Email = $request_data['Email'];
        $Password = $request_data['Password'];

        $db = new DbFunctions;

        $result = $db->Driverlogin2($Email,$Password);

        if($result == USER_AUTHENTICATED){
           $user = $db->getDriverByEmail($Email);
           $response_data = array();

           $response_data['error']=false;
           $response_data['message']='Loging Successful';
           $response_data['driver']=$user;

           $response->write(json_encode($response_data));

           return $response
           ->withHeader('Content-type', 'application/json')
           ->withStatus(200);

        }else if($result == USER_NOT_FOUND){
                        $user = $db->getDriverByEmail($Email);
            $response_data = array();

            $response_data['error']=true;
            $response_data['message']='User doesnt exist';
         
            $response->write(json_encode($response_data));
 
            return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
        }else if($result == USER_PASSWORD_DO_NOT_MATCH){
                        $user = $db->getDriverByEmail($Email);
            $response_data = array();

            $response_data['error']=true;
            $response_data['message']='Password does not match';
      
 
            $response->write(json_encode($response_data));
 
            return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
        }
    }
   
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
 });

 $app->post('/mobilepassengerlogin', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('Email', 'Password'), $request, $response)){
        $request_data = $request->getParsedBody();

        $Email = $request_data['Email'];
        $Password = $request_data['Password'];

        $db = new DbFunctions;

        $result = $db->Passengerlogin2($Email,$Password);

        if($result == USER_AUTHENTICATED){
           $user = $db->getPassengerByEmail($Email);
           $response_data = array();

           $response_data['error']=false;
           $response_data['message']='Loging Successful';
           $response_data['passenger']=$user;

           $response->write(json_encode($response_data));

           return $response
           ->withHeader('Content-type', 'application/json')
           ->withStatus(200);

        }else if($result == USER_NOT_FOUND){
                        $user = $db->getDriverByEmail($Email);
            $response_data = array();

            $response_data['error']=true;
            $response_data['message']='User doesnt exist';
         
            $response->write(json_encode($response_data));
 
            return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
        }else if($result == USER_PASSWORD_DO_NOT_MATCH){
                        $user = $db->getDriverByEmail($Email);
            $response_data = array();

            $response_data['error']=true;
            $response_data['message']='Password does not match';
      
 
            $response->write(json_encode($response_data));
 
            return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
        }
    }
   
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
 });

$app->post('/userlogin', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('Email', 'Password'), $request, $response)){
        $request_data = $request->getParsedBody();
        $Email = $request_data['Email'];
        $Password = $request_data['Password'];

        $db = new DbFunctions;

        $result = $db->userlogin($Email,$Password);

        if($result == USER_AUTHENTICATED){
           $user = $db->getUserByEmail($Email);
           $response_data = array();

           $response_data['error']=false;
           $response_data['message']='Loging Successful';
           $response_data['user']=$user;

           $response->write(json_encode($response_data));

           return $response
           ->withHeader('Content-type', 'application/json')
           ->withStatus(200);

        }else if($result == USER_NOT_FOUND){
            $response_data = array();

            $response_data['error']=true;
            $response_data['message']='User doesnt exist';
 
            $response->write(json_encode($response_data));
 
            return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(404);
        }else if($result == USER_PASSWORD_DO_NOT_MATCH){
            $response_data = array();

            $response_data['error']=true;
            $response_data['message']='Password does not match';
            $response_data['user']=$user;
 
            $response->write(json_encode($response_data));
 
            return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
        }
    }
   
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
 });


 $app->get('/allworkingvehicles', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->getAllWorkingVehicles();

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});


 $app->get('/allusers', function(Request $request, Response $response){
         $db = new DbFunctions;
         $users = $db->getAllUsers();

         $response_data = array();

         $response_data['error'] = false;
         $response_data['users'] = $users;

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
 });

 $app->get('/alldrivers', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->getAllDrivers();

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get('/allactivedrivers', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->getAllActiveDrivers();

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});


$app->get('/allassigneddrivers', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->getAllDriversCurrentlyAssigned();

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get('/alldriversNames', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->getAllDriversNames();

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});



$app->get('/allpickup', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->getAllPickAreas();

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});


$app->get('/allrequests', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->getAllRequests();

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get('/alldropoff', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->getAllDropOffArea();

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get('/alltrips', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->getAllTrips();

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});


$app->get('/alltrippassengers/{id}', function(Request $request, Response $response){
    $id = $args['id'];
    $db = new DbFunctions;
    $users = $db->getTripPassengers($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});



$app->get('/alltripsassignedtodriver/{id}', function(Request $request, Response $response){
    $id = $args['id'];
    $db = new DbFunctions;
    $users = $db->getAllTripsAssignedToDriver($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get('/allpassengers', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->getAllPassengersList();

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get('/mobileallpassengers', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->MobilegetAllPassengersList();

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get('/allpassengerssimple', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->getAllPassengers();

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get('/allUnasignedpassengers', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->getAllUnassigedPassengers();

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($users));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});


 

function haveEmptyParameters($required_params, $request,$response){
    $error = false;
    $error_params = '';
    $request_params = $request->getParsedBody();

    foreach($required_params as $param){
        if(!isset($request_params[$param]) || strlen($request_params[$param])<=0){
            $error = true;
            $error_params .= $param . ', ';
        }
    }

    if($error){
        $error_detail = array();
        $error_detail['error'] = true;
        $error_detail['message'] = 'Required parameters ' .  substr($error_params, 0, -2) . ' are missing or empty ';
        $response->write(json_encode($error_detail));  
    }
  return $error;
}

$app->get('/driver/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getDriverById($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});


$app->get('/webdrivertrips/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $trips = $db->getDriverTrips($id);

    $response_data = array();

    $response_data['kode'] = 1;
    $response_data['error'] = "trips";
    $response_data['trips'] = $trips;

    $response->write(json_encode($trips));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});


$app->get('/alldrivertrips/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getDriverTrips($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/gettrippassengers/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getTripPassengersByTripId($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/drivervehicle/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getDriverVehicleById($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});



$app->get('/mobiledrivervehicle/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->MobilegetDriverVehicleById($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/webdriverpassengers/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getDriverPassengersById($id);

    $response_data = array();

    $response_data['kode'] = 1;
    $response_data['error'] = "false";
    $response_data['users'] = $user;

    $response->write(json_encode($response_data));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/weballusers', function(Request $request, Response $response){
    $db = new DbFunctions;
    $users = $db->WebgetAllTrips();

    $response_data = array();

    $response_data['kode'] = 1;
    $response_data['error'] = "false";
    $response_data['users'] = $users;

    $response->write(json_encode($response_data));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});



$app->get('/driverpassengers/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getDriverPassengersById($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['users'] = $user;

    $response->write(json_encode($response_data));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});


$app->get('/gettripdriver/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getTripDriver($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/getpassengertrip/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getPassengerTrip($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/getmobilepassengerrequest/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getPassengerRequestById2($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/mobilegetpassengertrip/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->MobilegetPassengerTripById($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});






$app->get('/tripdriver/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getShowTripDriver($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));
    

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/pickup/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getPickUpAreaById($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/dropoff/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getDropOffAreaById($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});


$app->get('/passengerprofile/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getPassengerById($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});


$app->get('/passenger/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getPassengerById($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});


$app->get('/passengerrequest/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getPassengerRequestById($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/passengewithtrip/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getPassengerTripById($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/tripwithnodriver/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getTripByIdForTripWithNoDriver($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});


$app->get('/trip/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getTripById($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/driverpick/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getDriverByEmail($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});


$app->get('/passengertrip/{id}', function(Request $request, Response $response,  array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $user = $db->getPassengerTripById($id);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});


$app->get('/dropoffbyname/{dropoffarea}', function(Request $request, Response $response,  array $args){
    $dropoffarea = $args['dropoffarea'];
    $db = new DbFunctions;
    $user = $db->getDropOffAreaByName($dropoffarea);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/pickupbyname/{pickuparea}', function(Request $request, Response $response,  array $args){
    $pickuparea = $args['pickuparea'];
    $db = new DbFunctions;
    $user = $db->getPickUpAreaByName($pickuparea);

    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/driverbyname/{name}', function(Request $request, Response $response,  array $args){
    $name = $args['name'];
    $db = new DbFunctions;
    $user = $db->getDriverByName($name);
    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/ty/{name}/{surname}', function(Request $request, Response $response,  array $args){
    $name = $args['name'];
    $surname = $args['surname'];
    $db = new DbFunctions;
    $user = $db->getDriverByNameAndSurname($name, $surname);
    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});

$app->get('/tripsbyareas/{pickuparea}', function(Request $request, Response $response,  array $args){
    $pickuparea = $args['pickuparea'];
    $dropoffarea = "";
    $db = new DbFunctions;
    $user = $db->getTripByAreas($pickuparea);
    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});


$app->get('/tripsbyareas2/{dropoffarea}', function(Request $request, Response $response,  array $args){
    $dropoffarea = $args['dropoffarea'];
    $db = new DbFunctions;
    $user = $db->getTripByAreas2($dropoffarea);
    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});



$app->get('/tripbyname/{pickuparea}', function(Request $request, Response $response,  array $args){
    $PickUpArea = $args['pickuparea'];
    $db = new DbFunctions;
    $user = $db->getDriverByName($PickUpArea);
    $response_data = array();

    $response_data['error'] = false;
    $response_data['user'] = $user;

    $response->write(json_encode($user));

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200); 
});









$app->put('/updateuser/{id}', function(Request $request, Response $response, array $args){
       $id = $args['id'];

       if(!haveEmptyParameters(array('Name', 'Surname', 'Email', 'Cell', 'id'), $request,$response)){
          
         $request_data = $request->getParsedBody();
         $Name = $request_data['Name'];
         $Surname = $request_data['Surname'];
         $Email = $request_data['Email'];
         $Cell = $request_data['Cell'];
         $id = $request_data['id']; 

         $db = new DbFunctions;

         if($db->updateUser($Name, $Surname, $Email, $Cell, $id)){
             $response_data = array();
             $response_data['error'] = false;
             $response_data['message'] = 'User Upadted Succesfully';
             $user = $db->getUserByEmail($Email);
             $response_data['user'] = $user;

             $response->write(json_encode($response_data));

             return $response
             ->withHeader('Content-type', 'application/json')
             ->withStatus(200);
         }else{
            $response_data = array();
            $response_data['error'] = true;
            $response_data['message'] = 'PLS TRY LATER';
            $user = $db->getUserByEmail($Email);
            $response_data['user'] = $user;

            $response->write(json_encode($response_data));

            return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
         }
       }
       return $response
       ->withHeader('Content-type', 'application/json')
       ->withStatus(200);
});

$app->put('/mobileupdatepassengercontacts/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('Email', 'Cell', 'HomeAddress'), $request,$response)){
       
      $request_data = $request->getParsedBody();
      $Email = $request_data['Email'];
      $Cell = $request_data['Cell'];
      $HomeAddress = $request_data['HomeAddress'];
     
      $db = new DbFunctions;

      if($db->MobileUpdatePassengerContacts($id, $Email, $Cell, $HomeAddress)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          $user = $db->getUserByEmail($Email);
          $response_data['user'] = $user;

          $response->write(json_encode($response_data));

          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';
         $user = $db->getUserByEmail($Email);
         $response_data['user'] = $user;

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->put('/mobileupdatepassengerlocations/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('PickUpLocation', 'DropOffLocation'), $request,$response)){
       
      $request_data = $request->getParsedBody();
      $PickUpLocation = $request_data['PickUpLocation'];
      $DropOffLocation = $request_data['DropOffLocation'];
     
      $db = new DbFunctions;
      if($db->updatePassengerLocations($PickUpLocation, $DropOffLocation, $id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          
        

          $response->write(json_encode($response_data));

          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';
        
         $response_data['user'] = $user;

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});


$app->put('/asigntriptopassenger/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('id, PickUpArea, DropOffArea'), $request,$response)){     
      $request_data = $request->getParsedBody();
      $id = $request_data['id'];
      $PickUpArea = $request_data['PickUpArea'];
      $DropOffArea = $request_data['DropOffArea'];
      $db = new DbFunctions;
      if($db->updateAssignTripToPassenger($id, $PickUpArea, $DropOffArea)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          $response->write(json_encode($response_data));
          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->put('/mobilesubcribepassenger/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];
  

    if(!haveEmptyParameters(array('TripID'), $request,$response)){     
      $request_data = $request->getParsedBody();
      $TripID = $request_data['TripID'];
      $Assigned = 1;
      $db = new DbFunctions;
      if($db->MobileupdateSubscribePassenger($TripID,$id, $Assigned)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          $response->write(json_encode($response_data));
          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->put('/Accept/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];
  

    if(!haveEmptyParameters(array('DriverName', 'VehicleName'), $request,$response)){     
      $request_data = $request->getParsedBody();
      $DriverName = $request_data['DriverName'];
      $VehicleName = $request_data['VehicleName'];
      $Assigned = 1;
      $db = new DbFunctions;
      if($db->AcceptTrip($VehicleName, $DriverName,$id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'Request Upadted Succesfully';
          $response->write(json_encode($response_data));
          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->put('/decline/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];    
      $request_data = $request->getParsedBody();
      $db = new DbFunctions;
      if($db->DeclineTrip($id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'Request Upadted Succesfully';
          $response->write(json_encode($response_data));
          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->put('/assigndrivertotrip/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('Name'), $request,$response)){     
      $request_data = $request->getParsedBody();
      $Name = $request_data['Name'];
      $db = new DbFunctions;
      if($db->updateAssignDriverToPassenger($id, $Name)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'Trip Upadted Succesfully';
          $response->write(json_encode($response_data));
          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});


$app->put('/assignvehicletodriver/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('Registration'), $request,$response)){     
      $request_data = $request->getParsedBody();
      $Name = $request_data['Registration'];
      $db = new DbFunctions;
      if($db->updateAssignVehicleToDriver($id, $Name)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'Trip Upadted Succesfully';
          $response->write(json_encode($response_data));
          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->put('/Unassigndrivertotrip/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

   
      $request_data = $request->getParsedBody();
      $db = new DbFunctions;
      if($db->updateUnassignDriverToPassenger($id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'Trip Upadted Succesfully';
          $response->write(json_encode($response_data));
          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});


$app->put('/unassignvehicletodriver/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

   
      $request_data = $request->getParsedBody();
      $db = new DbFunctions;
      if($db->updateUnassignVehicleToDriver($id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'Driver Upadted Succesfully';
          $response->write(json_encode($response_data));
          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->put('/unasigntriptopassenger/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

       
      $request_data = $request->getParsedBody();
      
      $db = new DbFunctions;
      if($db->updateUnassignTripToPassenger($id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          $response->write(json_encode($response_data));
          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
   

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});




$app->put('/updatedriver/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('Name', 'Surname','Gender', 'Email', 'Cell', 'id', 'Usertype','DriverType',
    'UserCreateDate','AccountActive'), $request,$response)){
       
      $request_data = $request->getParsedBody();
      $Name = $request_data['Name'];
      $Surname = $request_data['Surname'];
      $Gender = $request_data['Gender'];
      $Email = $request_data['Email'];
      $Cell = $request_data['Cell'];
      $id = $request_data['id'];
      $Usertype = $request_data['Usertype']; 
      $DriverType = $request_data['DriverType'];
      $UserCreateDate = $request_data['UserCreateDate'];
      $AccountActive = $request_data['AccountActive'];

      $db = new DbFunctions;
      if($db->updateDriver($Name, $Surname,$Gender, $Email, $Cell, $Usertype, $DriverType, $UserCreateDate, $AccountActive, $id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          $user = $db->getDriverByEmail($Email);
          $response_data['user'] = $user;

          $response->write(json_encode($response_data));

          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';
         $user = $db->getDriverByEmail($Email);
         $response_data['user'] = $user;

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->put('/updateassignpassengertotrip/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('PickUpArea', 'DropOffArea'), $request,$response)){
       
      $request_data = $request->getParsedBody();
      $PickUpArea = $request_data['PickUpArea'];
      $DropOffArea = $request_data['DropOffArea'];
      $Assigned = 1;

      $db = new DbFunctions;
      if($db->updateAssignTripToPassenger($PickUpArea, $DropOffArea, $id, $Assigned)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          $response->write(json_encode($response_data));
          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';
         $response->write(json_encode($response_data));
         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->put('/updatepassenger/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('Name', 'Surname','Gender', 'Email', 'Cell', 'id'), $request,$response)){
       
      $request_data = $request->getParsedBody();
      $Name = $request_data['Name'];
      $Surname = $request_data['Surname'];
      $Gender = $request_data['Gender'];
      $BirthDate = $request_data['BirthDate'];
      $Email = $request_data['Email'];
      $Cell = $request_data['Cell'];
      $HomeAddress = $request_data['HomeAddress'];
      $PickUpLocation = $request_data['PickUpLocation'];
      $DropOffLocation = $request_data['DropOffLocation'];

      $db = new DbFunctions;
      if($db->updatePassenger($Name, $Surname,$Gender, $BirthDate, $Email, $Cell, $HomeAddress, $PickUpLocation, $DropOffLocation, $id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          $response->write(json_encode($response_data));
          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';
         $response->write(json_encode($response_data));
         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});



$app->put('/deactivatedriver/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('id','AccountActive'), $request,$response)){
       
      $request_data = $request->getParsedBody();
      $AccountActive = "false";
      $id = $id;
      $db = new DbFunctions;
      if($db->DeactivateDriverAccount($AccountActive, $id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          $response->write(json_encode($response_data));

          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';
         $user = $db->getDriverByEmail($Email);
         $response_data['user'] = $user;

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});


$app->put('/deactivatepassenger/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('id','AccountActive'), $request,$response)){
       
      $request_data = $request->getParsedBody();
      $AccountActive = "false";
      $id = $id;
      $db = new DbFunctions;
      if($db->DeactivatePassengerAccount($AccountActive, $id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          $response->write(json_encode($response_data));

          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';
         $user = $db->getDriverByEmail($Email);
         $response_data['user'] = $user;

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});
$app->put('/activatedriveraccount/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('id','AccountActive'), $request,$response)){
       
      $request_data = $request->getParsedBody();
      $AccountActive = "true";
      $id = $id;
      $db = new DbFunctions;
      if($db->ActivateDriverAccount($AccountActive, $id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          $response->write(json_encode($response_data));

          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';
         $user = $db->getDriverByEmail($Email);
         $response_data['user'] = $user;

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->put('/unassignpassengertotrip/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('id','AccountActive'), $request,$response)){
       
      $request_data = $request->getParsedBody();
      $TripID =null;
      $id = $id;
      $db = new DbFunctions;
      if($db-> UnassignTripToPassenger($TripID, $id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          $response->write(json_encode($response_data));

          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';
         $user = $db->getDriverByEmail($Email);
         $response_data['user'] = $user;

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->put('/unassigndrivertotrip/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('id','AccountActive'), $request,$response)){
       
      $request_data = $request->getParsedBody();
      $TripID =null;
      $id = $id;
      $db = new DbFunctions;
      if($db-> UnassignDriverToTrip($TripID, $id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          $response->write(json_encode($response_data));

          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';
         $user = $db->getDriverByEmail($Email);
         $response_data['user'] = $user;

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});



$app->put('/activatepassengeraccount/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    if(!haveEmptyParameters(array('id','AccountActive'), $request,$response)){
       
      $request_data = $request->getParsedBody();
      $AccountActive = "true";
      $id = $id;
      $db = new DbFunctions;
      if($db->ActivatePassengerAccount($AccountActive, $id)){
          $response_data = array();
          $response_data['error'] = false;
          $response_data['message'] = 'User Upadted Succesfully';
          $response->write(json_encode($response_data));

          return $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus(200);
      }else{
         $response_data = array();
         $response_data['error'] = true;
         $response_data['message'] = 'PLS TRY LATER';
         $user = $db->getDriverByEmail($Email);
         $response_data['user'] = $user;

         $response->write(json_encode($response_data));

         return $response
         ->withHeader('Content-type', 'application/json')
         ->withStatus(200);
      }
    }

    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});


$app->delete('/deleteuser/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    $db = new DbFunctions;

    $response_data = array();
    if($db->deleteUser($id)){
        $response_data['error'] = false;
        $response_data['message'] = 'user deleted successefully';
    }else{
        $response_data['error'] = true;
        $response_data['message'] = 'try later bro';
    }
       
       $response->write(json_encode($response_data));

       return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->delete('/deletepassenger/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $response_data = array();
    if($db->deletePassenger($id)){
        $response_data['error'] = false;
        $response_data['message'] = 'user deleted successefully';
    }else{
        $response_data['error'] = true;
        $response_data['message'] = 'try later bro';
    }
       
       $response->write(json_encode($response_data));

       return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->delete('/deletepickuparea/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $response_data = array();
    if($db->deletePickUpArea($id)){
        $response_data['error'] = false;
        $response_data['message'] = 'pickup deleted successefully';
    }else{
        $response_data['error'] = true;
        $response_data['message'] = 'try later bro';
    }
       
       $response->write(json_encode($response_data));

       return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->delete('/deletedropoffarea/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $response_data = array();
    if($db->deleteDropOffArea($id)){
        $response_data['error'] = false;
        $response_data['message'] = 'drop deleted successefully';
    }else{
        $response_data['error'] = true;
        $response_data['message'] = 'try later bro';
    }
       
       $response->write(json_encode($response_data));

       return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->delete('/deletetrip/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];
    $db = new DbFunctions;
    $response_data = array();
    if($db->deleteTrip($id)){
        $response_data['error'] = false;
        $response_data['message'] = 'user deleted successefully';
    }else{
        $response_data['error'] = true;
        $response_data['message'] = 'try later bro';
    }      
       $response->write(json_encode($response_data));
       return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});




$app->delete('/deletedriver/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];

    $db = new DbFunctions;

    $response_data = array();
    if($db->deletedriver($id)){
        $response_data['error'] = false;
        $response_data['message'] = 'user deleted successefully';
    }else{
        $response_data['error'] = true;
        $response_data['message'] = 'try later bro';
    }
       
       $response->write(json_encode($response_data));

       return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->put('/updatepassword', function(Request $request, Response $response) {
        if(!haveEmptyParameters(array('currentpassword', 'newpassword', 'Email'), $request, $response)){
            $request_data = $request->getParsedBody();
            $currentpassword = $request_data['currentpassword'];
            $newpassword = $request_data['newpassword']; 
            $Email = $request_data['Email']; 
            $db = new DbFunctions;
             
            $result = $db->updatePassword($currentpassword, $newpassword, $Email);

            if($result == PASSWORD_CHANGED){
                $response_data = array();
                $response_data['error']=false;
                $response_data['message']= 'Password Changed';
                $response->write(Json_encode($response_data));
                return $response->withHeader('Content-type', 'application/json')
                ->withStatus(200);

            }else if($result == PASSWORD_DO_NOT_MATCH){
                $response_data = array();
                $response_data['error']=true;
                $response_data['message']= 'Passwords dont match bro';
                $response->write(Json_encode($response_data));
                return $response->withHeader('Content-type', 'application/json')
                ->withStatus(200);
            }else if($result == PASSWORD_NOT_CHANGED){
                $response_data = array();
                $response_data['error']=true;
                $response_data['message']= 'some error occured';
                $response->write(Json_encode($response_data));
                return $response->withHeader('Content-type', 'application/json')
                ->withStatus(200);
            }
        }
        return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);
});

$app->run();