<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
<link href="file:///C|/Jobs/M4 Parts/stylesheets/reset.css" rel="stylesheet" type="text/css">
<style type="text/css">

body{
	margin: 0;
	padding: 0;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 11px;
}
h1 {
	background-color: #CD0505;
	color: #FFF;
	text-align: center;
	height: 66px;
	line-height: 66px;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 25px;
	font-weight: normal;


	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;	
}

label{
	line-height: 15px;
	padding-left: 16px;
	height: 15px;
	margin-right: 20px;
}
input[type=checkbox]{
	margin-right: 4px;
	margin-top: 2px;
	margin-left: -16px;
	position: absolute;	
	
}
p {
	font-size: 12px;
	text-align: center;
	padding: 10px;
}

fieldset#senha{
	width: 250px;
	display: block;
	margin: auto;
	margin-top: 25px;
}

input#senha{
	width: 240px;
	height: 30px;
	background-color:#CCC;
	font-size: 15px;
	border: 0;
	text-align: center;
	
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;		
}
input#ok{
	width: 144px;
	height: 22px;
	line-height: 22px;
	color: #FFF;
	background-color: #CD0505;
	border: 0;
	display: block;
	margin: auto;
	margin-top: 8px;
	
		-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
</style>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script>
function getRandomNum(lbound, ubound) {
  return (Math.floor(Math.random() * (ubound - lbound)) + lbound);
}

function getRandomChar(number, lower, upper, other, extra) {
  var numberChars = "0123456789";
  var lowerChars = "abcdefghijklmnopqrstuvwxyz";
  var upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  var otherChars = "`~!@#$%^&*()-_=+[{]}\\|;:'\",<.>/? ";
  var charSet = extra;

  if (number == true)
    charSet += numberChars;
  if (lower == true)
    charSet += lowerChars;
  if (upper == true)
    charSet += upperChars;
  if (other == true)
    charSet += otherChars;
  return charSet.charAt(getRandomNum(0, charSet.length));
}

function getPassword(length, extraChars, firstNumber, firstLower, firstUpper, firstOther,
latterNumber, latterLower, latterUpper, latterOther) {
  var rc = "";
  if (length > 0)
    rc = rc + getRandomChar(firstNumber, firstLower, firstUpper, firstOther, extraChars);
  
  for (var idx = 1; idx < length; ++idx) {
    rc = rc + getRandomChar(latterNumber, latterLower, latterUpper, latterOther, extraChars);
}
  return rc;
}


function Gerar(){
 var s = getPassword(10, '', $('#number').is(':checked'), $('#lower').is(':checked'), $('#upper').is(':checked'), false, $('#number').is(':checked'), $('#lower').is(':checked'), $('#upper').is(':checked'), false);
 $('input#senha').val(s);
 $('input#senha').select();
}

$(document).ready(function(){
		
		Gerar();

		$('input[type=checkbox]').change(function(){
		  Gerar();	
		});
		
		$('#ok').click(function(){
			var senha = $('input#senha').val();
			parent.$('#Password .senha1').val(senha);
			parent.$('#Password .senha2').val(senha);			
			parent.$.fancybox.close();
		});
});


</script>
</head>

<body>
<h1>Gerador de Senha</h1>
<p>Utilize as opções abaixo e veja a senha gerada. Selecione a senha no campo indicado e clique em "Utilizar Este Senha".</p>
<fieldset><legend>Opções</legend>
<label><input name="upper" id="upper" type="checkbox" value="true" checked>ABCDEF...</label>
<label><input name="lower" id="lower" type="checkbox" value="true" checked>abcdef...</label>
<label><input name="number" id="number" type="checkbox" value="true" checked>012345678</label>

</fieldset>

<fieldset id="senha"><legend>Selecione e copie a senha gerada</legend>
<input type="text" name="senha" id="senha">
<input type="submit" name="ok" id="ok" value="Utilizar esta senha"
</fieldset>
</body>
</html>
