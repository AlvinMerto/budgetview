<?php
	foreach($data as $d) {
		echo "<tr>";
			echo "<td> {$d->name} </td>";
			echo "<td> {$d->cnt} </td>";
		echo "</tr>";
	}
?>