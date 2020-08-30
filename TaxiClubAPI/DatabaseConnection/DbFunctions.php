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
         if(!$this->EmailCheckerExist($Email))
         {
            $stmt = $this->con->prepare("INSERT INTO driver (Name, Surname, Gender, Email, Cell, Usertype, DriverType, 
            UserCreateDate, AccountActive, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssisssss", $Name, $Surname, $Gender, $Email, $Cell, $Usertype, $DriverType, 
                                         $UserCreateDate,$AccountActive,$Password);
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
         $stmt2 = $this->con->prepare("SELECT id, Name, Surname, Usertype, Cell, Password,
         Email, DriverType, UserCreateDate, AccountActive, Gender FROM driver;");
         $stmt2->execute();
         $stmt2->bind_result($id, $Name, $Surname, $Usertype, $Cell, $Password,
         $Email, $DriverType, $UserCreateDate, $AccountActive, $Gender);
         $users = array();
         while($stmt2->fetch()){
         $user=array();
         $user['id']=$id;
         $user['Name']=$Name;
         $user['Surname']=$Surname;
         $user['Usertype']=$Usertype;
         $user['Cell']=$Cell;
         $user['Password']=$Password;
         $user['Email']=$Email;
         $user['DriverType']=$DriverType;
         $user['UserCreateDate']=$UserCreateDate;
         $user['AccountAccount']=$AccountActive;
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
         AccountActive,PickUpLocation,DropOffLocation,Password,TripID FROM passenger WHERE AccountActive='true';");
         $stmt2->execute();
         $stmt2->bind_result($id, $Name, $Surname, $Gender, $BirthDate,$Email,$Cell,$HomeAddress,$UserCreateDate,$Usertype,
         $AccountActive,$PickUpLocation,$DropOffLocation,$Password,$TripID);
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
         array_push($users, $user);
         }
          return $users;
       }

       public function getAllPassengersList()
       {
         $stmt2 = $this->con->prepare("SELECT passenger.id, passenger.Name, passenger.Surname, passenger.Gender, passenger.BirthDate,passenger.Email,passenger.Cell,passenger.HomeAddress,passenger.UserCreateDate,passenger.Usertype,
         passenger.AccountActive,passenger.PickUpLocation,passenger.DropOffLocation,passenger.Password,passenger.TripID, trip.Bill,trip.ArrivalTime, trip.DepartureTime, pickuparea.PickUpArea, dropoffarea.DropOffArea FROM passenger, trip, pickuparea, dropoffarea WHERE trip.id=TripID AND pickuparea.id=PickUpAreaID  AND dropoffarea.id=DropOffAreaID ORDER BY passenger.id;");
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

       public function getAllTrips()
       {
         $stmt2 = $this->con->prepare("SELECT id, PickUpArea, DropOffArea, DriverName, Bill, ArrivalTime, DepartureTime FROM trip;");
         $stmt2->execute();
         $stmt2->bind_result($id, $PickUpArea , $DropOffArea, $DriverName, $Bill, $ArrivalTime, $DepartureTime);
         $users = array();
         while($stmt2->fetch()){
         $user=array();
         $user['id']=$id;
         $user['PickUpArea']=$PickUpArea;
         $user['DropOffArea']=$DropOffArea; 
         $user['DriverName']=$DriverName;       
         $user['Bill']=$Bill;
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
       $Password, $TripID)
       {
     
            $stmt = $this->con->prepare("INSERT INTO passenger (Name , Surname, Gender, BirthDate, Email,
            Cell, HomeAddress, UserCreateDate, Usertype, AccountActive, PickUpLocation, DropOffLocation, 
            Password, TripID) VALUES (?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssssssssssi",$Name , $Surname, $Gender, $BirthDate, $Email,
            $Cell, $HomeAddress, $UserCreateDate, $Usertype, $AccountActive, $PickUpLocation, $DropOffLocation, 
            $Password, $TripID);
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

       public function updateAssignTripToPassenger($PickUpArea2, $DropOffArea2, $id)
       {
          $PickUpAreaID = $this->getPickUpAreaByName($PickUpArea2);
          $DropOffAreaID = $this->getDropOffAreaByName($DropOffArea2);
          $TripID = $this->getTripByPickUpAreaId($PickUpAreaID, $DropOffAreaID);
          $stmt = $this->con->prepare("UPDATE Passenger SET TripID = ? WHERE id = ?");
          $stmt->bind_param("ii", $TripID, $id);
          if($stmt->execute())
          return true;
          return false;
       }

       public function updateUnassignTripToPassenger($id)
       {
          $TripID = null;
          $stmt = $this->con->prepare("UPDATE passenger SET TripID = ? WHERE id = ?");
          $stmt->bind_param("ii", $TripID, $id);
          if($stmt->execute())
          return true;
          return false;
       }
    
       public function createTrip($PickUpArea2, $DropOffArea2, $DriverName2, $Bill, $ArrivalTime, $DepartureTime)
       { 
            $PickUpAreaID = $this->getPickUpAreaByName($PickUpArea2);
            $DropOffAreaID = $this->getDropOffAreaByName($DropOffArea2);
            $DriverID = $this->getDriverByName($DriverName2);
            $stmt = $this->con->prepare("INSERT INTO trip (PickUpAreaID, DropOffAreaID, DriverID, Bill, ArrivalTime, DepartureTime) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiisss",$PickUpAreaID, $DropOffAreaID, $DriverID, $Bill, $ArrivalTime, $DepartureTime);
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
          $id2 = 11;
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

       public function getTripById($id)
       {
          $stmt = $this->con->prepare("SELECT id, PickUpArea, DropOffArea, DriverName, Bill, ArrivalTime, DepartureTime FROM trip WHERE id = ?");
          $stmt->bind_param("s", $id);
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

       public function getPassengerById($id)
       {
          $stmt = $this->con->prepare("SELECT id, Name, Surname, Gender, BirthDate,Email,Cell,HomeAddress,PickUpLocation, 
          DropOffLocation FROM passenger WHERE id = ?");
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $stmt->bind_result($id, $Name, $Surname, $Gender, $BirthDate,$Email,$Cell,$HomeAddress, $PickUpLocation, 
          $DropOffLocation);
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
         $stmt = $this->con->prepare("SELECT id, Name, Surname, Usertype, Email FROM driver WHERE Email = ?");
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