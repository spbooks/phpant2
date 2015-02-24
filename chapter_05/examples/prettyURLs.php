<?php
require_once 'RequestPath.php';

$request = new RequestPath();

if ($request->action == 'edit' && $request->type == 'trackbacks' && isset($request->for)) {
	$id = intval($request->for);

	if ($id == 0) {
		// There was no number included in the 'for' value
		$id = false;
	}

	if (ctype_digit((string) $id)) {
		// Workflow to handle Trackbacks here
		// For example: MySite::getTrackBacksForPost($id);
		echo "Valid Request";
	} else {
		echo "Invalid Request";
	}
}
?>