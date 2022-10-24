<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
   
   #form check
            //check if user with this email already exist in the database
            $sql = "SELECT * FROM students WHERE email = '$email' ";

      $res = mysqli_query($conn,$sql);

      if (mysqli_num_rows($res) > 0) {
        if($row = mysqli_fetch_assoc($res))
        {
            	echo $row['email'] .  " already exists";
        }
        } 
        else{
            $sql1 = "INSERT INTO Students (full_names,country,email,gender,password) VALUES ('$fullnames','$country','$email','$gender','$password')";
                $query = mysqli_query($conn, $sql1);
                if($query){
                    echo "User Successfully registered";
                }
        }
		}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

    $sql="SELECT * FROM students WHERE password='$password' AND email='$email' ";
    
          $res=mysqli_query($conn,$sql);
    
          if ($res) {
            
            $row = mysqli_fetch_assoc($res);
            if($email==isset($row['email']) && $password ==isset($row['password']))
            {
                session_start();
                $_SESSION['username']= $row['full_names'] ;
                header("location:../dashboard.php");
            }
            }
    else{
        header("location:../forms/login.html");
    }

    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    
    //open connection to the database and check if username exist in the database
    $sql = "SELECT * FROM students WHERE email = '$email' ";

    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($res);
    
      if($email==$row['email'])
      {
     $update = "UPDATE `students` SET `password`='$password' WHERE email = '$email' ";
     $query = mysqli_query($conn, $update);
              if($query){
                  echo "Password successfully changed";
              }
      }
      else{
           echo "User doesn't exist";
      }
    }

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     //delete user with the given id from the database
     $sql = "DELETE FROM `students` WHERE `students`.`id` = $id ";
     $result = mysqli_query($conn, $sql);
     if($result){
        echo "User account deleted succesfully";
     }else{
        echo "Unable to delete user at the moment";
     }


 }
