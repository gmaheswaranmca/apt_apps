<?php 		
	@session_start();	
	define('PageName','Home Page');
	include_once("header.php");
?>
<?php include("footer.php");?>
<script type="text/javascript">
	var APT_TZ_OFFSET = '<?php echo(APT_TZ_OFFSET); ?>';
	var APT_TIMEZONE = '<?php echo(APT_TIMEZONE); ?>';
	var AptDateOnly = '<?php echo(AptDateOnly); ?>';
	var AptDayName = '<?php echo(AptDayName); ?>';
	var AptTimeOnly = '<?php echo(AptTimeOnly); ?>';
	var prefTime = {'APT_TZ_OFFSET':APT_TZ_OFFSET,'APT_TIMEZONE':APT_TIMEZONE,
				  'AptDateOnly':AptDateOnly,'AptDayName':AptDayName,'AptTimeOnly':AptTimeOnly}
	$('#PageBefore').css('display','none');
	$('#PageAfter').css('display','block');
	var htmlSide = '<table>{{#link}}<tr><td><a href="../?link={{link_href}}">{{link_text}}</a></td></tr>{{/link}}</table>';
	var htmlMain = '{{#pref}}<div><strong>Time Zone:</strong> {{APT_TIMEZONE}} ({{APT_TZ_OFFSET}})</div>' + 
				  '<div><strong>Date:</strong> {{AptDateOnly}}</div>' + 
				  '<div><strong>Day:</strong> {{AptDayName}}</div>' + 
				  '<div style="border-bottom:1px solid silver"><strong>Time:</strong> {{AptTimeOnly}}</div>{{/pref}}' + 
				  '<table>{{#link}}<tr><td><a href="../?app={{link_href}}">{{{link_text}}}</a></td></tr>{{/link}}</table>';
	var linkSide = [{'link_href':'base','link_text':'Base Link'},
		{'link_href':'one','link_text':'Test Link One'},
		{'link_href':'two','link_text':'Test Link Two'},
		{'link_href':'three','link_text':'Test Link Three'},
		{'link_href':'four','link_text':'Test Link Four'},
		{'link_href':'five','link_text':'Test Link Five'},
		{'link_href':'six','link_text':'Test Link Six'},
		{'link_href':'qabase','link_text':'Quants Base Link'},
		{'link_href':'codeone','link_text':'CODE TEST DEMO'},
		{'link_href':'codetwo','link_text':'CODE TEST TWO'}
		];
	var linkMain = [{'link_href':'app','link_text':'Test App'},
		{'link_href':'app01','link_text':'Test App 01'},
		{'link_href':'app02','link_text':'Test App 02'},		
		{'link_href':'apps','link_text':'<span style="color:red;">All Pages</span>'},
		{'link_href':'beta','link_text':'Quiz List'},
		{'link_href':'report','link_text':'Make Report'},
		{'link_href':'admin','link_text':'<span style="border-top:1px solid orange;">Admin App</span>'},
		{'link_href':'super','link_text':'Super Admin'}];
	var strMakeReportPage = '';
	strMakeReportPage = Mustache.render(htmlSide, {'link': linkSide});
	$('#testPagers').html(strMakeReportPage);		
	strMakeReportPage = Mustache.render(htmlMain, {'link': linkMain,'pref':prefTime});
	$('#pageContent').html(strMakeReportPage);	
</script>
</body>
</html>	
