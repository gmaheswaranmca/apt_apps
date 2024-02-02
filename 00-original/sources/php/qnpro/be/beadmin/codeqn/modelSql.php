<?php 
	if(!isset($RUN)) exit(); 
class CodeQnModelSql{

    /* Read	*/

    //
    public $QueryCodeQn = 
"SELECT qn.question_id, qn.code_title, qn.code_question, qn.lang_code, 
    qn.level_no, qn.tested_program, le.level_name, 
    la.full_name lang_full_name, la.api_lang_name, la.api_version_no, 
    la.default_program
FROM tcode_q_base qn
INNER JOIN
  tcode_level le
ON(qn.level_no=le.level_no)
INNER JOIN
   tcode_language la
ON(qn.lang_code=la.lang_code)"; 	

    //
    public $QueryTestCase = 
"SELECT tc.question_id, tc.testcase_id, tc.sno, tc.input, tc.output, tc.point, tc.is_active
FROM tcode_q_testcase tc"; 			

    //Write
    //Edit Qn
    public $UpdateQn = "UPDATE tcode_q_base 
SET code_title=:p_code_title,
    code_question=:p_code_question,
    tested_program=:p_tested_program WHERE question_id=:p_question_id";

    public $UpdateTestcase = "UPDATE tcode_q_testcase 
SET input=:p_input,
    output=:p_output  WHERE testcase_id=:p_testcase_id";

    public $InsertQn = "INSERT INTO tcode_q_base 
(code_title, code_question, lang_code, level_no, tested_program) 
VALUES 
( :p_code_title,:p_code_question,:p_lang_code,:p_level_no,:p_tested_program)";

    public $InsertTestcase = "INSERT INTO tcode_q_testcase 
(question_id, input, output, point, sno, is_active) 
VALUES 
(:p_question_id,:p_input,:p_output,10,:p_sno,1)";
    	

} 