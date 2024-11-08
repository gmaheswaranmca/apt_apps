<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

 require "grid.php";
 require "db/users_db.php";
 require "db/asg_db.php";
 require "db/quiz_db.php";


 $val = new validations("btnSave");
 $val->AddValidator("drpCats", "notequal", "Please, select category", "-1");
 $val->AddValidator("drpTests", "notequal", "Please, select test", "-1");
 $val->AddValidator("txtSuccessP", "empty", "Please, enter success point","");
 $val->AddValidator("txtTestTime", "empty", "Please, enter test time","");
 $val->AddValidator("txtSuccessP", "numeric", "Please, enter success point in numeric format","");
 $val->AddValidator("txtTestTime", "numeric", "Please, enter test time in numeric format","");


$selected = "-1";
$selected_test = "-1";
$selected_type = "-1";
$selected_showres = "-1";
$selected_results = "-1";
$local_user_ids = array();
$imp_user_ids= array();

if(isset($_GET["id"]) || isset($_GET["copyid"]))
{
		if(isset($_GET["id"])) 
			$id = util::GetID("?module=assignments");
		else
			$id = $_GET["copyid"];
        
        $rs_asg=asgDB::GetAsgQueryById($id);

        if(db::num_rows($rs_asg) == 0 ) header("location:?module=assignments");

        $row_asg=db::fetch($rs_asg);

        $selected = $row_asg["cat_id"];
        $selected_test= $row_asg["org_quiz_id"];
        $copied_quiz_id= $row_asg["quiz_id"];
        $selected_type = $row_asg["quiz_type"];
        $selected_showres= $row_asg["show_results"];
        $selected_results =$row_asg["results_mode"];
        $txtSuccessP = $row_asg["pass_score"];
        $txtTestTime = $row_asg["quiz_time"];
       
        $local_user_ids=db::GetResultsAsArrayByColumn(orm::GetSelectQuery("assignment_users", array(), array("assignment_id"=>$id, "user_type"=>"1"), ""), "user_id");
        $imp_user_ids=db::GetResultsAsArrayByColumn(orm::GetSelectQuery("assignment_users", array(), array("assignment_id"=>$id, "user_type"=>"2"), ""), "user_id");

   //     for($i=0;$i<sizeof($local_user_ids);$i++)
   //     {
   //         echo $local_user_ids[$i]["user_id"];
 //       }

}

$type_options = webcontrols::BuildOptions(array("1"=>"Quiz", "2"=>"Survey"), $selected_type);
$showres_options = webcontrols::BuildOptions(array("1"=>"Yes", "2"=>"No"), $selected_showres);
$result_options = webcontrols::BuildOptions(array("1"=>"Point", "2"=>"Percent"), $selected_results);

$results = orm::Select("cats", array(), array(),"");
$cat_options = webcontrols::GetOptions($results, "id", "cat_name", $selected);


$hedaers = array("&nbsp;");//,"Login",  "Name","Surname");
$columns = array("UserName"=>"text");//"UserName"=>"text", "Name"=>"text","Surname"=>"Surname");

$grd = new grid($hedaers,$columns, "index.php?module=add_assignment");
$grd->delete=false;
$grd->edit=false;
$grd->checkbox=true;
$grd->id_column="UserID";
$grd->selected_ids=$local_user_ids;

$query = users_db::GetUsersQuery();
$grd->DispArItems($query);//DrowTable
$grid_html = $grd->table;

$hedaers_imp = array("&nbsp;");//,"Login",  "Name","Surname");
$columns_imp = array("UserName"=>"text");//, "Name"=>"text","Surname"=>"Surname");

$grd_imp = new grid($hedaers_imp,$columns_imp, "index.php?module=add_assignment");
$grd_imp->delete=false;
$grd_imp->edit=false;
$grd_imp->checkbox=true;
$grd_imp->id_column="UserID";
$grd_imp->identity="imp";
$grd_imp->selected_ids=$imp_user_ids;

$query_imp = users_db::GetImportedUsersQuery();
$grd_imp->DispArItems($query_imp);
$imported_grid_html = $grd_imp->table;


