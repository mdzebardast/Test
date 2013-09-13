<?php

    include("config.php");
    include("FN_Image.class.php");
    include("jdf.php");

 //------------------------------------------------------------------------------------------------------------------------------------------------------------
    function redirect($addr){
        @header("location:".$addr);
    }
 //-------------------------------------------------------------------------------------Login-------------------------------------------------------------------------
    function login($User,$Pass){
          //Checking the user and pass...
           $sql = "SELECT `pass`,`uid`,`type`,`name`,`username`   FROM `users`
                   WHERE `username` = '$User' AND active=1" ;

                  mysql_query('SET NAMES UTF8');
                  $Result = mysql_query($sql);
                  $Pass=md5($Pass);
                  $row=mysql_fetch_array($Result);
                  if(mysql_num_rows($Result) == 1 && $row['pass'] == $Pass)
                  {
                     $_SESSION['UserName'] = $User;

                     $ClientString = $_SERVER['HTTP_USER_AGENT'] .$_SERVER['REMOTE_ADDR'];
                     $_SESSION['ClientStr'] = md5($ClientString);
                     $_SESSION['uid']=$row['uid'];
                     $_SESSION['type']=$row['type'];
                     $_SESSION['name']=$row['name'];
                     $_SESSION['UserName']=$row['username'];
                     $message="<p >خوش آمديد!</p>";
                     //loginshow();      //show exit button(LogOut)
                  }
                  else
                  {
                      $message="<p class='error'>نام کاربري وکلمه عبور شما اشتباه مي باشد!</p>";
                  }
              return $message;

    }   //end function
   function  loginshow(){
        if(isset($_SESSION['UserName'])){
                  echo "<form method='post' action='index.php' ><tr><td><li><input type='submit' value='خروج' class='logout' name='btnlogout'/></li></td></tr></form>";
        }
    }
    function registerUser($Name,$Email,$UN,$Pw){
           //Check Exist...
           $fail=1;    //correct
           $Sql = "SELECT COUNT(*) FROM `users` WHERE `username` = '$UN'";
           mysql_query('SET NAMES UTF8');
           $Result = mysql_query($Sql) or die(mysql_error() . "<br>SQL: " . $Sql);
           if(mysql_result($Result, 0) > 0 ){
               $message="<p class='error'>اين نام کاربري قبلا ثبت شده است!</p>";
               $fail=2;
           }
           //check username
           if($fail==1){
                $Sql = "SELECT COUNT(*) FROM `users` WHERE `email` = '$Email'";
                mysql_query('SET NAMES UTF8');
                $Result = mysql_query($Sql) or die(mysql_error() . "<br>SQL: " . $Sql);
                if(mysql_result($Result, 0) > 0 ){
                    $message="<p class='error'>اين ايميل قبلا ثبت شده است!</p>";
                    $fail=2;
                }
          }//second end if

           //Create A Random Security Code...
           $RandomNum = rand(0, 9999);
           $SecCode =  md5($RandomNum);
           $Pw=md5($Pw);
           if($fail==1){
               //Insert New User...
               $Sql = "INSERT INTO `users` (`email`, `name`,`UserName`,`Pass`, `active`, `join_date`, `sec_code`)
                   VALUES
                       ('$Email', '$Name','$UN','$Pw',1, CURRENT_TIMESTAMP, '$SecCode')";
                mysql_query('SET NAMES UTF8');
                $Result = mysql_query($Sql) or die(mysql_error() . "<br>SQL: " . $Sql);
                $message="ثبت با موفقيت انجام شد";
           }

           return $message;
    }
    function showuser(){
              $query="SELECT uid,name,email,username,active,join_date,type FROM users ORDER BY name";
              mysql_query('SET NAMES UTF8');
              $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);

              echo "<table  class='bank'><tr class='headtr'> <td >نام</td> <td >نام کاربري</td> <td>ايميل</td><td>تاريخ عضويت</td><td>نوع کاربري</td> <td>وضعيت</td><td>ويرايش</td><td>حذف</td></tr>";
              $i=0;
              while ($row=mysql_fetch_array($Result)){
                   if($i%2==0){
                        echo '<tr class="whitetr">';
                        }
                   else{
                    echo "<tr class='inter'>";                                                         //change background
                   }

                    print('<td><label>'.$row['name'].' </label></td>');                                          //show title
                    print('<td><label>'.$row['username'].' </label></td>');                                          //show username
                    print('<td><label>'.$row['email'].' </label></td>');

                    list($gYear,$gMonth,$gDay) = explode("-",$row['join_date']);                       //convert date to shamsi
			        list($jYear,$jMonth,$jDay) = gregorian_to_jalali((int)$gYear, (int)$gMonth, (int)$gDay);
                    print('<td><label> '.$jYear."/".$jMonth."/".$jDay." </label></td>");                //show date

                    if($row['type']==1){
                        echo('<td><label>کاربر</label></td>');                                          //show type
                    }
                    else{
                        echo('<td><label>مدير</label></td>');                                          //show type
                    }

                    if($row['active']==1){
                        echo('<td><label>فعال</label></td>');                                          //show status
                    }
                    else{
                        echo('<td><label>غيرفعال</label></td>');                                          //show status
                    }
                    echo "<td> <a href=actions.php?from=0&act=3&id=$row[uid]> <img  class='update'></a></td>";   //update
                    echo "<td> <a onclick=resure('actions.php?from=0&act=2&id=$row[uid]');return false;> <img  class='delete'></a></td>";   //delete


                    $i++;
                    echo "</tr>";
                }//End While
               echo "</table>" ;
    }
      function deluser($id){
        $message="";
        $query="DELETE FROM users Where uid=$id";
        $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);

        if( mysql_affected_rows()){
            $message="با موفقيت حذف شد";
        }else {
            $message="<p class=error>حذف نشد!<p> ";
        }
          return $message;
    }

     function updateuser($id,$name,$email,$un,$pw,$active,$type){
           $fail=1;    //correct
           $Sql = "SELECT COUNT(*) FROM `users` WHERE uid!=$id AND `username` = '$un' ";
           mysql_query('SET NAMES UTF8');
           $Result = mysql_query($Sql) or die(mysql_error() . "<br>SQL: " . $Sql);
           if(mysql_result($Result, 0) !=0 ){
               $message="<p class='error'>اين نام کاربري قبلا ثبت شده است!</p>";
               $fail=2;
           }
           if($fail==1){      //check email
               $Sql = "SELECT COUNT(*) AS count FROM `users` WHERE uid!=$id AND `email` = '$email'";   //check email is repeated
               mysql_query('SET NAMES UTF8');
               $Result = mysql_query($Sql) or die(mysql_error() . "<br>SQL: " . $Sql);
               if(mysql_result($Result, 0)!=0 ){
                   $message="<p class='error'>اين ايميل قبلا ثبت شده است!</p>";
                   $fail=2;  //There is an error //repeated email
               }
           }
           ////check password is changed  .......................................
           $Sql = "SELECT COUNT(*) FROM `users` WHERE `pass` = '$pw' AND uid=$id";   //check password is changed
           mysql_query('SET NAMES UTF8');
           $Result = mysql_query($Sql) or die(mysql_error() . "<br>SQL: " . $Sql);

           if(mysql_result($Result,0)==0){  //
                $pw=md5($pw);
           }

           if($fail==1){
               $query="UPDATE users SET name='$name',email='$email',username='$un',pass='$pw',active=$active,`type`=$type WHERE uid='$id'";
                mysql_query('SET NAMES UTF8');
                $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);
                if(mysql_affected_rows()){
                    $message="ويرايش با موفقيت انجام شد";
                }else{
                    $message="ويرايشي انجام نشد!";
                }
            }
        return $message;
     }
