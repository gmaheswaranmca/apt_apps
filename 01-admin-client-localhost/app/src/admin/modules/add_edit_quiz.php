<?php

access::allow("1");

    require "grid.php";    
    require "db/quiz_db.php";    
	require "db/cats_db.php";
	require "lib/introText.php";

    $val = new validations("btnSubmit");
    $val->AddValidator("txtName", "empty", "Name cannot be empty","");
    $val->AddValidator("txtDesc", "empty", "Description cannot be empty","");
    

    $txtIntroText=introText(); //lib/introText.php
    $selected = "-1";
	$chkShowIntro = "checked";
	
    if(isset($_GET["id"]))
    {
		
		$val->AddValidator("drpCats", "notequal", "Please, select category", "-1");
        $id = util::GetID("?module=quizzes");
        $rs_quiz=orm::Select("quizzes", array(), array("id"=>$id), "");
        
        if(db::num_rows($rs_quiz) == 0 ) header("location:?module=quizzes");

        $row_quiz=db::fetch($rs_quiz);
        $txtName = $row_quiz["quiz_name"];
        $txtDesc = $row_quiz["quiz_desc"];
        $chkShowIntro = $row_quiz["show_intro"] == "1" ? "checked" : "";
        $txtIntroText = $row_quiz["intro_text"];
        $selected = $row_quiz["cat_id"];        
    }

    $results = orm::Select("cats", array(), array(),"");
    $cat_options = webcontrols::GetOptions($results, "id", "cat_name", $selected);

    if(isset($_POST["btnSubmit"]) && $val->IsValid())
    {        
     
        $date = date('Y-m-d H:i:s');
        if(!isset($_GET["id"]))
        {
			$catname = $_POST["txtName"];
			$sql = "insert into cats(cat_name) values('$catname')";
			$odb = new db();
			$odb->connect();
			$res = $odb->insert_query($sql);			
			$iid = $res;
            orm::Insert("quizzes", array(
                                "cat_id"=>$iid,
                                "quiz_name"=>$_POST["txtName"] ,
                               "quiz_desc"=>$_POST["txtDesc"],
                               "added_date"=>$date,
                                "show_intro"=>isset($_POST["chkShowIntro"]) ? 1:0,
                                "intro_text"=>$_POST["editor1"]
                                ));
        }
        else
        {
            orm::Update("quizzes", array(
                                "cat_id"=>$_POST["drpCats"],
                                "quiz_name"=>$_POST["txtName"] ,
                               "quiz_desc"=>$_POST["txtDesc"],
                                "show_intro"=>isset($_POST["chkShowIntro"]) ? 1:0,
                                "intro_text"=>$_POST["editor1"]
                                ) ,
                                array("id"=>$id)
                        );
        }
        header("location:?module=quizzes");
    }


    include_once "ckeditor/ckeditor.php";     
    $CKEditor = new CKEditor();
    $CKEditor->basePath = 'ckeditor/';


    function desc_func()
    {
        return "Add/Edit quiz";
    }

/*
    if(isset($_POST["ajax"]))
    {
         
    }
 */
?>