if(isset($_POST["btnSave"]) && $val->IsValid())
{
    $db = new db();
    $db->connect();
    $db->begin();

    $selected_quiz_type=$_POST["drpType"];
    $selected_show_res = $_POST["drpShowRes"];
    if($selected_quiz_type=="2") $selected_show_res="2";
    try
    {
        $org_quiz_id=$_POST["drpTests"];
        if(!isset($_GET["id"]))
        {
            //$quiz_id = CopyQuiz($org_quiz_id);
			$quiz_id = $org_quiz_id;
            $query = orm::GetInsertQuery("assignments", array("quiz_id"=>$quiz_id,
                                                   "results_mode"=>$_POST["drpResultsBy"],
                                                   "added_date"=>util::Now(),
                                                   "quiz_time"=>trim($_POST["txtTestTime"]),
                                                   "show_results"=>$selected_show_res,
                                                   "org_quiz_id"=>$org_quiz_id,
                                                   "pass_score"=>$_POST["txtSuccessP"],
                                                   "quiz_type"=>$selected_quiz_type,
                                                    "quiz_type"=>$_POST["drpType"],
                                                    "status"=>"0"
                                                   ));
            $db->query($query);
            $asg_id = $db->last_id();
        }
        else
        {
             //global $copied_quiz_id;             
             //$db->query(quizDB::DeleteQuizByIdQuery($copied_quiz_id));             
             //$quiz_id = CopyQuiz($org_quiz_id);
			 $quiz_id = $org_quiz_id;
             $query = orm::GetUpdateQuery("assignments", array("quiz_id"=>$quiz_id,
                                                   "results_mode"=>$_POST["drpResultsBy"],
                                                   //"added_date"=>util::Now(),
                                                   "quiz_time"=>trim($_POST["txtTestTime"]),
                                                    "org_quiz_id"=>$org_quiz_id,
                                                   "show_results"=>$selected_show_res,
                                                   "pass_score"=>$_POST["txtSuccessP"],
                                                   "quiz_type"=>$selected_quiz_type,
                                                    "quiz_type"=>$_POST["drpType"]
                                                   // "status"=>"1" ,
                                                   ) ,
                                                   array("id"=>$id)
                                         );
            $db->query($query);
            $asg_id = $id;
            
            $db->query(orm::GetDeleteQuery("assignment_users", array("assignment_id"=>$asg_id)));
            //$db->query(questions_db::GetGroupDeleteQuery($question_id));
        }

        $chkgrd=$_POST['chkgrd'];
        while (list ($key,$val) = @each ($chkgrd))
        {
            $query_lcl = orm::GetInsertQuery("assignment_users", array("assignment_id"=>$asg_id,
                                                                       "user_type"=>"1",
                                                                       "user_id"=>$val
                                            ));
            $db->query($query_lcl);
        }

        $chkgrdimp=$_POST['chkgrdimp'];
        while (list ($key,$val) = @each ($chkgrdimp))
        {
            $query_imp = orm::GetInsertQuery("assignment_users", array("assignment_id"=>$asg_id,
                                                                       "user_type"=>"2",
                                                                       "user_id"=>$val
                                            ));
            $db->query($query_imp);
        }

        $db->commit();
        header("location:?module=assignments&asg_id=$asg_id");

    }
    catch(Exception $e)
    {
        echo $e->getMessage();
        $db->rollback();
    }
    $db->close_connection();
}



if(isset($_POST["ajax"]))
{
         if(isset($_POST["fill_tests"]))
         {             
            $cat_id=$_POST["cat_id"];            
            $results_test = orm::Select("quizzes", array(), array("cat_id"=>$cat_id,"parent_id"=>"0"),"");
            $tests_drop = webcontrols::GetDropDown("drpTests",$results_test, "id", "quiz_name", $selected_test);
            echo $tests_drop;
         }
}

function CopyQuiz($quiz_id)
{
      global $db;
      $last_quiz_id=$db->insert_query("insert into quizzes (cat_id,quiz_name,quiz_desc,added_date,parent_id,show_intro,intro_text) select cat_id,quiz_name,quiz_desc,added_date,id,show_intro,intro_text from quizzes where parent_id=0 and id=$quiz_id");

      $res_qst = $db->query(orm::GetSelectQuery("questions", array(), array("quiz_id"=>$quiz_id,"parent_id"=>"0"), ""));

      $q = 0;
      while($row_qst=$db->fetch($res_qst))
      {
          $q++;
          $query = orm::GetInsertQuery("questions", array("question_text"=>$row_qst['question_text'],
                                                          "question_type_id"=>$row_qst['question_type_id'],
                                                          "priority"=>$q,
                                                          "quiz_id"=>$last_quiz_id,
                                                          "point"=>$row_qst['point'],
                                                          "parent_id"=>$row_qst['id'],
                                                          "added_date"=>util::Now(),
                                                          "header_text"=>$row_qst['header_text'],
                                                          "footer_text"=>$row_qst['footer_text'],
                                                          "help_image"=>$row_qst['help_image'],
                                    ));
          
          $last_qst_id=$db->insert_query($query);

          $res_grp = $db->query(orm::GetSelectQuery("question_groups", array(), array("question_id"=>$row_qst['id'],"parent_id"=>"0"), ""));

          while($row_grp=$db->fetch($res_grp))
          {
              $query = orm::GetInsertQuery("question_groups", array("group_name"=>$row_grp['group_name'],
                                                                    "show_header"=>$row_grp['show_header'],
                                                                    "question_id"=>$last_qst_id,
                                                                    "parent_id"=>$row_grp['id'],
                                                                    "added_date"=>util::Now()

              ));
              $last_grp_id=$db->insert_query($query);

              $res_ans = $db->query(orm::GetSelectQuery("answers", array(), array("group_id"=>$row_grp['id'],"parent_id"=>"0"), ""));

              while($row_ans=$db->fetch($res_ans))
              {
                  $query = orm::GetInsertQuery("answers", array("group_id"=>$last_grp_id,
                                                                    "answer_text"=>$row_ans['answer_text'],
                                                                      "correct_answer"=>$row_ans['correct_answer'],
                                                                      "priority"=>$row_ans['priority'],
                                                                      "correct_answer_text"=>$row_ans['correct_answer_text'],
                                                                      "answer_pos"=>$row_ans['answer_pos'],
                                                                      "parent_id"=>$row_ans['id'],
                                                                      "control_type"=>$row_ans['control_type'],
                                                                      "answer_parent_id"=>$row_ans['answer_parent_id'],
                                                                      "text_unit"=>$row_ans['text_unit']
                  ));
                  $last_ans_id=$db->insert_query($query);
              }

          }

      }

      return $last_quiz_id;

}

function desc_func()
{
        return "Add assignment";
}



?>
