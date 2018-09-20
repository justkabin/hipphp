<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function smarty_function_systemmessages() {
    $system_messages = Cache::get("system_messages", "session");
    if (is_array($system_messages)) {
        foreach ($system_messages as $style => $message) {
            echo view("page_elements/system_messages", [
                "style" => $message['style'],
                "message" => $message['message']
            ]);
        }
    }
}
