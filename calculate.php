<html>
<head><title>Кредитный калькулятор на 12 месяцев</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" /> 
</head>
<body>
<div id="bodywidth">
<div id="shapka"><h1>Кредитный калькулятор на 12 месяцев</h1></div>
<div id="res">
<div  align="left">
<a href="javascript:history.back(1)">&laquo;&laquo;Обратно к вводу данных</a>
</div>
<?php
    $sum = $_POST['summ'];
    $procc = $_POST['proc'];
    $mis = 12 ;
    $pp = 100 ;
$summis = $sum / $mis ;

echo "<p><b>СУММА КРЕДИТА:&nbsp;" . $sum . "</b></p>";
    echo "<p><b>% КРЕДИТА:&nbsp;" . $procc . "%</b></p>";

echo "<b><table align = center width = 70% height = 200 border =  1 bordercolor = #C0C0C0   cellspacing = 0 cellpadding = 0>
 <tr width = 200 align = center >
 <td >Месяц</td>
 <td>Сумма кредита</td>
 <td>Сумма %</td>
 <td>К выплате</td>
 <td>Остаток</td>
</tr>
<tr align = center >
<td>1</td>
<td><b>" .round($summis, 2). "</td>

<td><b>" .round($m1 = $sum / $mis * $procc / $pp, 2). "</td>
<td><b>" .round($v1 = $summis + $m1, 2). "</td>
<td><b>" .round($z1 = $sum - $summis, 2). "</td>
</tr>
<tr align = center >
<td>2</td>
<td><b>" .round($summis, 2). "</td>
<td><b>" .round($m2 = $z1 / $mis * $procc / $pp, 2). "</td>
<td><b>" .round($v2 = $summis + $m2, 2). "</td>
<td><b>" .round($z2 = $z1 - $summis, 2). "</td>
</tr>
<tr align = center >
<td>3</td>
<td><b>" .round($summis, 2). "</td>
<td><b>" .round($m3 = $z2 / $mis * $procc / $pp, 2). "</td>
<td><b>" .round($v3 = $summis + $m3, 2). "</td>
<td><b>" .round($z3 = $z2 - $summis, 2). "</td>
</tr>
<tr align = center >
<td>4</td>
<td><b>" .round($summis, 2). "</td>
<td><b>" .round($m4 = $z3 / $mis * $procc / $pp, 2). "</td>
<td><b>" .round($v4 = $summis + $m4, 2). "</td>
<td><b>" .round($z4 = $z3 - $summis, 2). "</td>
</tr>
<tr align = center >
<td>5</td>
<td><b>" .round($summis, 2). "</td>
<td><b>" .round($m5 = $z4 / $mis * $procc / $pp, 2). "</td>
<td><b>" .round($v5 = $summis + $m5, 2). "</td>
<td><b>" .round($z5 = $z4 - $summis, 2). "</td>
</tr>
<tr align = center >
<td>6</td>
<td><b>" .round($summis, 2). "</td>
<td><b>" .round($m6 = $z5 / $mis * $procc / $pp, 2). "</td>
<td><b>" .round($v6 = $summis + $m6, 2). "</td>
<td><b>" .round($z6 = $z5 - $summis, 2). "</td>
</tr>
<tr align = center >
<td>7</td>
<td><b>" .round($summis, 2). "</td>
<td><b>" .round($m7 = $z6 / $mis * $procc / $pp, 2). "</td>
<td><b>" .round($v7 = $summis + $m7, 2). "</td>
<td><b>" .round($z7 = $z6 - $summis, 2). "</td>
</tr>
<tr align = center >
<td>8</td>
<td><b>" .round($summis, 2). "</td>
<td><b>" .round($m8 = $z7 / $mis * $procc / $pp, 2). "</td>
<td><b>" .round($v8 = $summis + $m8, 2). "</td>
<td><b>" .round($z8 = $z7 - $summis, 2). "</td>
</tr>
<tr align = center >
<td>9</td>
<td><b>" .round($summis, 2). "</td>
<td><b>" .round($m9 = $z8 / $mis * $procc / $pp, 2). "</td>
<td><b>" .round($v9 = $summis + $m9, 2). "</td>
<td><b>" .round($z9 = $z8 - $summis, 2). "</td>
</tr>
<tr align = center >
<td>10</td>
<td><b>" .round($summis, 2). "</td>
<td><b>" .round($m10 = $z9 / $mis * $procc / $pp, 2). "</td>
<td><b>" .round($v10 = $summis + $m10, 2). "</td>
<td><b>" .round($z10 = $z9 - $summis, 2). "</td>
</tr>
<tr align = center >
<td>11</td>
<td><b>" .round($summis, 2). "</td>
<td><b>" .round($m11 = $z10 / $mis * $procc / $pp, 2). "</td>
<td><b>" .round($v11 = $summis + $m11, 2). "</td>
<td><b>" .round($z11 = $z10 - $summis, 2). "</td>
</tr>
<tr align = center >
<td>12</td>
<td><b>" .round($summis, 2). "</td>
<td><b>" .round($m12 = $z11 / $mis * $procc / $pp, 2). "</td>
<td><b>" .round($v12 = $summis + $m12, 2). "</td>
<td><b>" .round($z12 = $z11 - $summis, 2). "</td>
</tr>
<tr align = center >
<td>Сума</td>
<td><b>" .$sum. "</td>
<td><b>" .round( $sumproc = $m1 + $m2 + $m3 + $m4 + $m5 + $m6 + $m7 + $m8 + $m9 + $m10 + $m11 + $m12, 2). "</td>
<td><b>" .round($v1 = $summis + $m1, 2). "</td>
<td>-</td>
</tr>
</table>";
?>
</div>
</div>
</body>
</html>