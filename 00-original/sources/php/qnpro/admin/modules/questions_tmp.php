<?php if(!isset($RUN)) { exit(); } ?> 
<div>
 | 
<a href="?module=add_question&quiz_id=<?php echo $quiz_id ?>">Add new question</a> | 
<a href="?module=add_question&quiz_id=<?php echo $quiz_id ?>&answercount=2">2</a>   | 
<a href="?module=add_question&quiz_id=<?php echo $quiz_id ?>&answercount=3">3</a>   | 
<a href="?module=add_question&quiz_id=<?php echo $quiz_id ?>&answercount=4">4</a>   | 
<a href="?module=add_question&quiz_id=<?php echo $quiz_id ?>&answercount=5">5</a>  | 
<a href="?module=add_question&quiz_id=<?php echo $quiz_id ?>&answercount=6">6</a>  | 
<a href="?module=add_question&quiz_id=<?php echo $quiz_id ?>&answercount=7">7</a>  | 
<a href="?module=add_question&quiz_id=<?php echo $quiz_id ?>&answercount=8">8</a>  ||||
<a href="?module=disp_questions&quiz_id=<?php echo $quiz_id ?>">View All Questions</a> | 
</div>
<div id="div_grid"><?php echo $grid_html ?></div>
    <br>
    <hr />

    <a href="?module=add_question&quiz_id=<?php echo $quiz_id ?>">Add new question</a>