<?php

namespace app\core\form;

use app\core\Model;

abstract class BaseField
{
    public Model $model;
    public string $attribute;

    abstract public function renderInput(): string;

    public function __construct(Model $model, string $attirbute)
    {
        $this->model = $model;
        $this->attribute = $attirbute;
    }

    public function __toString()
    {
        return sprintf('<label>%s:</label><br>
        %s
        <div class="text-rose-600 dark:text-rose-500 text-sm">%s</div><br>',
        $this->model->getLabel($this->attribute),
        $this->renderInput(),
        $this->model->getFirstError($this->attribute)
        );
    }
}
