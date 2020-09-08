<?php

   class DbFunctions
   {
       private $con;
       function __construct()
       {
           require_once dirname(__FILE__) . '/DataConnect.php';
           $db = new DataConnect;
           $this->con = $db->connect();
       }

   
       public function createDriver($Name, $Surname, $Gender ,$Email, $Cell, $Usertype, 
       $DriverType, $UserCreateDate,$AccountActive,$Password)                                 
       {
         if(!$this->EmailCheckerExistDriver($Email))
         {
            $HasVehicle = "0";
            $stmt = $this->con->prepare("INSERT INTO driver (Name, Surname, Gender, Email, Cell, Usertype, DriverType, 
            UserCreateDate, AccountActive, Password, HasVehicle) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssisssssi", $Name, $Surname, $Gender, $Email, $Cell, $Usertype, $DriverType, 
                                         $UserCreateDate,$AccountActive,$Password, $HasVehicle);
            if($stmt->execute())
            {
               return DRIVER_CREATED;
            }   

            else
            {
               return DRIVER_FAILURE;
            }
         }
        return DRIVER_EXISTS;
       }

     
       public function getAllDrivers()
       {
         $stmt2 = $this->con->prepare("SELECT id, Name, Surname, Cell, Password,
         Email, DriverType, Gender FROM driver;");
         $stmt2->execute();
         $stmt2->bind_result($id, $Name, $Surname, $Cell, $Password,
         $Email, $DriverType,$Gender);
         $users = array();
         while($stmt2->fetch()){
         $user=array();
         $user['id']=$id;
         $user['Name']=$Name;
         $user['Surname']=$Surname;
         $user['Cell']=$Cell;
         $user['Email']=$Email;
         $user['DriverType']=$DriverType;
         $user['Gender']=$Gender;
         array_push($users, $user);
         }
          return $users;
       }

       public function getAllDriversNames()
       {
         $stmt2 = $this->con->prepare("SELECT id, Name, Surname FROM driver;");
         $stmt2->execute();
         $stmt2->bind_result($id, $Name, $Surname);
         $users = array();
         while($stmt2->fetch()){
         $user=array();
         $user['id']=$id;
         $user['Name']=$Name;
         $user['Surname']=$Surname;
         array_push($users, $user);
         }
          return $users;
       }

       public function getAllPassengers()
       {
         $stmt2 = $this->con->prepare("SELECT id, Name, Surname, Gender, BirthDate,Email,Cell,HomeAddress,UserCreateDate,Usertype,
         AccountActive,PickUpLocation,DropOffLocation,Password FROM passenger WHERE AccountActive='true';");
         $stmt2->execute();
         $stmt2->bind_result($id, $Name, $Surname, $Gender, $BirthDate,$Email,$Cell,$HomeAddress,$UserCreateDate,$Usertype,
         $AccountActive,$PickUpLocation,$DropOffLocation,$Password);
         $users = array();
         while($stmt2->fetch()){
         $user=array();
         $user['id']=$id;
         $user['Name']=$Name;
         $user['Surname']=$Surname;
         $user['Gender']=$Gender;
         $user['BirthDate']=$BirthDate;
         $user['Email']=$Email;
         $user['Cell']=$Cell;
         $user['HomeAddress']=$HomeAddress;
         $user['UserCreateDate']=$UserCreateDate;
         $user['AccountActive']=$AccountActive;
         $user['PickUpLocation']=$PickUpLocation;
         $user['DropOffLocation']=$DropOffLocation;
         $user['Usertype']=$Usertype;
         $user['Password']=$Password;
         array_push($users, $user);
         }
          return $users;
       }

       public function getAllTrips()
       {
         $stmt2 = $this->con->prepare("SELECT trip.id, trip.HasDriver, trip.Bill,trip.ArrivalTime, trip.DepartureTime, 
         pickuparea.PickUpArea, dropoffarea.DropOffArea FROM trip, pickuparea, 
         dropoffarea WHERE dropoffarea.id=DropOffAreaID AND pickuparea.id=PickUpAreaID ORDER BY trip.id;");
         $stmt2->execute();
         $stmt2->bind_result($id, $HasDriver, $Bill, $ArrivalTime, $DepartureTime, $PickUpArea,$DropOffArea);
         $users = array();
         while($stmt2->fetch()){
         $user=array();
         $user['id']=$id;
         $user['Bill']=$Bill;
         $user['HasDriver']=$HasDriver;
         $user['ArrivalTime']=$ArrivalTime;
         $user['DepartureTime']=$DepartureTime;
         $user['PickUpArea']=$PickUpArea;
         $user['DropOffArea']=$DropOffArea;
         array_push($users, $user);
         }
          return $users;
       }

       public function getAllPassengersList()
       {
         $stmt2 = $this->con->prepare("SELECT passenger.id, passenger.Name, passenger.Surname, passenger.Gender, passenger.BirthDate,passenger.Email,passenger.Cell,passenger.HomeAddress,passenger.UserCreateDate,passenger.Usertype,
         passenger.AccountActive,passenger.PickUpLocation,passenger.DropOffLocation,
         passenger.Password,passenger.TripID, trip.Bill,trip.ArrivalTime, trip.DepartureTime, 
         pickuparea.PickUpArea, dropoffarea.DropOffArea FROM passenger, trip, pickuparea, 
         dropoffarea WHERE trip.id=TripID 
         AND pickuparea.id=PickUpAreaID  AND 
         dropoffarea.id=DropOffAreaID ORDER BY passenger.id;");
         $stmt2->execute();
         $stmt2->bind_result($id, $Name, $Surname, $Gender, $BirthDate,$Email,$Cell,$HomeAddress,$UserCreateDate,$Usertype,
         $AccountActive,$PickUpLocation,$DropOffLocation,$Password,$TripID, $Bill, $PickUpArea, $DropOffArea, $ArrivalTime, $DepartureTime);
         $users = array();
         while($stmt2->fetch()){
         $user=array();
         $user['id']=$id;
         $user['Name']=$Name;
         $user['Surname']=$Surname;
         $user['Gender']=$Gender;
         $user['BirthDate']=$BirthDate;
         $user['Email']=$Email;
         $user['Cell']=$Cell;
         $user['HomeAddress']=$HomeAddress;
         $user['UserCreateDate']=$UserCreateDate;
         $user['AccountActive']=$AccountActive;
         $user['PickUpLocation']=$PickUpLocation;
         $user['DropOffLocation']=$DropOffLocation;
         $user['Usertype']=$Usertype;
         $user['Password']=$Password;
         $user['TripID']=$TripID;
         $user['Bill']=$Bill;
         $user['PickUpArea']=$PickUpArea;
         $user['DropOffArea']=$DropOffArea;
         $user['ArrivalTime']=$ArrivalTime;
         $user['DepartureTime']=$DepartureTime;
         array_push($users, $user);
         }
          return $users;
       }



       public function getAllPickUpArea()
       {
         $stmt2 = $this->con->prepare("SELECT id, PickUpArea,ArrivalTime, DepatureTime,
            DriverID FROM pickuparea;");
         $stmt2->execute();
         $stmt2->bind_result($id, $PickUpArea,$ArrivalTime, $DepatureTime,
         $DriverID);
         $users = array();
         while($stmt2->fetch()){
         $user=array();
         $user['id']=$id;
         $user['PickUpArea']=$PickUpArea;
         $user['ArrivalTime']=$ArrivalTime;
         $user['DepatureTime']=$DepatureTime;
         $user['DriverID']=$DriverID;
         array_push($users, $user);
         }
          return $users;
       }

       

       public function getAllDropOffArea()
       {
         $stmt2 = $this->con->prepare("SELECT id, DropOffArea,TimeArrival, TimeDepature,
            DriverID FROM dropoffarea;");
         $stmt2->execute();
         $stmt2->bind_result($id, $DropOffArea,$TimeArrival, $TimeDepature,
         $DriverID);
         $users = array();
         while($stmt2->fetch()){
         $user=array();
         $user['id']=$id;
         $user['DropOffArea']=$DropOffArea;
         $user['TimeArrival']=$TimeArrival;
         $user['TimeDepature']=$TimeDepature;
         $user['DriverID']=$DriverID;
         array_push($users, $user);
         }
          return $users;
       }

       public function AssignTripToDriver($DriverID, $TripID, $PassengerNumber)
       {
            $stmt = $this->con->prepare("INSERT INTO drivertrip (DriverID, TripID, PassengerNumber) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $DriverID, $TripID, $PassengerNumber);
            if($stmt->execute())
            {
               return ASSIGNMENT_CREATED;
            }   
            else
            {
               return ASSIGNMENT_FAILURE;
            }
       }

       public function createPickUpArea($PickUpArea, $TimeArrival, $TimeDepature)
       {
            $stmt = $this->con->prepare("INSERT INTO pickuparea (PickUpArea, TimeArrival, TimeDepature) VALUES (?, ?, ?)");
            $stmt->bind_param("sss",$PickUpArea, $TimeArrival, $TimeDepature);
            if($stmt->execute())
            {
               return USER_CREATED;
            }   
            else
            {
               return USER_FAILURE;
            }
         
        return USER_EXISTS;
       }


       public function createPassenger($Name , $Surname, $Gender, $BirthDate, $Email,
       $Cell, $HomeAddress, $UserCreateDate, $Usertype, $AccountActive, $PickUpLocation, $DropOffLocation, 
       $Password, $TripID, $Assigned)
       {
            $Assigned=0;
            $stmt = $this->con->prepare("INSERT INTO passenger (Name , Surname, Gender, BirthDate, Email,
            Cell, HomeAddress, UserCreateDate, Usertype, AccountActive, PickUpLocation, DropOffLocation, 
            Password, TripID, Assigned) VALUES (?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?, ?)");
            $stmt->bind_param("sssssssssssssii",$Name , $Surname, $Gender, $BirthDate, $Email,
            $Cell, $HomeAddress, $UserCreateDate, $Usertype, $AccountActive, $PickUpLocation, $DropOffLocation, 
            $Password, $TripID, $Assigned);
            if($stmt->execute())
            {
               return USER_CREATED;
            }   
            else
            {
               return USER_FAILURE;
            }
         
        return USER_EXISTS;
       }

       public function createVehicle($Name , $Description, $Type, $Capacity, $SeatsAv, $State, $StateDescription, $DateAdded, $Registration)
       {
     
            $stmt = $this->con->prepare("INSERT INTO vehicle (Name , Description, Type, Capacity, SeatsAv, State, StateDescription, DateAdded, Registration) VALUES (?, ?, ?, ?, ?,?,?,?,?)");
            $stmt->bind_param("sssiissss",$Name , $Description, $Type, $Capacity, $SeatsAv, $State, $StateDescription, $DateAdded, $Registration);
            if($stmt->execute())
            {
               return USER_CREATED;
            }   
            else
            {
               return USER_FAILURE;
            }
         
        return USER_EXISTS;
       }




       public function getPickUpAreaByName($PickUpArea)
       {
          $stmt = $this->con->prepare("SELECT PickUpArea, id  FROM pickuparea WHERE PickUpArea = ?");
          $stmt->bind_param("s", $PickUpArea);
          $stmt->execute();
          $stmt->bind_result($PickUpArea,$id);
          $stmt->fetch();
          $user=array();
          $user['PickUpArea']=$PickUpArea;
          $user['id']=$id;  
          return $id; 
       } 

       public function getDropOffAreaByName($DropOffArea)
       {
          $stmt = $this->con->prepare("SELECT DropOffArea, id  FROM dropoffarea WHERE DropOffArea = ?");
          $stmt->bind_param("s", $DropOffArea);
          $stmt->execute();
          $stmt->bind_result($DropOffArea,$id);
          $stmt->fetch();
          $user=array();
          $user['DropOffArea']=$DropOffArea;
          $user['id']=$id;  
          return $id; 
       } 

       public function getDriverByName($Name)
       {
          $stmt = $this->con->prepare("SELECT Name, id  FROM driver WHERE Name= ?");      
          $stmt->bind_param("s", $Name);
          $stmt->execute(); 
          $stmt->bind_result($Name, $id);    
          $stmt->fetch();
          $user=array();
          if($stmt->execute())
          {             
                return $id;       
          }                
       } 

       public function updateAssignDriverToPassenger($id, $Name)
       {  
          $DriverID = $this->getDriverByName($Name);
          $HasDriver = "true";
          $stmt = $this->con->prepare("UPDATE trip SET DriverID = ?, HasDriver = ? WHERE id = ?");
          $stmt->bind_param("isi", $DriverID, $HasDriver, $id);
          if($stmt->execute())
          return true;
          return false;
       }

       public function updateUnassignDriverToPassenger($id)
       {  
          $DriverID = NULL;
          $HasDriver = "false";
          $stmt = $this->con->prepare("UPDATE trip SET DriverID = ?, HasDriver = ? WHERE id = ?");
          $stmt->bind_param("isi", $DriverID, $HasDriver, $id);
          if($stmt->execute())
          return true;
          return false;
       }

       public function getTripByPickUpAreaId($PickUpAreaID, $DropOffAreaID)
       {
            $stmt = $this->con->prepare("SELECT id FROM trip WHERE PickUpAreaID = ? AND DropOffAreaID = ?" );
            $stmt->bind_param("ii", $PickUpAreaID, $DropOffAreaID);
            $stmt->execute();
            $stmt->bind_result($id);
            $stmt->fetch();
            $user=array();  
            return $id; 
        } 

        public function getTripPassengersByTripId($TripID)
        {
             $stmt = $this->con->prepare("SELECT id, Name FROM passenger WHERE TripID = ?" );
             $stmt->bind_param("i", $TripID);
             $stmt->execute();
             $stmt->bind_result($id, $Name);
             $users = array();
             while($stmt->fetch()){
             $user=array();
             $user['id']=$id;
             $user['Name']=$Name;
             array_push($users, $user);
             }
            return $users; 
         } 

         public function getDriverTrips($DriverID)
         {
              $stmt = $this->con->prepare("SELECT trip.id, pickuparea.PickUpArea, dropoffarea.DropOffArea, trip.ArrivalTime, trip.DepartureTime 
              FROM trip, pickuparea, dropoffarea WHERE DriverID = ? AND trip.PickUpAreaID=pickuparea.id AND trip.DropOffAreaID =dropoffarea.id" );
              $stmt->bind_param("i", $DriverID);
              $stmt->execute();
              $stmt->bind_result($id, $PickUpArea, $DropOffArea, $ArrivalTime,$DepartureTime);
              $users = array();
              while($stmt->fetch()){
              $user=array();
              $user['id']=$id;
              $user['PickUpArea']=$PickUpArea;
              $user['DropOffArea']=$DropOffArea;
              $user['ArrivalTime']=$ArrivalTime;
              $user['DepartureTime']=$DepartureTime;
              array_push($users, $user);
              }
             return $users; 
          } 

         public function getAllUnassigedPassengers()
         {
              $stmt = $this->con->prepare("SELECT id, Name, Surname, Email, Cell, UserCreateDate, Gender, HomeAddress, PickUpLocation, DropOffLocation FROM passenger WHERE Assigned = 'false';" );
              $stmt->execute();
              $stmt->bind_result($id, $Name,$Surname,$Email, $Cell, $UserCreateDate,$Gender,$HomeAddress, $PickUpLocation,$DropOffLocation);
              $users = array();
              while($stmt->fetch()){
              $user=array();
              $user['id']=$id;
              $user['Name']=$Name;
              $user['Surname']=$Surname;
              $user['Email']=$Email;
              $user['Cell']=$Cell;
              $user['UserCreateDate']=$UserCreateDate;
              $user['Gender']=$Gender;
              $user['HomeAddress']=$HomeAddress;
              $user['PickUpLocation']=$PickUpLocation;
              $user['DropOffLocation']=$DropOffLocation;
              array_push($users, $user);
              }
             return $users; 
          } 

      public function GetVehicleNumberSeatsAv($id){
         $stmt = $this->con->prepare("SELECT vehicle.id FROM driver, vehicle WHERE vehicle.id=VehicleID;" );
         $stmt->bind_param("ii", $PickUpAreaID, $DropOffAreaID);
         $stmt->execute();
         $stmt->bind_result($id);
         $stmt->fetch();
         $user=array();  
         return $id;            
      }

       public function updateAssignTripToPassenger($PickUpArea2, $DropOffArea2, $id, $Assigned2)
       {
          $PickUpAreaID = $this->getPickUpAreaByName($PickUpArea2);
          $DropOffAreaID = $this->getDropOffAreaByName($DropOffArea2);
          $TripID = $this->getTripByPickUpAreaId($PickUpAreaID, $DropOffAreaID);
          $Assigned =$Assigned2;
          $stmt = $this->con->prepare("UPDATE passenger SET TripID = ?, Assigned = ? WHERE id = ?");
          $stmt->bind_param("iii", $TripID, $Assigned, $id);
          if($stmt->execute())
          return true;
          return false;
       }

       public function updateUnassignTripToPassenger($id)
       {
          $TripID = null;
          $Assigned = 0;
          $stmt = $this->con->prepare("UPDATE passenger SET TripID = ?,Assigned = ?  WHERE id = ?");
          $stmt->bind_param("iii", $TripID,  $Assigned, $id);
          if($stmt->execute())
          return true;
          return false;
       }
    
       public function createTrip($PickUpArea2, $DropOffArea2, $Bill, $ArrivalTime, $DepartureTime)
       { 
            $PickUpAreaID = $this->getPickUpAreaByName($PickUpArea2);
            $DropOffAreaID = $this->getDropOffAreaByName($DropOffArea2);
            $HasDriver = "false";
            $stmt = $this->con->prepare("INSERT INTO trip (PickUpAreaID, DropOffAreaID, ArrivalTime, DepartureTime, HasDriver) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iisss",$PickUpAreaID, $DropOffAreaID, $ArrivalTime, $DepartureTime, $HasDriver);
            if($stmt->execute())
            {
               return USER_CREATED;
            }   
            else
            {
               return USER_FAILURE;
            }      
        return USER_EXISTS;
       }

       public function createTripTest($Bill, $ArrivalTime, $DepartureTime)
       { 
            $HasDriver = "false";
            $stmt = $this->con->prepare("INSERT INTO trip (Bill, ArrivalTime, DepartureTime, HasDriver) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss",$Bill, $ArrivalTime, $DepartureTime, $HasDriver);
            if($stmt->execute())
            {
               return USER_CREATED;
            }   
            else
            {
               return USER_FAILURE;
            }      
        return USER_EXISTS;
       }

       public function createDropOffArea($DropOffArea, $TimeArrival, $TimeDepature)
       {
     
            $stmt = $this->con->prepare("INSERT INTO dropoffarea (DropOffArea, TimeArrival, TimeDepature) VALUES (?, ?, ?)");
            $stmt->bind_param("sss",$DropOffArea, $TimeArrival, $TimeDepature);
            if($stmt->execute())
            {
               return USER_CREATED;
            }   
            else
            {
               return USER_FAILURE;
            }
         
        return USER_EXISTS;
       }

       public function DriverLogin($Email, $Password)
       {
          if($this->EmailCheckerExistDriver($Email)){
            // $hashed_password = $this->getUsersPasswordByEmail($Email);
             if(password_verify($Password, $Email)){
                return USER_AUTHENTICATED;
             }else{
                return USER_PASSWORD_DO_NOT_MATCH;
             }
          }else{
             return USER_NOT_FOUND;
          }
       }

       private function EmailCheckerExistDriver($Email)
       {
          $stmt = $this->con->prepare("SELECT id FROM driver WHERE Email = ?");
          $stmt->bind_param("s", $Email);
          $stmt->execute();
          $stmt->store_result();
          return $stmt->num_rows > 0;
       }

       public function userLogin($Email, $Password)
       {
          if($this->EmailCheckerExist($Email)){
             $hashed_password = $this->getUsersPasswordByEmail($Email);
             if(password_verify($Password, $hashed_password)){
                return USER_AUTHENTICATED;
             }else{
                return USER_PASSWORD_DO_NOT_MATCH;
             }
          }else{
             return USER_NOT_FOUND;
          }
       }

       public function createUser($Name, $Surname, $UserType, $Email, $Cell, $Username, $Password)
       {
         if(!$this->EmailCheckerExist($Email))
         {
            $stmt = $this->con->prepare("INSERT INTO singleuser (Name, Surname, UserType, Email, Cell, Username, Password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssiss", $Name, $Surname, $UserType,$Email, $Cell, $Username, $Password);
            if($stmt->execute())
            {
               return USER_CREATED;
            }   
            else
            {
               return USER_FAILURE;
            }
         }
        return USER_EXISTS;
       }

       public function getUsersPasswordByEmail($Email)
       {
          $stmt = $this->con->prepare("SELECT Password FROM singleuser WHERE Email = ?");
          $stmt->bind_param("s", $Email);
          $stmt->execute();
          $stmt->bind_result($Password);
          $stmt->fetch();
          return $Password;
       }  

       public function getAllUsers()
       {
         $stmt = $this->con->prepare("SELECT id, Name, Surname, UserType, Email FROM singleuser;");
         $stmt->execute();
         $stmt->bind_result($id, $Name, $Surname, $UserType, $Email);
         $users = array();
         while($stmt->fetch()){
         $user=array();
         $user['id']=$id;
         $user['Name']=$Name;
         $user['Surname']=$Surname;
         $user['UserType']=$UserType;
         $user['Email']=$Email;
         array_push($users, $user);
         }
          return $users;
       }


       public function getAllDriversCurrentlyAssigned()
       {
         $stmt = $this->con->prepare("SELECT id, DriverID FROM trip");
         $stmt->execute();
         $stmt->bind_result($id, $DriverID);
         $users = array();
         while($stmt->fetch()){
         $user=array();
         $user['id']=$id;
         $user['DriverID']=$DriverID;
         array_push($users, $user);
         }
          return $users;
       }

       public function getAllActiveDrivers()
       {
         $stmt = $this->con->prepare("SELECT id, Name, Surname, UserType, Email FROM driver WHERE AccountActive='true'");
         $stmt->execute();
         $stmt->bind_result($id, $Name, $Surname, $UserType, $Email);
         $users = array();
         while($stmt->fetch()){
         $user=array();
         $user['id']=$id;
         $user['Name']=$Name;
         $user['Surname']=$Surname;
         $user['UserType']=$UserType;
         $user['Email']=$Email;
         array_push($users, $user);
         }
          return $users;
       }


       public function getAllTripsAssignedToDriver($DriverID)
       {
         $stmt = $this->con->prepare("SELECT id  FROM trip WHERE DriverID=?");
         $stmt->execute();
         $stmt->bind_result($id);
         $users = array();
         while($stmt->fetch()){
         $user=array();
         $user['id']=$id;
         array_push($users, $user);
         }
          return $users;
       }

     public function getDriverById($id)
     {
          $stmt = $this->con->prepare("SELECT id, Name, Surname, Email, Cell, Gender, UserCreateDate, DriverType, AccountActive, HasVehicle FROM driver WHERE id = ?");
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $stmt->bind_result($id, $Name, $Surname,  $Email, $Cell, $Gender, $UserCreateDate, $DriverType, $AccountActive, $HasVehicle);
          $stmt->fetch();
          $user=array();
          $user['id']=$id;
          $user['Name']=$Name;
          $user['Surname']=$Surname;
          $user['Email']=$Email;
          $user['Cell']=$Cell;
          $user['Gender']=$Gender;
          $user['UserCreateDate']=$UserCreateDate;
          $user['DriverType']=$DriverType;
          $user['AccountActive']=$AccountActive;
          $user['HasVehicle']=$HasVehicle;
          return $user; 
      } 

      
  

       public function getTripDriver($id)
       {
          $stmt = $this->con->prepare("SELECT id, DriverID FROM trip WHERE id = ?");
          $stmt->bind_param("s", $id);
          $stmt->execute();
          $stmt->bind_result($id, $DriverID);
          $stmt->fetch();
          $user=array();
          return $DriverID; 
       } 

       public function getDriverVehicleById($id)
       {
          $stmt = $this->con->prepare("SELECT driver.id, driver.Name, driver.Surname, driver.Email, 
          driver.Cell, driver.Gender, driver.UserCreateDate, driver.DriverType,
          driver.AccountActive, driver.HasVehicle, 
          vehicle.Name, vehicle.Description, vehicle.Type, vehicle.Capacity, vehicle.State, vehicle.StateDescription, 
          vehicle.DateAdded,vehicle.Registration FROM driver, vehicle WHERE driver.id = ?
          AND driver.VehicleID=vehicle.id");
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $stmt->bind_result($id, $Name, $Surname, $Email, $Cell, $Gender, $UserCreateDate, $DriverType,$AccountActive,
          $HasVehicle, $VehicleName, $VehicleDescription, $VehicleType, $VehicleCapacity, $VehicleState, 
          $VehicleStateDescription, $VehicleDateAdded, $VehicleRegistration);
          $stmt->fetch();
          $user=array();
          $user['id']=$id;
          $user['Name']=$Name;
          $user['Surname']=$Surname;
          $user['Email']=$Email;
          $user['Cell']=$Cell;
          $user['Gender']=$Gender;
          $user['UserCreateDate']=$UserCreateDate;
          $user['DriverType']=$DriverType;
          $user['AccountActive']=$AccountActive;
          $user['HasVehicle']=$HasVehicle;
          
          $user['VehicleName']=$VehicleName;
          $user['VehicleDescription']=$VehicleDescription;
          $user['VehicleType']=$VehicleType;
          $user['VehicleCapacity']=$VehicleCapacity;
          $user['VehicleStateDescription']=$VehicleStateDescription;
          $user['VehicleDateAdded']=$VehicleDateAdded;
          $user['VehicleRegistration']=$VehicleRegistration;
          return $user; 
       } 


       public function getDriverPassengersById($id)
       {
          $stmt = $this->con->prepare("SELECT passenger.Name, passenger.Surname, passenger.Gender, passenger.Email, passenger.Cell,
          passenger.PickUpLocation, passenger.DropOffLocation, trip.id FROM driver, trip, passenger WHERE driver.id = ?
          AND trip.DriverID=driver.id AND passenger.TripID=trip.id");
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $stmt->bind_result($Name, $Surname, $Gender, $Email, $Cell, $PK, $DP, $TripID );
          $users = array();
          while($stmt->fetch()){
            $user=array();
            $user['Name']=$Name;
            $user['Surname']=$Surname;
            $user['Gender']=$Gender;
            $user['Email']=$Email;
            $user['Cell']=$Cell;
            $user['PickUpLocation']=$PK;
            $user['DropOffLocation']=$DP;
            $user['TripID']=$TripID;
            array_push($users, $user);
            }
           return $users; 
       } 

       public function getPassengerTripId($id)
       {
          $stmt = $this->con->prepare("SELECT id, TripID FROM passenger WHERE id = ?");
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $stmt->bind_result($id, $TripID);
          $stmt->fetch();
          $user=array();
          return $TripID; 
       } 

       public function getPassengerTrip($id2)
       {
          $id = $this->getPassengerTripId($id2);
          $stmt = $this->con->prepare("SELECT id, PickUpArea, DropOffArea, DriverName, Bill, ArrivalTime, DepartureTime FROM trip WHERE id = ?");
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $stmt->bind_result($id,$PickUpArea, $DropOffArea, $DriverName, $Bill, $ArrivalTime, $DepartureTime);
          $stmt->fetch();
          $user=array();
          $user['id']=$id;
          $user['PickUpArea']=$PickUpArea;
          $user['DropOffArea']=$DropOffArea;
          $user['DriverName']=$DriverName;
          $user['Bill']=$Bill;
          $user['ArrivalTime']=$ArrivalTime;
          $user['DepartureTime']=$DepartureTime;
          return $user; 
       } 



       public function getShowTripDriver($tripid)
       {
          $id = $this->getTripDriver($tripid);
          $stmt = $this->con->prepare("SELECT id, Name, Surname, UserType, Email FROM driver WHERE id = ?");
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $stmt->bind_result($id, $Name, $Surname, $UserType, $Email);
          $stmt->fetch();
          $user=array();
          $user['id']=$id;
          $user['Name']=$Name;
          $user['Surname']=$Surname;
          $user['UserType']=$UserType;
          $user['Email']=$Email;
          return $user; 
       } 

       public function getPickUpAreaById($id)
       {
          $stmt = $this->con->prepare("SELECT id, PickUpArea, TimeArrival, TimeDepature, DriverID FROM pickuparea WHERE id = ?");
          $stmt->bind_param("s", $id);
          $stmt->execute();
          $stmt->bind_result($id, $PickUpArea, $TimeArrival, $TimeDepature, $DriverID);
          $stmt->fetch();
          $user=array();
          $user['id']=$id;
          $user['PickUpArea']=$PickUpArea;
          $user['TimeArrival']=$TimeArrival;
          $user['TimeDepature']=$TimeDepature;
          $user['DriverID']=$DriverID;
          return $user; 
       }

       public function getTripByIdForTripWithNoDriver($id)
       {
          $stmt = $this->con->prepare("SELECT trip.id, trip.HasDriver, pickuparea.PickUpArea, dropoffarea.DropOffArea, pickuparea.id, dropoffarea.id, 
          Bill, ArrivalTime, DepartureTime FROM trip, 
          pickuparea, dropoffarea WHERE trip.id = ? AND 
          PickUpAreaID=pickuparea.id AND DropOffAreaID=dropoffarea.id");
 
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $stmt->bind_result($id,$HasDriver, $PickUpArea, $DropOffArea, $PickUpAreaID, $DropOffAreaID, $Bill, $ArrivalTime, $DepartureTime);
          $stmt->fetch();
          $user=array();
          $user['id']=$id;
          $user['HasDriver']=$HasDriver;
          $user['PickUpArea']=$PickUpArea;
          $user['DropOffArea']=$DropOffArea;
          $user['Bill']=$Bill;
          $user['ArrivalTime']=$ArrivalTime;
          $user['DepartureTime']=$DepartureTime;
          $user['PickUpAreaID']=$PickUpAreaID;
          $user['DropOffAreaID']=$DropOffAreaID;
          return $user; 
       } 

       public function getTripById($id)
       {
          $stmt = $this->con->prepare("SELECT trip.id, trip.HasDriver, pickuparea.PickUpArea, dropoffarea.DropOffArea, driver.Name, 
          driver.Surname, driver.id, driver.Cell, 
          driver.Email, driver.Gender, pickuparea.id, dropoffarea.id, 
          Bill, ArrivalTime, DepartureTime FROM trip, 
          pickuparea, dropoffarea, driver WHERE trip.id = ? AND 
          PickUpAreaID=pickuparea.id AND DropOffAreaID=dropoffarea.id 
          AND DriverID=driver.id");
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $stmt->bind_result($id,$HasDriver, $PickUpArea, $DropOffArea, $Name, $Surname, $DriverID,$Cell, $Email,$Gender, $PickUpAreaID, $DropOffAreaID, $Bill, $ArrivalTime, $DepartureTime);
          $stmt->fetch();
          $user=array();
          $user['id']=$id;
          $user['HasDriver']=$HasDriver;
          $user['PickUpArea']=$PickUpArea;
          $user['DropOffArea']=$DropOffArea;
          $user['Name']=$Name;
          $user['Surname']=$Surname;
          $user['DriverID']=$DriverID;
          $user['Bill']=$Bill;
          $user['ArrivalTime']=$ArrivalTime;
          $user['DepartureTime']=$DepartureTime;
          $user['PickUpAreaID']=$PickUpAreaID;
          $user['DropOffAreaID']=$DropOffAreaID;
          $user['Email']=$Email;
          $user['Gender']=$Gender;
          $user['Cell']=$Cell;
          return $user; 
       } 

       public function getPassengerById($id)
       {
          $stmt = $this->con->prepare("SELECT id, Name, Surname, Gender, BirthDate,Email,Cell,HomeAddress,PickUpLocation, 
          DropOffLocation, Assigned FROM passenger WHERE id = ?");
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $stmt->bind_result($id, $Name, $Surname, $Gender, $BirthDate,$Email,$Cell,$HomeAddress, $PickUpLocation, 
          $DropOffLocation, $Assigned);
          $stmt->fetch();
          $user=array();
          $user['id']=$id;
          $user['Name']=$Name;
          $user['Surname']=$Surname;
          $user['Gender']=$Gender;
          $user['BirthDate']=$BirthDate;
          $user['Email']=$Email;
          $user['Cell']=$Cell;
          $user['HomeAddress']=$HomeAddress;
          $user['PickUpLocation']=$PickUpLocation;
          $user['DropOffLocation']=$DropOffLocation;
          $user['Assigned']=$Assigned;
          return $user; 
       } 

       public function getPassengerTripById($id)
       {
      
          $stmt = $this->con->prepare("SELECT passenger.id, passenger.Name, passenger.Surname,passenger.Gender, passenger.BirthDate,
          passenger.HomeAddress,passenger.Email,passenger.Cell, passenger.PickUpLocation,
          passenger.DropOffLocation, passenger.TripID, trip.Bill,trip.ArrivalTime, 
          trip.DepartureTime, pickuparea.PickUpArea, dropoffarea.DropOffArea
          FROM passenger, trip, pickuparea, dropoffarea
          WHERE passenger.id = ? AND trip.id=TripID AND pickuparea.id=PickUpAreaID
          AND dropoffarea.id=DropOffAreaID ORDER BY passenger.id;");
          $stmt->bind_param("i", $id);
          $stmt->bind_result($id, $Name, $Surname,$Gender, $BirthDate,$HomeAddress, $Email, $Cell, $PickUpLocation,$DropOffLocation,$TripID, $Bill,$ArrivalTime,
          $DepartureTime, $PickUpArea,  $DropOffArea);
          $stmt->execute();
          $stmt->fetch();
          $user=array();
          $user['id']=$id;
          $user['Name']=$Name;
          $user['Surname']=$Surname;
          $user['Gender']=$Gender;
          $user['Email']=$Email;
          $user['Cell']=$Cell;
          $user['BirthDate']=$BirthDate;
          $user['HomeAddress']=$HomeAddress; 
          $user['PickUpLocation']=$PickUpLocation;
          $user['DropOffLocation']=$DropOffLocation;
          $user['TripID']=$TripID;
          $user['Bill']=$Bill;
          $user['ArrivalTime']=$ArrivalTime;
          $user['PickUpArea']=$PickUpArea;
          $user['DropOffArea']=$DropOffArea;
          $user['DepartureTime']=$DepartureTime;
          return $user; 
       } 

      public function getUserByEmail($Email)
      {
         $stmt = $this->con->prepare("SELECT id, Name, Surname, UserType, Email FROM singleuser WHERE Email = ?");
         $stmt->bind_param("s", $Email);
         $stmt->execute();
         $stmt->bind_result($id, $Name, $Surname, $UserType, $Email);
         $stmt->fetch();
         $user=array();
         $user['id']=$id;
         $user['Name']=$Name;
         $user['Surname']=$Surname;
         $user['UserType']=$UserType;
         $user['Email']=$Email;
         return $user; 
      }    

      public function getDriverByEmail($Email)
      {
         $stmt = $this->con->prepare("SELECT id, Name,Surname, Usertype, Email FROM driver WHERE Email = ?");
         $stmt->bind_param("s", $Email);
         $stmt->execute();
         $stmt->bind_result($id, $Name, $Surname, $Usertype, $Email);
         $stmt->fetch();
         $user=array();
         $user['id']=$id;
         $user['Name']=$Name;
         $user['Surname']=$Surname;
         $user['UserType']=$Usertype;
         $user['Email']=$Email;
         return $user; 
      }

      public function DriverLogin2($Email, $Password)
      {
         if($this->EmailCheckerExistDriver($Email)){
            $hashed_password = $this->getDriverPasswordByEmail($Email);
            if(password_verify($Password, $hashed_password)){
               return USER_AUTHENTICATED;
            }else{
               return USER_PASSWORD_DO_NOT_MATCH;
            }
         }else{
            return USER_NOT_FOUND;
         }
      }

      public function getDriverPasswordByEmail($Email)
      {
         $stmt = $this->con->prepare("SELECT Password FROM driver WHERE Email = ?");
         $stmt->bind_param("s", $Email);
         $stmt->execute();
         $stmt->bind_result($Password);
         $stmt->fetch();
         return $Password; 
      }    
      
      public function updateUser($Name, $Surname, $Email, $Cell, $id)
      {
         $stmt = $this->con->prepare("UPDATE singleuser SET Name = ?, Surname = ?, Email = ? , Cell = ? WHERE id = ?");
         $stmt->bind_param("sssii", $Name, $Surname, $Email, $Cell, $id);
         if($stmt->execute())
            return true;
         return false;
      }

      public function updateDriver($Name, $Surname,$Gender, $Email, $Cell, $Usertype, $DriverType, $UserCreateDate, $AccountActive, $id)
      {
         $stmt = $this->con->prepare("UPDATE driver SET Name = ?, Surname = ?, Gender = ?, Email = ? , Cell = ? , Usertype= ?, DriverType = ?,UserCreateDate = ?,AccountActive = ? WHERE id = ?");
         $stmt->bind_param("sssssssssi", $Name, $Surname, $Gender, $Email, $Cell, $Usertype, $DriverType, $UserCreateDate, $AccountActive,$id);
         if($stmt->execute())
            return true;
         return false;
      }

      public function updatePassenger($Name, $Surname,$Gender, $BirthDate, $Email, $Cell, $HomeAddress, $PickUpLocation, $DropOffLocation, $id)
      {
         $stmt = $this->con->prepare("UPDATE passenger SET Name = ?, Surname = ?, Gender = ?,  BirthDate = ?,Email = ? , Cell = ? , HomeAddress = ? ,PickUpLocation = ?,DropOffLocation = ? WHERE id = ?");
         $stmt->bind_param("sssssssssi", $Name, $Surname,$Gender, $BirthDate, $Email, $Cell, $HomeAddress, $PickUpLocation, $DropOffLocation, $id);
         if($stmt->execute())
            return true;
         return false;
      }
      
      public function DeactivateDriverAccount($AccountActive, $id)
      {
         $stmt = $this->con->prepare("UPDATE driver SET AccountActive = ? WHERE id = ?");
         $stmt->bind_param("si", $AccountActive,$id);
         if($stmt->execute())
            return true;
         return false;
      }

      public function DeactivatePassengerAccount($AccountActive, $id)
      {
         $stmt = $this->con->prepare("UPDATE passenger SET AccountActive = ? WHERE id = ?");
         $stmt->bind_param("si", $AccountActive,$id);
         if($stmt->execute())
            return true;
         return false;
      }

      public function ActivateDriverAccount($AccountActive, $id)
      {
         $stmt = $this->con->prepare("UPDATE driver SET AccountActive = ? WHERE id = ?");
         $stmt->bind_param("si", $AccountActive,$id);
         if($stmt->execute())
            return true;
         return false;
      }

      public function UnassignDriverToTrip($DriverID, $id)
      {
         $stmt = $this->con->prepare("UPDATE trip SET DriverID = ? WHERE id = ?");
         $stmt->bind_param("ii", $DriverID,$id);
         if($stmt->execute())
            return true;
         return false;
      }



      public function ActivatePassengerAccount($AccountActive, $id)
      {
         $stmt = $this->con->prepare("UPDATE passenger SET AccountActive = ? WHERE id = ?");
         $stmt->bind_param("si", $AccountActive,$id);
         if($stmt->execute())
            return true;
         return false;
      }

      public function UnassignTripToPassenger($TripID, $id)
      {
         $stmt = $this->con->prepare("UPDATE passenger SET TripID = ? WHERE id = ?");
         $stmt->bind_param("ii", $TripID,$id);
         if($stmt->execute())
            return true;
         return false;
      }

      public function updatePassword($currentpassword, $newpassword, $Email){
         $hashed_password = $this->getUsersPasswordByEmail($Email);

         if(password_verify($currentpassword, $hashed_password)){

            $hash_password = password_hash($newpassword, PASSWORD_DEFAULT);
            $stmt = $this->con->prepare("UPDATE singleuser SET Password = ? WHERE Email = ?");
            $stmt->bind_param("ss" , $hash_password, $Email);

            if($stmt->execute())
               return PASSWORD_CHANGED;
            return PASSWORD_NOT_CHANGED;
         }else{
            return PASSWORD_DO_NOT_MATCH;
         }
      }
 

      public function deleteUser($id){
         $stmt = $this->con->prepare("DELETE FROM singleuser WHERE id=?");
         $stmt->bind_param("i", $id);
         if($stmt->execute())
            return true;
            return false;
      }

      public function deleteDriver($id){
         $stmt = $this->con->prepare("DELETE FROM driver WHERE id=?");
         $stmt->bind_param("i", $id);
         if($stmt->execute())
            return true;
            return false;
      }

      public function deletePickUpArea($id){
         $stmt = $this->con->prepare("DELETE FROM pickuparea WHERE id=?");
         $stmt->bind_param("i", $id);
         if($stmt->execute())
            return true;
            return false;
      }

      public function deleteDropOffArea($id){
         $stmt = $this->con->prepare("DELETE FROM dropoffarea WHERE id=?");
         $stmt->bind_param("i", $id);
         if($stmt->execute())
            return true;
            return false;
      }

      public function deletePassenger($id){
         $stmt = $this->con->prepare("DELETE FROM passenger WHERE id=?");
         $stmt->bind_param("i", $id);
         if($stmt->execute())
            return true;
            return false;
      }

      public function deleteTrip($id){
         $stmt = $this->con->prepare("DELETE FROM trip WHERE id=?");
         $stmt->bind_param("i", $id);
         if($stmt->execute())
            return true;
            return false;
      }

       private function EmailCheckerExist($Email)
       {
          $stmt = $this->con->prepare("SELECT id FROM singleuser WHERE Email = ?");
          $stmt->bind_param("s", $Email);
          $stmt->execute();
          $stmt->store_result();
          return $stmt->num_rows > 0;
       }

       private function TripCheckerExist($PickUpArea, $DropOffArea)
       {
          $stmt = $this->con->prepare("SELECT id FROM trip WHERE PickUpArea = ?");
          $stmt2 = $this->con->prepare("SELECT id FROM trip WHERE DropOffArea = ?");
          $stmt->bind_param("s", $PickUpArea);
          $stmt2->bind_param("s", $DropOffArea);
          $stmt->execute();
          $stmt->store_result();
          $stmt2->execute();
          $stmt2->store_result();
          return $stmt->num_rows > 0;
       }
   }