//-----------------------------------------------------------------------------------------------------------------------------------------------------
    function showregion(){
    try{
        $query="SELECT * FROM street  ORDER BY `name`";
        mysql_query('SET NAMES UTF8');
        $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);
        $i=0;
        while ($row=mysql_fetch_array($Result)){
          if($i==0){
             echo '<option selected="selected" value="' . $row['sid'] . '">' . $row['name'] . '</option>';
             $i++;
          }else{
             echo '<option value="' . $row['sid'] . '">' . $row['name'] . '</option>';
          }

        }
        mysql_free_result($Result);

    }catch(Exception $e){
        echo e.getMessage();
    }

    }
//-----------------------------------------------------------------------------------------------------------------------------------------------------
    function showsubgroup(){
    try{
//        $query="SELECT * FROM `group` WHERE parentid!=0  ORDER BY `name`";
        $query=" SELECT g.*,sg.`name` AS parentname FROM `group` g
                    JOIN  `group` sg ON g.`parentid`=sg.gid
                    WHERE g.parentid!=0
                ORDER BY g.parentid , g.`name` ";

        mysql_query('SET NAMES UTF8');
        $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);
        $i=1;
        $prevparent=0;
        while ($row=mysql_fetch_array($Result)){

             if($row['parentid']!=$prevparent){
                 echo '<div class="groupheader">' . $row['parentname'] .  '</div>';
             }

             echo '<label style="width:40px;"> <input name="subgroups[]" value="' . $row['gid'] . '"type="checkbox"/>' . $row['name'] . ' </label>';
             if($i%2==0)
                echo '<br/>';

            $prevparent=$row['parentid'];
            $i++;

        }
        mysql_free_result($Result);

    }catch(Exception $e){
        echo e.getMessage();
    }

    }


