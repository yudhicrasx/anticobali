<?php
if ($this->session->flashdata('flash_msg')) {
    $flash = $this->session->flashdata('flash_msg');
    echo '<div class="row"><div class="span10"><div class="alert alert-' . $flash['class'] . '">' . $flash['message'] . '</div></div></div>';
}
if (function_exists('validation_errors') AND validation_errors()) {
    echo '<div class="row"><div class="span10"><div class="alert alert-error">' . validation_errors() . '</div></div></div>';
}
?>