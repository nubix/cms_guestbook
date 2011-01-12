<form action="%request_uri%" method=post>
<table border=0>
	<tr>
		<td style="width: 95px;"><b>Titel</b></td>
		<td><input class=input type=text style="width: 400px;" name=title value=%title%></td>
		
	</tr>
	<tr>
		<td colspan=2><textarea style="width: 500px; height: 200px;" name=input>%input%</textarea></td>
	</tr>
	<tr>
		<td colspan=2>
			<input type=hidden name=id value=%id%>
			<input type=submit name=send value=abschicken>
		</td>
	</tr>
	</table>
</form>