//-----------------------------------------------------------------position-----------------------------------------------------------------------------------------

   function regposition($owner_id,$locname,$region,$street,$link,$site,$tell,$fax,$email,$manager,$address,$keywords,$subgroups,$logopic,$pic1,$pic2,$pic3){

           $query="INSERT INTO `position`(`pid`, `uid`, `name`, `region`, `streetid`, `site` , `tel`, `fax`, `email`, `manager`, `address`, `logo`, `keywords`)
                                  VALUES ( null, $owner_id , '$locname' , '$region' , $street , '$site' , '$tell' , '$fax' , '$email' , '$manager' , '$address' , '$logopic' , '$keywords' )";

//           echo $query . "<br/>";
           mysql_query($query);
           $pid=mysql_insert_id();

           $query = "INSERT INTO `image`(`id`, `positionid`, `name`) VALUES ( null , $pid , '$pic1')" ;

            mysql_query($query);
           $query = "INSERT INTO `image`(`id`, `positionid`, `name`) VALUES ( null , $pid , '$pic2')" ;

            mysql_query($query);
           $query = "INSERT INTO `image`(`id`, `positionid`, `name`) VALUES ( null , $pid , '$pic3')" ;

            mysql_query($query);
            $i=0;
            foreach($subgroups as $group){
                $query = "INSERT INTO `positiongroup`(`id`, `gid`, `pid`) VALUES ( null , $group , '$pid')" ;
                mysql_query($query);
                if($i++==5)    //Just five sub groups you can choose ...
                    break;
            }
//           echo mysql_error() . "<br/>";
           $message=" با موفقيت ثبت شد ";
           return $message;
}

