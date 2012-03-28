<?php

// Make sure we're logged in (send us to the front page if not)
gatekeeper();

// Get input data
$guid = (int) get_input('id');

// Make sure we actually have permission to edit
$object_to_delete = get_entity($guid);
$object_subtype = $object_to_delete->getSubtype();
if (!is_null($object_to_delete)
        && can_edit_entity($guid)
        && (
           $object_subtype == "cvranking"
        || $object_subtype == "education"
        || $object_subtype == "workexperience"
        || $object_subtype == "language"
        || $object_subtype == "research"
        || $object_subtype == "publication"
        || $object_subtype == "skill")
) {

    // Delete it!
    $rowsaffected = $object_to_delete->delete();
    if ($rowsaffected > 0) {
        // Success message
        system_message(elgg_echo('resume:OK'));
    } else {
        register_error(elgg_echo('resume:notOK'));
    }
    // Forward to the main page
    forward($CONFIG->wwwroot . "resumes/" . elgg_get_logged_in_user_entity()->username. "?tab=" . $object_subtype);
}