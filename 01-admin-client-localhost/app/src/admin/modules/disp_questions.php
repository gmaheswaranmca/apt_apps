<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

 require "grid.php";
 require "db/asg_db.php";
 require "db/questions_db.php";
 require "qst_viewer.php";
 $_SESSION['QT'] = 2;
 $id=util::GetKeyID("quiz_id", "?module=assignments");


 $asg_res01 = questions_db::GetQuizzQuestionsId($id);
 $asg_res = questions_db::GetQuizzQuestionsId($id);
 
 $uq  = 0;
 function get_question($row)
 {
     global $id,$uq;

     $qst_viewer = new qst_viewer("#");
     $qst_viewer->user_quiz_id=-1;

     $qst_viewer->show_prev=false;

     $qst_viewer->show_next=false;
     $qst_viewer->show_finish=false;
     $qst_viewer->SetReadOnly();
     $qst_viewer->show_correct_answers=true;
     
     $qst_viewer->BuildQuestionWithResultset($row);
     $qst_html = $qst_viewer->html;
     $uq++;
     return $qst_html;
 }

function desc_func()
{
        return "View details";
}

?>
