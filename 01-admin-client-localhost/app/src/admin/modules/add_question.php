<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

    require "db/questions_db.php";
	

    $quiz_id = util::GetKeyID("quiz_id", "?module=questions");

    $txtQsts="";
	$answers_count=4;
	if(isset($_GET["answercount"]))
		$answers_count=$_GET["answercount"];
    $selected = "1";    
	$txtPoint = 1;
	$vTotMarks = 50;
	$txtHeader = "Online Test";
	$queno = 0;
	
    if(isset($_GET["id"]) || isset($_GET["copyid"]))
    {
		if(isset($_GET["id"])) 
			$id = util::GetID("?module=questions");
		else
			$id = $_GET["copyid"];
        $rs_qsts=orm::Select("questions", array(), array("id"=>$id), "");

        if(db::num_rows($rs_qsts) == 0 ) header("location:?module=questions");

        $row_qsts=db::fetch($rs_qsts);
        $txtQsts = $row_qsts["question_text"];
        $txtPoint = $row_qsts["point"];        
        $txtHeader = $row_qsts["header_text"];
        $txtFooter = $row_qsts["footer_text"];
        $selected = $row_qsts["question_type_id"];

        $rs_grp=orm::Select("question_groups", array(), array("question_id"=>$id), "added_date");
        $row_grp = db::fetch($rs_grp);

        $txtGroupName=$row_grp["group_name"];

        $rs_ans = orm::Select("answers", array(), array("group_id"=>$row_grp["id"]), "priority");

        $answers_count = db::num_rows($rs_ans);
		if(isset($_GET["answercount"]))
			$answers_count=$_GET["answercount"];
		
        $i = 0;
        while($row_ans=db::fetch($rs_ans))
        {
            $i++;
            ${"txtChoise".$i} = $row_ans["answer_text"];
            ${"txtCrctAnswer".$i} = $row_ans["correct_answer_text"];
            ${"ans_selected".$i} = $row_ans["correct_answer"]=="1" ? "checked" : "";
        }
		$txtFooter1 = $txtFooter;
		if(isset($_GET["copyid"])){
			$row_Qs=db::GetResultsAsArray("select count(*) count_val from questions where quiz_id=".$quiz_id); 
			$queno = ($row_Qs[0][0]+1);
			$txtFooter1 = "Copy|".$queno."/".$vTotMarks;
			
		}			
    }else{
		$txtFooter = "Question x of y";
		$row_Qs=db::GetResultsAsArray("select count(*) count_val from questions where quiz_id=".$quiz_id); 
		$queno = ($row_Qs[0][0]+1);
		$txtFooter = $queno."/".$vTotMarks;
		$txtFooter1 = $txtFooter;
		$txtFooter = "";
		//print "<pre>";print_r($row_Qs);print "</pre>";
	}
	//$txtHeader = $txtHeader.$_SESSION['QT'];
	$rs_quiz=orm::Select("quizzes", array(), array("id"=>$quiz_id), ""); $row_quiz=db::fetch($rs_quiz);	
	$rs_cat=orm::Select("cats", array(), array("id"=>$row_quiz['cat_id']), ""); $row_cat=db::fetch($rs_cat);
	
    $results = orm::Select("question_types", array(), array() , "id");
    $temp_options = webcontrols::GetOptions($results, "id", "question_type",$selected);


  //  $val = new validations("btnSave");
  //  $val->AddValidator("txtName", "empty", "Name cannot be empty","");




    if(isset($_POST["btnSave"]))
    {
        $db = new db();
        $db->connect();
        $db->begin();        
        try
        {
            $question_type=$_POST["drpTemplate"];
            if(!isset($_GET["id"]))
            {
                $query = orm::GetInsertQuery("questions", array("question_text"=>trim($_POST["txtQstsEd"]),
                                                   "question_type_id"=>$_POST["drpTemplate"],
                                                   "priority"=>"(select ifnull(max(priority)+1,1) from questions where quiz_id=$quiz_id)",
                                                   "quiz_id"=>$quiz_id,
                                                   "point"=>$_POST["txtPoint"],
                                                   "parent_id"=>"0",
                                                   "footer_text"=>$_POST["txtFooter"],
                                                   "header_text"=>$_POST["txtHeader"]
                                                   ));
                $db->query($query);
                $question_id = $db->last_id();
                $db->query(questions_db::UpdatePriorityQuery($quiz_id, $question_id));
            }
            else
            {
                 $query = orm::GetUpdateQuery("questions", array("question_text"=>trim($_POST["txtQstsEd"]),
                                                   "question_type_id"=>$_POST["drpTemplate"],
                                                   "point"=>$_POST["txtPoint"],
                                                   "footer_text"=>$_POST["txtFooter"],
                                                   "header_text"=>$_POST["txtHeader"]
                                                   ),
                                                   array("id"=>$id)
                                            );
                $db->query($query);
                $question_id = $id;
                $db->query(questions_db::GetAnswerDeleteQuery($question_id));
                $db->query(questions_db::GetGroupDeleteQuery($question_id));
            }
            
            

            if($question_type==0)
            {
                $group_name= trim($_POST["txtMultiGroupName"]);
            }
            else if($question_type==1)
            {
                $group_name= trim($_POST["txtOneGroupName"]);
            }
            else if($question_type==3)
            {
                $group_name= trim($_POST["txtAreaGroupName"]);
            }
            else 
            {
                $group_name= trim($_POST["txtMultiTextGroupName"]);
            }
            
            $query= orm::GetInsertQuery("question_groups", array("group_name"=>$group_name,
                                                                 "show_header"=>$group_name =="" ? 0 : 1,
                                                                 "question_id"=>$question_id,
                                                                 "parent_id"=>"0"
                                                            ));

            $db->query($query);
            $group_id = $db->last_id();

            for($i=1;;$i++)
            {                

                if($question_type==0)
                {
                    if(!isset($_POST["txtMulti".$i])) break;

                    $answer_text = trim($_POST["txtMulti".$i]);
                    $correct_answer = isset($_POST["chkMulti".$i]) ==true ? 1 : 0;
                    $correct_answer_text="";
                }
                else if($question_type==1)
                {
                    if(!isset($_POST["txtOne".$i])) break;

                    $answer_text = trim($_POST["txtOne".$i]);
                    $correct_answer = isset($_POST["rdOne"]) ==true && $_POST["rdOne"]==$i? 1 : 0;
                    $correct_answer_text="";
                }
                else if($question_type==3)
                {
                    if(!isset($_POST["txtArea".$i])) break;

                    $answer_text = "";
                    $correct_answer = 0;
                    $correct_answer_text=trim($_POST["txtArea".$i]);
                }
                else 
                {
                    if(!isset($_POST["txtMultiText".$i])) break;

                    $answer_text = trim($_POST["txtMultiText".$i]);
                    $correct_answer = 0;
                    $correct_answer_text=trim($_POST["txtMultiCrctAnswer".$i]);
                }
                

                $query=orm::GetInsertQuery("answers", array("group_id"=>$group_id,
                                                            "answer_text"=>$answer_text,
                                                            "correct_answer"=>$correct_answer ,
                                                            "correct_answer_text"=>$correct_answer_text ,
                                                            "priority"=>"1",
                                                            "answer_pos"=>"1",
                                                            "parent_id"=>"0",
                                                            "control_type"=>"1",
                                                            "answer_parent_id"=>"0"));

                                                            //"priority"=>"(select ifnull(max(priority)+1,1) from answers where group_id=$group_id)"
                
                $db->query($query);
            }

            $db->commit();
			if($_SESSION['QT'] === 1)
				header("location:?module=questions&quiz_id=$quiz_id&i=".$i);
			else
				header("location:?module=disp_questions&quiz_id=$quiz_id&i=".$i);
        }
        catch(Exception $e)
        {
            //echo $e->getMessage();
            $db->rollback();
        }

        $db->close_connection();

    }
    
    include_once "ckeditor/ckeditor.php";
	
    $CKEditor = new CKEditor();
    $CKEditor->basePath = 'ckeditor/';

   function desc_func()
   {
        return "Add/Edit question";
   }

?>
