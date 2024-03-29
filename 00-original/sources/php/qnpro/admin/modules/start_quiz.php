<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("2");

 require "grid.php";
 require "db/questions_db.php";
 require "db/asg_db.php";
 require "qst_viewer.php";

 $app_display = "";
 $msg_display = "none";
 $timer_display ="";
 $msg_text = "";
 $qst_html ="";
 $timer_script = "";
 $timer_display = "none";
 $pager_html="";
 $pager_display="";

 $emulate_goto=true;
 while($emulate_goto==true) { // emulating goto operator 

 $user_id = $_SESSION['user_id'];
 $asg_id = util::GetID("?module=active_assignments");
 $_SESSION['asg_id']=$asg_id;

 $active_asg = asgDB::GetActAsgByUserID($user_id, $asg_id);
 $asg_num = db::num_rows($active_asg);
 if($asg_num==0)
 {
     DisplayMsg("error","You don't have access to this quiz/survey",false);
     break;
 }

 $asg_row = db::fetch($active_asg);
 $status = intval($asg_row['user_quiz_status']);
 $user_quiz_id = $asg_row['user_quiz_id'];
 $_SESSION['user_quiz_id']=$user_quiz_id;
 $quiz_type = $asg_row['quiz_type'];
  
 if($status==0)
 {
     $date = util::Now(); 
     $user_quiz_id=db::exec_insert(orm::GetInsertQuery("user_quizzes", array("assignment_id"=>$asg_id,
                                                            "user_id"=>$user_id,
                                                            "status"=>"1",
                                                            "added_date"=>$date,
                                                            "success"=>"0"
                                                       )));     
 }
 else if($status>=2)
 {     
    DisplayMsg("error"," You have already finished this quiz/survey",false);
    break;
 }

 if($quiz_type=="1") // if survey
 {
    $timer_display= "";
    $ended=ShowTimer($status,$asg_row);
    if($ended==true) break;
 }

 $page = "?module=start_quiz&id=".$asg_id ;
 $qst_viewer = new qst_viewer($page);
 $qst_viewer->user_quiz_id=$user_quiz_id;
 $priority = $qst_viewer->GetPriority(); 

 if(isset($_POST['btnNext']))
 {
     UpdateValues();
     if($_POST['finish_quiz']=="1") break;
     $priority =$qst_viewer->GetNextPriority();     
 }
 if(isset($_POST['btnPrev']))
 {
    $priority =$qst_viewer->GetPrevPriority();
 }

 if(isset($_POST['load_question']))
 {
    $priority = $_POST['load_priority'];    
 }

 $qst_query = questions_db::GetQuestionsByPriority($priority, $asg_id, $user_id);
 $row_qst = db::fetch(db::exec_sql($qst_query));

 //echo $qst_query;

 if($priority==1)
 {
     $qst_viewer->show_prev=false;
 }
 else if($row_qst['next_priority']==-1)
 {
     $qst_viewer->show_next=false;
     $qst_viewer->show_finish=true;
 }
 //echo $qst_query; 
 $qst_viewer->BuildQuestionWithResultset($row_qst);
 $qst_html = $qst_viewer->html;
 

// $row_num = db::num_rows($qst_results);

// if($row_num==0)
 //{
//    DisplayError("You don't have access to this quiz/survey");
 //}
 
 $pager_html = GetPager();

 if(isset($_POST['data_post']))
 {
    echo $qst_html."[{sep}]".$pager_html;
 }

 $emulate_goto =false;

 }


 function UpdateValues()
 {
    global $user_quiz_id;
    
    $db = new db();
    $db->connect();
    $db->begin();

    try
    {
     $db->query(orm::GetDeleteQuery("user_answers", array("user_quiz_id"=>$user_quiz_id , "question_id"=>intval($_POST['qstID']))));
     $date = date('Y-m-d H:i:s');
     switch ($_POST['qst_type']) {

         case 0 : // if checkbox
             $chks = explode(";|",$_POST['post_data']);
             for($i=0;$i<sizeof($chks);$i++)
             {
                 $chk_value=trim($chks[$i]);
                 if($chk_value=="") continue;

                 $chk_value = intval($chk_value);
                 $query = orm::GetInsertQuery("user_answers", array("user_quiz_id"=>$user_quiz_id,
                                                                    "question_id"=>intval($_POST["qstID"]),
                                                                    "answer_id"=>$chk_value,
                                                                    "user_answer_id"=>$chk_value,
                                                                    "added_date"=>$date
                                                              ));
                 $db->query($query);
             }
         break;
         case 1 : //if radio button
                 $chk_value=trim($_POST['post_data']);
                 if($chk_value!="")
                 {
                    $chk_value = intval($chk_value);
                    $query = orm::GetInsertQuery("user_answers", array("user_quiz_id"=>$user_quiz_id,
                                                                    "question_id"=>intval($_POST["qstID"]),
                                                                    "answer_id"=>$chk_value,
                                                                    "user_answer_id"=>$chk_value,
                                                                    "added_date"=>$date
                                                             ));
                    $db->query($query);
                 }
         break ;
         case 3 : // if free text area
                 $free_vals = explode(";|",$_POST['post_data']);
                 $answer_id=$free_vals[0];
                 $answer_text=$free_vals[1];
                 //if($chk_value!="")
                 //{                    
                    $query = orm::GetInsertQuery("user_answers", array("user_quiz_id"=>$user_quiz_id,
                                                                    "question_id"=>intval($_POST["qstID"]),
                                                                    "answer_id"=>$answer_id,
                                                                    "user_answer_text"=>$answer_text,
                                                                    "added_date"=>$date
                                                             ));
                    $db->query($query);
                // }
        break ;
        case 4 : // if muti text
             $txts = explode(";|",$_POST['post_data']);
             for($i=0;$i<sizeof($txts);$i++)
             {
                 $txt_key_value=trim($txts[$i]);                 
                 if($txt_key_value=="") continue;

                 $txt_exp=explode(":|",$txt_key_value);
                 $txt_key = intval($txt_exp[0]);
                 $txt_value = $txt_exp[1];
                 
                 if(trim($txt_key)=="" || trim($txt_value)=="") continue ;

                 $query = orm::GetInsertQuery("user_answers", array("user_quiz_id"=>$user_quiz_id,
                                                                    "question_id"=>intval($_POST["qstID"]),
                                                                    "answer_id"=>$txt_key,
                                                                    "user_answer_text"=>$txt_value,
                                                                    "added_date"=>$date
                                                              ));
                 $db->query($query);
             }
         
         break;

     }

     $db->commit();

     if($_POST['finish_quiz']=="1")
     {                  
          $row=asgDB::UpdateUserQuiz($user_quiz_id,2);
          $msg = GetQuizResults($row);
          DisplayMsg("warning",$msg,true);
     }     

     $db->commit();

    }
    catch(Exception $e)
    {
        echo $e->getMessage();
        $db->rollback();
    }
    $db->close_connection();
    
 }



 function GetQuizResults($row)
 {
    global $quiz_type;
    
    $msg = "Finished . Thank you . <br>";    
    /*if($row['show_results']=="1" && $quiz_type=="1")
    {*/
        $total = $row['total_point'];
        if($row['results_mode']=="2") $results_mode = $row['total_perc']." %";        

        $msg.="$total out of ".$row['pass_score']." .";
        $msg.="<br>";           

        /*if($row['quiz_success']=="1")
        {
            $msg.="You passed exam successfully!";
        }
        else
        {
            $msg.="Sorry, you didn't pass exam successfully";
        }*/
    /* }    */
    return $msg;
 }

 function DisplayMsg($type,$msg,$isajax)
 {
     if(isset($_POST['ajax'])) $isajax=true;
     
     if($isajax==true)
     {
        if($type=="error")
        {
            echo "error:".$msg;
        }
        else if($type=="warning")
        {
             echo "warni:".$msg;
        }
        else
        {
             echo $msg;
        }
     }
     else
     {
        global $app_display,$msg_display,$msg_text,$timer_display,$pager_display;
        $app_display="none";
        $msg_display = "";
        $msg_text=$msg;
        $timer_display="none";
        $pager_display="none";
     }

    // echo $msg;

 }

 function ShowTimer($status,$row)
 {
	 /* M */
     $ended = false;
     $start_date =$row['uq_added_date'];
     if($status=="0") $start_date = util::Now();

	 $vtnow = util::Now();	
     $diff = abs(strtotime($vtnow) - strtotime($start_date));

     $total_minutes = intval($diff/60);
	 $vquiz_time = intval($row['quiz_time']);
     $minuets = $vquiz_time - $total_minutes -1;
     $seconds = 60-($diff%60);
	/* End M */
	
     if($total_minutes>=intval($row['quiz_time']))
     {
        global $user_quiz_id;
        $row_results=asgDB::UpdateUserQuiz($user_quiz_id,3);
        $msg="Time ended <br>";
        $msg.=GetQuizResults($row_results);        
        DisplayMsg("message",$msg,false);
        $ended=true;
     }
     else
     {      
         global $timer_script;
         $timer_script="<script language=javascript>
				/* M */
				var vServStart = new Date(\"$start_date\");
				var vServNow = new Date(\"$vtnow\");
				var vCliNow = new Date();				
				var vdDtsec = Math.abs(vServNow.getTime() - vServStart.getTime()) / 1000;
				var vCliStart = new Date();
				vCliStart.setSeconds(vCliStart.getSeconds() - vdDtsec);
				var vdNowSec = Math.abs(vCliNow.getTime() - vCliStart.getTime()) / 1000;
				var vQzSecs = $vquiz_time * 60;
				/* End M */
				Init_Timer($minuets,$seconds);
				
				
				</script>";
     }
     return $ended;

 }

 function GetPager()
 {
      global $priority,$asg_id,$page;
      $res_qst=db::exec_sql(questions_db::GetQuestionsByAsgIdQuery($asg_id));
      if(db::num_rows($res_qst)==0) return "";
      $i=0;
      $pager_html = "";
      $finish = 0;
      while($row=db::fetch($res_qst))
      {
                  $i++;
                  $bgcolor="white";
                  if($priority==$row['priority'])
                  {
                     $bgcolor = "green";
                  }
                 $pager_html.= "<u><a style='cursor:pointer;background-color:$bgcolor' onmouseout='HideObject(\"tblTip\")' ".
                               " onmouseover='ShowQst(event.pageX, event.pageY ,".$row['priority'].")' onclick='LoadQst(\"$page\",$row[question_type_id],$row[priority],$row[id],$finish)'>".$i."</a></u>&nbsp;";
      }

      return $pager_html."&nbsp;&nbsp;";
 }

 function desc_func()
 {
        return "";
 }

?>
