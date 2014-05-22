<?php
if ($this->session->flashdata('flash_msg')) {
    $flash = $this->session->flashdata('flash_msg');
    echo '<div class="alert_message"><div style="color:white" class="' . $flash['class'] . '">' . $flash['message'] . '</div></div>';
}
if (function_exists('validation_errors') AND validation_errors()) {
    echo '<div class="alert_message"><div style="color:white" class="msg_failed">' . validation_errors() . '</div></div>';
}
?>