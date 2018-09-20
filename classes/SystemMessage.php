<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */

/**
 * System message system
 */
class SystemMessage {

    /**
     * Creates a new system message
     *
     * @param string $message       The message to display.
     * @param type $message_type    CSS style of message.  info, success, etc.
     */
    public function __construct($message, $message_type = "info") {

        $system_messages = Cache::get("system_messages", "session");
        $system_messages = is_array($system_messages) ? $system_messages : array();
        $system_messages[] = [
            "message" => $message,
            "message_type" => $message_type
        ];
        new Cache("system_messages", $system_messages, "session");
    }

}
