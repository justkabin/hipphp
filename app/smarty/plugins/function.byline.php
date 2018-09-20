<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function smarty_function_byline($params, &$smarty) {
    $model = $params['model'];
    if ($model->owner_guid) {
        $owner = getModel($model->owner_guid);
        echo "<small>by " . $owner->full_name . view("page_elements/timeago", [
            "timestamp" => $model->time_created
        ]) . "</small>";
    }
}
