<html>

<head>
 <script type=text/javascript>
  function open_selected() {
	var cbs = document.getElementsByName('bib_cb');
	if (!cbs  ||  ! cbs instanceof Array)
		return false;
	var ids = '';
	for (var i = 0; i < cbs.length; i++) {
		if (cbs[i].checked)
			ids = ids + cbs[i].value + ',';
	}
	var link = document.getElementById('selected_link');
	if (!link)
		return false;
	link.href = '../../search/search.html?w=all&q=ids:' + ids;
	return true;
  }
 </script>
</head>

<body>
<?php

require_once(dirname(__FILE__).'/../../common/connect/cred.php');
require_once(dirname(__FILE__).'/../../common/connect/db.php');

mysql_connection_db_select(DATABASE);

$res = mysql_query('select rd_rec_id, dty_Name, dty_PtrConstraints, rec_id, rec_title, rty_Name
                      from defDetailTypes
                 left join rec_details on dty_ID = rd_type
                 left join records on rec_id = rd_val
                 left join defRecTypes on rty_ID = rec_type
                     where dty_Type = "resource"
                       and dty_PtrConstraints > 0
                       and rec_type not in (dty_PtrConstraints)');
$bibs = array();
while ($row = mysql_fetch_assoc($res))
	$bibs[$row['rd_rec_id']] = $row;

?>
<div style="font-weight: bold;">
 Records with resource pointers to the wrong rec_type
 &nbsp;&nbsp;
 <a target=_new href='../../search/search.html?w=all&q=ids:<?= join(',', array_keys($bibs)) ?>'>(show all in search)</a>
</div>
<table>
<?php
foreach ($bibs as $row) {
?>
 <tr>
  <td><a target=_new href='../../records/editrec/edit.html?bib_id=<?= $row['rd_rec_id'] ?>'><?= $row['rd_rec_id'] ?></a></td>
  <td><?= $row['dty_Name'] ?></td>
  <td>points to</td>
  <td><?= $row['rec_id'] ?> (<?= $row['rty_Name'] ?>) - <?= substr($row['rec_title'], 0, 50) ?></td>
 </tr>
<?php
}
?>
</table>

<hr>

<?php
$res = mysql_query('select rd_rec_id, dty_Name, a.rec_title
                      from rec_details
                 left join defDetailTypes on dty_ID = rd_type
                 left join records a on a.rec_id = rd_rec_id
                 left join records b on b.rec_id = rd_val
                     where dty_Type = "resource"
		               and a.rec_id is not null
                       and b.rec_id is null');
$bibs = array();
while ($row = mysql_fetch_assoc($res))
	$bibs[$row['rd_rec_id']] = $row;

?>
<div style="font-weight: bold;">
 Records with resource pointers to non-existent records
 &nbsp;&nbsp;
 <a target=_new href='../../search/search.html?w=all&q=ids:<?= join(',', array_keys($bibs)) ?>'>(show all in search)</a>
 &nbsp;&nbsp;
 <a target=_new href='#' id=selected_link onclick="return open_selected();">(show selected in search)</a>
</div>
<table>
<?php
foreach ($bibs as $row) {
?>
 <tr>
  <td><input type=checkbox name=bib_cb value=<?= $row['rd_rec_id'] ?>></td>
  <td><a target=_new href='../../records/editrec/edit.html?bib_id=<?= $row['rd_rec_id'] ?>'><?= $row['rd_rec_id'] ?></a></td>
  <td><?= $row['rec_title'] ?></td>
  <td><?= $row['dty_Name'] ?></td>
 </tr>
<?php
}
print "</table>\n";



?>
</body>
</html>

