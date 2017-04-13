<?php

/* @var $this yii\web\View */

$this->title = 'Omnikassa';
?>
<div class="site-omnikassa">
    <div class="body-content">
        <?php
        $paymentRequest = new \edofre\omnikassa\PaymentRequest([
            'amount'               => 12354,
            'orderId'              => '123456789',
            'normalReturnUrl'      => \yii\helpers\Url::to(['omnikassa/return'], true),
            'transactionReference' => uniqid(),
        ]);
        Yii::$app->omniKassa->prepareRequest($paymentRequest)
        ?>

        <form method="post" action="<?= Yii::$app->omniKassa->url ?>">
            <input type="hidden" name="Data" value="<?= Yii::$app->omniKassa->dataField ?>">
            <input type="hidden" name="InterfaceVersion" value="<?= Yii::$app->omniKassa->interfaceVersion ?>">
            <input type="hidden" name="Seal" value="<?= Yii::$app->omniKassa->seal ?>">
            <?= \yii\helpers\Html::submitButton('Click here to make your payment', ['class' => 'btn btn-success']) ?>
        </form>
    </div>
</div>