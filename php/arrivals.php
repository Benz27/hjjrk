<?php

session_start();
include("conn.php");
include("read.php");

function insert_arrv(){
    $link=$GLOBALS['link'];
date_default_timezone_set("Asia/Manila");
    $query=array();
    $columns=json_decode($_POST['columns'],true);
    $values=json_decode($_POST['values'],true);
    $tables=json_decode($_POST['tables'],true);
    $types=json_decode($_POST['types'],true);
    
    $tcount=count($tables);
    $a_id=user_id_gen();
    for($x=0;$x<$tcount;$x++){
        $query_string="";
        $columns_string="";
        $values_string="";

        $columns_string.="a_id,user_id,";
        $values_string.=strval($a_id).",".$_SESSION['user_id'].",";


        for($y=0;$y<count($columns[$x]);$y++){
            $column=$columns[$x][$y];
            $value=$values[$x][$y];
            if($y!=count($columns[$x])-1){
                $columns_string.="$column,";
                if($types[$x][$y]=="string" || $types[$x][$y]=="date"){
                    $values_string.="'$value',";
                }else{
                    $values_string.="$value,";
                }
            }else{
                $columns_string.="$column";
                if($types[$x][$y]=="string" || $types[$x][$y]=="date"){
                    $values_string.="'$value'";
                }else{
                    $values_string.="$value";
                }
            }
        }

            $query_string="INSERT INTO $tables[$x] (".$columns_string.",submitted,status) values (".$values_string.",'".date('Y-m-d H:i:s')."',0)";


        array_push($query, $query_string);
    }


    function user_id_gen(){
        $user_id=mt_rand(1000000, 9999999);    
        $sql="SELECT a_id FROM arrivals where a_id=$user_id"; 
        $result=mysqli_query($GLOBALS['link'], $sql);     
        if($result && mysqli_num_rows($result) > 0){      
            $user_data=mysqli_fetch_assoc($result);      
            while($user_id ==  $user_data['user_id']){    
                $user_id=mt_rand(1000000,9999999);     
            }
        }

        return $user_id;
    }

                $sql=$query[0]; 
                if ($link->query($sql) === TRUE) {
    
                    echo 1; 

                }else{
        
                    $errmsg="Error : " . $link->error;
                    echo $errmsg;
                }

                

} 





function inser_hsf()
{
    $link=$GLOBALS['link'];
    $columns=json_decode($_POST['qts'],true);
    $values=json_decode($_POST['values'],true);

    $query="";

    for($x=0;$x<count($columns);$x++){
        if($x!=count($columns)-1){

                $query.="$values[$x],";
            
        }else{

                $query.="$values[$x]";

        }
    }

    $user_id =  $_SESSION["user_id"];
    $gen_id=user_id_gen();

    $sql = "INSERT INTO ans_table values($gen_id, $user_id, $query)";
    if ($link->query($sql) === TRUE) {
        echo 1;
    } else {
        echo "Error : " . $link->error;
    }

}