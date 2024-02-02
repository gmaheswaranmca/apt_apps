<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include (realpath(ROOTDB.'../../../gf/WrapperModel.php'));
			
	class QuizModel{
		private $wmd = NULL;		
		private $sql = NULL;
		public function __construct(){
			$this->wmd = new WrapperModel();
			$this->sql = new QuizModelSql();
		}public function QuizCategory()	{, , , , 
			return $this->wmd->QueryNoParam($this->sql->sqlQuizCategory);
		}public function QuizData()	{
			return $this->wmd->QueryNoParam($this->sql->sqlQuizData);
		}public function QuizQuestionData()	{
			return $this->wmd->QueryNoParam($this->sql->sqlQuizQuestionData);
		}public function QuizQuestionGroup()	{			
			return $this->wmd->QueryNoParam($this->sql->sqlQuizQuestionGroup);
		}public function QuizQuestionOption()	{			
			return $this->wmd->QueryNoParam($this->sql->sqlQuizQuestionOption);
		}
	}
	class QuizModelSql{ 
	
	/*cats			: id, cat_name
	quizzes			: id, cat_id, quiz_name, quiz_desc, added_date, parent_id, show_intro, intro_text
	questions		: id, question_text, question_type_id, priority, quiz_id, point, added_date, 
					  parent_id, question_total, check_total, header_text, footer_text, question_text_eng, help_image
	question_groups : id, group_name, show_header, group_total, show_footer, check_total, question_id, parent_id, 
					  group_name_eng, added_date
	answers			: id, group_id, answer_text, answer_image, correct_answer, priority, correct_answer_text, answer_pos, 
					  parent_id, answer_text_eng, control_type, answer_parent_id, text_unit
01-QuizCategory ->  	          <cats> category_id, category_name
02-QuizData	->         	   	   <quizzes> quiz_id, category_id, quiz_name, instructions, quiz_desc, 
										 added_date, parent_id, show_intro
03-QuizQuestionData ->       <questions> question_id, quiz_id, question, question_type_id, score_point, 
										 priority, added_date, parent_id, question_total, check_total, header_text, 
										 footer_text, question_text_eng, help_image
04-QuizQuestionGroup -><question_groups> group_id, question_id, 
										 group_name, show_header, group_total, show_footer, check_total, parent_id, 
										 group_name_eng, added_date
05-QuizQuestionOption ->       <answers> option_id, group_id, answer_text, correct_answer, 
										 answer_image, priority, correct_answer_text, answer_pos, parent_id, 
										 answer_text_eng, control_type, answer_parent_id, text_unit
	*/	
	public $sqlQuizCategory 			= "SELECT id category_id, cat_name category_name FROM cats";
	public $sqlQueryTestCountLive 		= "SELECT id quiz_id, cat_id category_id, quiz_name quiz_name, intro_text instructions,
		quiz_desc, added_date, parent_id, show_intro FROM quizzes WHERE parent_id=0";
	public $sqlQuizQuestion 			= "SELECT id question_id, quiz_id, question_text question, question_type_id, point score_point,
		priority, added_date, parent_id, question_total, check_total, header_text, footer_text, question_text_eng, help_image FROM questions WHERE parent_id=0";
	public $sqlQuizQuestionGroup 		= "SELECT id group_id, question_id, 
		group_name, show_header, group_total, show_footer, check_total,  parent_id, 
		group_name_eng, added_date FROM question_groups  WHERE parent_id=0";
	public $sqlQuizQuestionOption 		= "SELECT id option_id, group_id, answer_text, correct_answer,
        answer_image,  priority, correct_answer_text, answer_pos, parent_id, answer_text_eng, control_type,
        answer_parent_id, text_unit FROM answers  WHERE parent_id=0";	
/*
-> Quiz : Query, Insert, Update, Delete
	-> Cat : Query, Insert, Update   
    Quiz Insert 
		Quiz - Insert -> each => Cat -> Insert 
			~~>Question - Insert  -> each => QuestionGroup - Insert 
				~~>Answer - Insert 				
	Quiz Update
		Quiz - Update (On Require) => Cat -> Update 
			~~>Question - Update (On Require)  -> each => QuestionGroup - Update 
				~~>Answer - Update(On Require) 
							Or Insert (On Require)
							Or Delete (On Require)
							
<New> Quiz 01 | Quiz 02 | Quiz 03 | .... | Quiz 0N
New Quiz [                                                    ] <edit>
Instructions[                                                 ]
No Of Question [                  ] Options [              ]
Q[1] <edit> <delete> 
   [                                                
                                                ] 
	[3] Options 
	Option A [                                       ] 
	Option B [                                       ]
	Option C [                                       ]
	Answer [A]v
Q[2] <edit> <delete> 
	[                                                
                                                ] 
	[3] Options 
	Option A [                                       ] 
	Option B [                                       ]
	Option C [                                       ]
	Answer [A]v
Q[2] <edit> <delete> 
	[                                                
                                                ] 
	[3] Options 
	Option A [                                       ] 
	Option B [                                       ]
	Option C [                                       ]
	Answer [A]v
*/		
?>