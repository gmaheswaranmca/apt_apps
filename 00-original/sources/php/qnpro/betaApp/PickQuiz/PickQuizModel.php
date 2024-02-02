<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include (realpath(ROOTDB.'../../gf/WrapperModel.php'));
			
	class PickQuizModel{
		public $wmd = NULL;		
		public $sql = NULL;
		public function __construct(){
			$this->wmd = new WrapperModel();
			$this->sql = new PickQuizModelSql();
		}public function QueryQns()	{			
			return $this->wmd->QueryNoParam(
					$this->sql->sqlQueryTestPaperActive
				);
		}
	}
	class PickQuizModelSql{
	public $QueryQns = 
"SELECT qz.id quiz_id, qz.quiz_name,
	  qn.id question_id, qn.question_text, qn.priority sort_by
FROM quizzes qz
  INNER JOIN questions qn ON(qz.id = qn.quiz_id)
  WHERE (qn.question_text like '%is any grammatical or idiomatic error in it%') OR
	(qn.question_text like '%Fill in the blanks with the most appropriate alternative%')OR
	(qn.question_text like '%Answer the following questions on the basis of the passage given below%')OR
	(qn.question_text like '%in meaning or closest in meaning%')OR
	(qn.question_text like '%from the given choices to fill up%')OR
	(qn.question_text like '%which pair of words can be filled up in the blanks%')OR
	(qn.question_text like '%proper sequence so as to form a meaningful paragraph%')
ORDER BY qz.id, qn.priority
"; 	

public $QueryQz = 
"SELECT qnb.quiz_id QzId, qnb.quiz_name Qz,
min(qnb.question_id) QnIdFrom, max(qnb.question_id) QnIdTo,
max(qnb.question_id)-min(qnb.question_id)+1 Qns
FROM
(SELECT qz.id quiz_id, qz.quiz_name,
	  qn.id question_id, qn.question_text, qn.priority sort_by
FROM quizzes qz
  INNER JOIN questions qn ON(qz.id = qn.quiz_id)
ORDER BY qz.id, qn.priority
) qnb
WHERE (qnb.question_text like '%is any grammatical or idiomatic error in it%') OR
	(qnb.question_text like '%Fill in the blanks with the most appropriate alternative%')OR
	(qnb.question_text like '%Answer the following questions on the basis of the passage given below%')OR
	(qnb.question_text like '%in meaning or closest in meaning%')OR
	(qnb.question_text like '%from the given choices to fill up%')OR
	(qnb.question_text like '%which pair of words can be filled up in the blanks%')OR
	(qnb.question_text like '%proper sequence so as to form a meaningful paragraph%')
GROUP BY qnb.quiz_id
"; 
	}
?>

<?php
$a = "SELECT qz.id quiz_id, qz.quiz_name,
	  qn.id question_id, qn.question_text, qn.priority sort_by
FROM quizzes qz
  INNER JOIN questions qn ON(qz.id = qn.quiz_id)
  WHERE (qn.question_text like '%What is the difference between the ages of her parents%') OR
	(qn.question_text like '%The present age of the son is %')
ORDER BY qz.id, qn.priority
"
?>