function showposition($positionname,$streetname,$streetid,$groupid=0,$from=-1){
    $uid=isset($_SESSION['uid']) ? $_SESSION['uid'] : '';
    if($groupid!=0 && $from==-1){
        $query="SELECT pos.* FROM `group` g
    	        JOIN `positiongroup` pg ON g.`gid` = pg.`gid`
	            JOIN `position` pos ON pos.pid=pg.`pid`
            WHERE g.`parentid`= $groupid AND  pos.`name` LIKE '%$positionname%'  ";
    }elseif($from==-1){
        $query="SELECT * FROM `position` pos WHERE pos.`name` LIKE '$positionname%' ";
    }elseif($from==6){  //From Edit position
        $query="SELECT * FROM `position` pos WHERE pos.uid =$uid  ";
    }


//     echo $query;

    if($streetid!=""){
        $query .= " AND streetid=$streetid  ";
    }
    $query .=" GROUP BY pid  limit 15 ";

    //echo $query;

    $result=mysql_query($query);
    $count=1;
    while ($row=mysql_fetch_array($result)){

        $query=" SELECT name FROM image i WHERE i.`positionid`=$row[pid] ";
        $imgresult=mysql_query($query);
        $piccount=1;
        while ($imgrow=mysql_fetch_array($imgresult)){
             $imgrow['name']=htmlspecialchars($imgrow['name']);
             $picrow['pic' . $piccount++]=$imgrow['name'];
        }

        $delete=$from==6 ?  "<a onclick=resure('actions.php?from=6&act=2&id=$row[pid]');return false;> <img  class='delete'></a>" : ' ';
        $address=$from==6 ?  "../images/" : "images/" ;

        echo ' <div class="position"> ';
        echo '            <label>' . $row['name'] . '</label>  <hr />   ';
        echo '                        <ul class="information">          ';
        echo '                            <li><label> فکس :</label> <label> ' . $row['fax'] . '  </label></li>  ';
        echo '                            <li><label> تلفن :</label> <label> ' . $row['tel'] . ' </label></li>  ';
        echo '                            <li><label> ايميل :</label> <label> ' . $row['email'] . ' </label></li>   ';
        echo '                            <li><label> وب سايت :</label> <label> ' . $row['site'] . ' </label></li>                      ';
        echo '                            <li><label> آدرس :</label> <label>' . $row['address'] . ' </label> </li>  ';
        echo '                            <li><label>' . $delete . '</label></li>                                                  ';
        echo '                        </ul>                                                                         ';
        echo '                                                                                                      ';
        echo '                     <div class="logo"><img src=" ' . $address . $row['logo'].'" width="60" height="60"/></div>';
        echo '                                                                                                        ';
        echo '                    <div class="slider-wrapper theme-light">                                            ';
        echo '                        <div id="slider' . $count . '" class="nivoSlider">                              ';
        echo '                            <img src=" ' . $address . $picrow['pic1'].'" data-thumb=" ' . $address . $picrow['pic1'].'" alt="" width="618" height="190" style="	max-height:190 !important;max-width:618 !important;"/>    ';
        echo '                            <img src=" ' . $address . $picrow['pic2'].'" data-thumb=" ' . $address . $picrow['pic2'].'" alt="" width="618" height="190" style="	max-height:190 !important;max-width:618 !important;" data-transition="slideInLeft" />    ';
        echo '                            <img src=" ' . $address . $picrow['pic3'].'" data-thumb=" ' . $address . $picrow['pic3'].'" alt="" width="618" height="190" style="	max-height:190 !important;max-width:618 !important;" title="#htmlcaption" />             ';
        echo '                        </div>                ';
        echo '                    </div>                    ';
        echo '                                              ';
        echo '            <script type="text/javascript">   ';
        echo '                $(document).ready(function() {';
        echo '                $("#slider'.  $count++  .'").nivoSlider();';
        echo '              });                                         ';
        echo '            </script>                                     ';
        echo ' </div>                                                   ';
    }

     mysql_free_result($result);
    exit();
}
 function delposition($id,$uid){
        $message="";
        //------------------------------ Delete logo pic------------------------
        $query=" SELECT logo FROM `position` where pid=$id AND uid=$uid ";
        $result = mysql_query($query);
        if($row=mysql_fetch_array($result))
            $address="../images/" . $row['logo'] ;
            if(file_exists($address))
                unlink($address);
        //-------------delete position------------------------------------------
        $query="DELETE FROM `position` Where pid=$id AND uid=$uid";
        echo $query;
        $result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);
        //-------------------- //delete position's images-----------------------
        $query="SELECT id,`name` FROM image WHERE positionid=$id";
        echo $query;
        $result=mysql_query($query);
        while($row=mysql_fetch_array($result)){
            $address="../images/" . $row['name'] ;
            echo $address;
            if(file_exists($address))
                unlink($address);
        }
        //-------------------------  delete position's images' records-------------------
        $query="DELETE FROM image WHERE positionid=$id";
        echo $query;
        $result=mysql_query($query);
        //-------------------------    //delete position's subgroups------------
        $query="DELETE FROM positiongroup WHERE pid=$id";
         echo $query;
        $result=mysql_query($query);

        if( mysql_affected_rows()){
            $message="با موفقيت حذف شد";
        }else {
            $message="<p class=error>حذف نشد!<p> ";
        }
          return $message;
    }
