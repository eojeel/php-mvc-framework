<?php
use app\core\form\Form;

$this->title = 'Register';
?>
<div class="w-full px-4 md:px-6 text-xl text-gray-800 leading-normal">
    <h1>Register</h1>
    <?php $form = Form::begin('', 'post');
    echo $form->field($model, 'firstname');
    echo $form->field($model, 'lastname');
    echo $form->field($model, 'email');
    echo $form->field($model, 'password')->passwordField();
    echo $form->field($model, 'confirmPassword')->passwordField();
    ?>
    <button type="submit" class="flex-1 mt-4 block md:inline-block appearance-none bg-green-500 text-white text-base font-semibold tracking-wider uppercase py-4 rounded shadow hover:bg-green-400">Submit</button>
    <?php echo Form::end() ?>

    <form action=""  method="POST">
</div>
