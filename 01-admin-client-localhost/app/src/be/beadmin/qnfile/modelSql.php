<?php 
	if(!isset($RUN)) exit(); 
class QnFileSql{

    /* Qz */

	/* Read	*/

	/**/
    public $sqlQueryTestPaperActive = 
"SELECT q.id quiz_id, q.quiz_name, q.quiz_desc about_quiz, count(qn.id) qn_count
FROM quizzes q
	INNER JOIN questions qn ON(q.id = qn.quiz_id) 
GROUP BY q.id"; 	
	
    /**/
    public $sqlQueryUserTestTakingPaper = 
"SELECT q.id quiz_id, q.quiz_name, q.quiz_desc about_quiz, count(qn.id) qn_count, q.intro_text, qrul.rule
FROM quizzes q
INNER JOIN apt_tp_rule qrul ON(q.id = qrul.tp_id)
	INNER JOIN questions qn ON(q.id = qn.quiz_id)
WHERE (q.id = :p_quiz_id)
GROUP BY q.id"; 	
	
    /**/
    public $sqlQueryUTTPQuestion = 
"SELECT qn.quiz_id,qn.id question_id,qn.question_text,
    CONCAT('[',GROUP_CONCAT(CONCAT('{\"id\":',qo.id,',\"option\":\"', replace(replace(qo.answer_text,'\\\\','\\\\\\\\'),'\"','\\\\\"'),'\"}')), ']') options,
    MAX(CASE WHEN qo.correct_answer=1 THEN qo.id ELSE 0 END) option_top
FROM questions qn
    INNER JOIN  question_groups qq ON (qn.id=qq.id)
    INNER JOIN  answers qo ON (qq.id=qo.group_id)
WHERE qn.quiz_id=:p_quiz_id
GROUP BY qn.id"; 
	
    /**/
    public $sqlQn = 
"SELECT qn.quiz_id,qn.id question_id,qn.question_text
FROM questions qn
WHERE qn.id=:p_question_id";
	
    /**/
    public $sqlQnOpt = 
"SELECT qo.id, qo.answer_text option_text, qo.correct_answer is_answer
FROM question_groups qq
  INNER JOIN  answers qo ON (qq.id=qo.group_id)
WHERE qq.qn_id=:p_question_id";
	
    /*Write	*/		
	/**/
    public $UpdateQn = "UPDATE questions SET question_text=:p_question_text WHERE id=:p_question_id"; 
	
    /**/
    public $UpdateQnOpt = "UPDATE answers SET answer_text=:p_option_text,correct_answer=:p_is_answer WHERE id=:p_option_id"; 
	
    /**/
    public $UpdateQuiz = "UPDATE quizzes SET intro_text=:p_instruction_text WHERE id=:p_quiz_id"; 
	
    /**/
    public $UpdateQuizV2 = "UPDATE quizzes SET 
quiz_name=:p_qz_name,  
quiz_desc=:p_qz_desc,
intro_text=:p_instruction_text WHERE id=:p_quiz_id"; 
	
    /**/
    public $UpdateQuizRule = "UPDATE apt_tp_rule SET rule=:p_rule_text WHERE tp_id=:p_quiz_id"; 

	/**/
    public $AddQz = "INSERT INTO quizzes(quiz_name,quiz_desc,intro_text, cat_id, 
	added_date, parent_id, show_intro) VALUES 
(:p_qz_name, :p_qz_desc, :p_instruction_text, :p_cat_id,
now(),0,1)"; 
	
    /**/
    public $AddCat = "INSERT INTO cats(cat_name) VALUES 
(:p_qz_name)";
	
    /**/
    public $AddQn = "INSERT INTO questions(question_text, quiz_id, priority,
	question_type_id, point, added_date, parent_id, header_text, footer_text) VALUES 
(:p_question_text, :p_quiz_id, :p_sno,
	1, 1,now(),0,'','')";
	
    /**/
    public $AddQnOpt = "INSERT INTO questions(answer_text, correct_answer, group_id,
	question_type_id, point, added_date, parent_id, header_text, footer_text) VALUES 
(:p_question_text, :p_quiz_id, :p_sno,
	1, 1,now(),0,'','')";

} 