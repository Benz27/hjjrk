<?php


include("conn.php");
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
        if($tables[0]=="admin"){  
            $columns_string.="user_id,";
            $values_string.=strval($a_id).",";
        }
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
        if($x==0){
            $query_string="INSERT INTO $tables[$x] (".$columns_string.",dte) values (".$values_string.",'".date('Y-m-d H:i:s')."')";
        }else{
            $query_string="INSERT INTO $tables[$x] (".$columns_string.") values (".$values_string.")";
        }

        array_push($query, $query_string);

    }


    function user_id_gen(){
        $user_id=mt_rand(1000000, 9999999);    
        $sql="SELECT user_id FROM user where user_id=$user_id"; 
        $result=mysqli_query($GLOBALS['link'], $sql);     
        if($result && mysqli_num_rows($result) > 0){      
            $user_data=mysqli_fetch_assoc($result);      
            while($user_id ==  $user_data['user_id']){    
                $user_id=mt_rand(1000000,9999999);     
            }
        }

        return $user_id;
    }

    // for($y=0;$y<count($columns);$y++){
    //     if($y!=count($columns)-1){
    //         $p1.="$columns[$y],";
    //         if($types[$y]=="string" || $types[$y]=="date"){
    //             $p2.="'$values[$y]',";
    //         }else{
    //             $p2.="$values[$y],";
    //         }
    //     }else{
    //         $p1.="$columns[$y]";
    //         if($types[$y]=="string" || $types[$y]=="date"){
    //             $p2.="'$values[$y]'";
    //         }else{
    //             $p2.="$values[$y]";
    //         }
    //     }
    // }


    // $dte=date('Y-m-d H:i:s');


    
    // $dtedisp=date('m/d/Y');
    // $dtenum=(date('Y')*10000)+(date('n')*100)+date('j');


                $sql=$query[0]; 
                if ($link->query($sql) === TRUE) {
    
                        $sql=$query[1];
                        if ($link->query($sql) === TRUE){
                            echo 1; 
                        }else{
                            $errmsg="Error : " . $link->error;
                            echo $errmsg;
                        }

                }else{
        
                    $errmsg="Error : " . $link->error;
                    echo $errmsg;
                }

                

              