//----------------------------------------------------------Street --------------------------------------------------------------
function regstreet($streetname){
        try{
            $uid=$_SESSION['uid'];
            $query="INSERT INTO `street` (`sid`,`name`,`uid`) VALUES (null,'$streetname',$uid)";
            mysql_query($query);


            if( mysql_affected_rows())
            {
                $message="با موفقيت ثبت شد";
            } else {
                $message="<p class=error>ثبت نشد!<p> ";
            }
        }catch(Exception $e){
            //echo e.getMessage();
            $message="<p class=error>ثبت نشد!<p> ";
        }
        return $message;

}

 function showstreet(){
              $uid=$_SESSION['uid'];

              //$query="SELECT  `sid`,`name`,`uid` FROM `street` s WHERE s.`uid`=$uid ORDER BY NAME LIMIT 0, 10";
              $query="SELECT  DISTINCT `sid`,s.`name`,s.`uid`,streetid FROM `street` s
                        LEFT JOIN POSITION p ON streetid=sid
                      WHERE s.`uid`=$uid
                    ORDER BY s.`name` ";

              mysql_query('SET NAMES UTF8');
              $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);

              echo "<table  class='bank'><tr class='headtr'> <td >نام</td>  <td>ويرايش</td><td>حذف</td></tr>";
              $i=0;
              while ($row=mysql_fetch_array($Result)){
                   if($i%2==0){
                        echo '<tr class="whitetr">';
                        }
                   else{
                    echo "<tr class='inter'>";                                                         //change background
                   }

                    echo('<td><label>'.$row['name'].' </label></td>');                                          //show title
                    $update=$row['streetid']==null ?  "<a href=actions.php?from=3&act=3&id=$row[sid]> <img  class='update'></a>" : ' ';
                    $delete=$row['streetid']==null ?  "<a onclick=resure('actions.php?from=3&act=2&id=$row[sid]');return false;> <img  class='delete'></a>" : ' ';
                    echo "<td> $update </td>";   //update
                    echo "<td> $delete </td>";   //delete


                    $i++;
                    echo "</tr>";
                }//End While
               echo "</table>" ;
    }


    function updatestreet($name,$id,$uid){
        $message="";
        $query="UPDATE street SET name='$name' WHERE sid=$id AND uid=$uid";
        mysql_query('SET NAMES UTF8');
        $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);
        if(mysql_affected_rows())
            $message="ويرايش با موفقيت انجام شد";
        else
            $message="ويرايشي انجام نشد!";

        return $message;

    }

    function delstreet($id,$uid){
        $message="";
        $query="DELETE FROM street Where sid=$id AND uid=$uid";
        $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);

        if( mysql_affected_rows()){
            $message="با موفقيت حذف شد";
        }else {
            $message="<p class=error>حذف نشد!<p> ";
        }
          return $message;
    }


//---------------------------------------------------------- Group --------------------------------------------------------------
function reggroup($groupid,$subgroupname){
        try{
            $uid=$_SESSION['uid'];
            $query="INSERT INTO `group`(`gid`,`name`,`parentid`,`uid`)VALUES (null,'$subgroupname',$groupid,$uid)";
            mysql_query($query);

            echo $query;

            if( mysql_affected_rows())
            {
                $message="با موفقيت ثبت شد";
            } else {
                $message="<p class=error>ثبت نشد!<p> ";
            }
        }catch(Exception $e){
            //echo e.getMessage();
            $message="<p class=error>ثبت نشد!<p> ";
        }
        return $message;

}

 function showgroup(){
              $uid=$_SESSION['uid'];

              //$query="SELECT  `sid`,`name`,`uid` FROM `street` s WHERE s.`uid`=$uid ORDER BY NAME LIMIT 0, 10";
              $query="SELECT g.gid,g.name,g.parentid,g.uid , pg.`id` FROM `group`  g
                        LEFT JOIN positiongroup pg ON g.`gid`=pg.`gid`
                        WHERE uid= $uid ";

              mysql_query('SET NAMES UTF8');
              $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);

               echo "<table  class='bank'><tr class='headtr'> <td >نام</td>  <td>ويرايش</td><td>حذف</td></tr>";
              $i=0;
              while ($row=mysql_fetch_array($Result)){
                   if($i%2==0){
                        echo '<tr class="whitetr">';
                        }
                   else{
                    echo "<tr class='inter'>";                                                         //change background
                   }

                    echo('<td><label>'.$row['name'].' </label></td>');                                          //show title
                    $update=$row['id']==null ?  "<a href=actions.php?from=5&act=3&id=$row[gid]> <img  class='update'></a>" : ' ';
                    $delete=$row['id']==null ?  "<a onclick=resure('actions.php?from=5&act=2&id=$row[gid]');return false;> <img  class='delete'></a>" : ' ';
                    echo "<td> $update </td>";   //update
                    echo "<td> $delete </td>";   //delete


                    $i++;
                    echo "</tr>";
                }//End While
               echo "</table>" ;
    }


   function updategroup($name,$id,$parentid,$uid){
        $message="";
        $query="UPDATE `group` SET name='$name' AND parentid=$parentid WHERE gid=$id AND uid=$uid";
        mysql_query('SET NAMES UTF8');
        $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);
        if(mysql_affected_rows())
            $message="ويرايش با موفقيت انجام شد";
        else
            $message="ويرايشي انجام نشد!";

        return $message;

    }

    function delgroup($id,$uid){
        $message="";
        $query="DELETE FROM `group` Where gid=$id AND uid=$uid";
        $Result = mysql_query($query) or die(mysql_error() . "<br>SQL: " . $query);

        if( mysql_affected_rows()){
            $message="با موفقيت حذف شد";
        }else {
            $message="<p class=error>حذف نشد!<p> ";
        }
          return $message;
    }






?>