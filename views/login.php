<?php
use app\core\form\Form;

$form = Form::begin('', 'post');
?>
<div class="w-full px-4 md:px-6 text-xl text-gray-800 leading-normal">
    <h1>Login</h1>
    <?php
    echo $form->field($model, 'email');
    echo $form->field($model, 'password')->passwordField();
    ?>
    <button type="submit" class="flex-1 mt-4 block md:inline-block appearance-none bg-green-500 text-white text-base font-semibold tracking-wider uppercase py-4 rounded shadow hover:bg-green-400">Submit</button>
    <?php echo Form::end() ?>

    <form action=""  method="POST">
</div>
