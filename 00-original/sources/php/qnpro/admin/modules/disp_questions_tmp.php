<?php if(!isset($RUN)) { exit(); } ?>
<?php
$i=0;
while($row = db::fetch($asg_res01))
{ $i++;
}
?>
<div style="position:fixed;top:0;left:0;z-index:1000;width:100%;background-color:silver;">
<a href="javascript:history.back()">Back</a>12121
<div>
 | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>" target="_blank">Add new question</a> | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=2">2</a>   | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=3">3</a>   | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=4">4</a>   | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=5">5</a>  | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=6">6</a>  | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=7">7</a>  | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=8">8</a>  ||||
<a  href="?module=questions&quiz_id=<?php echo $id ?>">Questions</a> | 
</div>
<div>
	<?php	
	for($j=0;$j<$i;$j++){
	?>
		<a  href="#Qn<?php   echo $j+1; ?>"><?php   echo $j + 1; ?></a> 
	<?php	} ?>
</div>
</div>
<br><br><br><br><br><br><br>

<table cellpadding="0" cellspacing="0" width="100%">
<?php
$i=0;
while($row = db::fetch($asg_res))
{ $i++;
    ?>
    <tr >
		<td style="border-top:1px silver solid;width:30px;vertical-align:middle;" id="Qn<?php   echo $i; ?>">(<?php   echo $i; ?>)</td>
    
        <td colspan="2" style="border-top:1px silver solid;">
   <?php
    echo get_question($row);
    ?>
	</td>
	    <td  style="border-top:1px silver solid;padding-top:5px; font-family:'Arial Narrow';font-size:8pt;text-align:right;vertical-align:top;width:50px;">
            
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&id=<?php echo $row['id'] ?>">edit</a>   | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&copyid=<?php echo $row['id'] ?>">copy</a>   | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=2&copyid=<?php echo $row['id'] ?>">2</a>   | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=3&copyid=<?php echo $row['id'] ?>">3</a>   | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=4&copyid=<?php echo $row['id'] ?>">4</a>   | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=5&copyid=<?php echo $row['id'] ?>">5</a>  | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=6&copyid=<?php echo $row['id'] ?>">6</a>  | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=7&copyid=<?php echo $row['id'] ?>">7</a>  | 
<a  href="?module=add_question&quiz_id=<?php echo $id ?>&answercount=8&copyid=<?php echo $row['id'] ?>">8</a>  |

        </td>
    
    </tr>
    <?php
}
?>

</table>

