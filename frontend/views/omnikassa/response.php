<?php

/* @var $this yii\web\View */
/* @var $response edofre\omnikassa\PaymentResponse */

$this->title = 'Omnikassa';
?>
<div class="site-omnikassa">
    <div class="body-content">
        <?php
        var_dump($response->attributes);
        var_dump('Pending', $response->isPending);
        var_dump('Successful', $response->isSuccessful);
        var_dump('Failure', $response->isFailure);
        ?>
    </div>
</div>