<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

    require "grid.php";
    require "db/questions_db.php";
	
	$_SESSION['QT'] = 1;
    $quiz_id = util::GetKeyID("quiz_id", "index.php?module=quizzes");
	
    $hedaers = array("Question", "Type", "Point","Added date","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
    $columns = array("question_text"=>"text","question_type"=>"text" ,"point"=>"text","added_date"=>"short date");
	
    $grd = new grid($hedaers,$columns, "index.php?module=questions&quiz_id=$quiz_id");
	$grd->edit_link="index.php?module=add_question&quiz_id=$quiz_id";	
	
			
    $grd->id_links=(array(
		"Copy"=>"?module=add_question&quiz_id=$quiz_id",
		"2"=>"?module=add_question&quiz_id=$quiz_id&answercount=2",
		"3"=>"?module=add_question&quiz_id=$quiz_id&answercount=3",
		"4"=>"?module=add_question&quiz_id=$quiz_id&answercount=4",
		"5"=>"?module=add_question&quiz_id=$quiz_id&answercount=5",
		"6"=>"?module=add_question&quiz_id=$quiz_id&answercount=6",
		"7"=>"?module=add_question&quiz_id=$quiz_id&answercount=7",
		"8"=>"?module=add_question&quiz_id=$quiz_id&answercount=8"
		));
	$grd->id_link_key="copyid";
	
	
    $grd->commands=array("Up"=>"up", "Down"=>"down");

    if($grd->IsClickedBtnDelete())
    {
        questions_db::DeleteQuestion($grd->process_id);        
    }

    if($grd->IsClickedBtn("up"))
    {        
        questions_db::MoveQuestion("up", $grd->process_id);        
    }

    if($grd->IsClickedBtn("down"))
    {
        questions_db::MoveQuestion("down", $grd->process_id);
    }

    $query = questions_db::GetQuestionsQuery1($quiz_id);
	
    $grd->DrowTable($query);
    $grid_html = $grd->table;

    if(isset($_POST["ajax"]))
    {
         echo $grid_html;
    }

    function desc_func()
    {
        return "Questions";
    }

?>