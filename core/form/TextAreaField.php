<?php

namespace app\core\form;

class TextAreaField extends BaseField
{

    public function renderInput(): string
    {
        return sprintf('<textarea name="%s" class="%s">%s</textarea>',
        $this->attribute,
        $this->model->hasError($this->attribute) ? 'border-2 border-rose-600' : '',
        $this->model->{$this->attribute}
    );
}
}
