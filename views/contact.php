<?php

use app\core\form\Form;
use app\core\form\TextAreaField;

/** @var $this \app\core\view */
/** @var $model \app\models\ContactForm */
$this->title = 'Contact';
?>
<div class="w-full px-4 md:px-6 text-xl text-gray-800 leading-normal">
    <?php $form = Form::begin('', 'post');
    echo $form->field($model, 'subject');
    echo $form->field($model, 'email');
    echo new TextAreaField($model, 'body')
    ?>
    <button type="submit" class="flex-1 mt-4 block md:inline-block appearance-none bg-green-500 text-white text-base font-semibold tracking-wider uppercase py-4 rounded shadow hover:bg-green-400">Submit</button>
    <?php
    Form::end();
    ?>
</div>
