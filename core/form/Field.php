<?php

namespace app\core\form;

use App\core\Model;

class Field
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_INT = 'number';

    public Model $model;
    public string $attribute;
    public string $type;

    public function __construct(\app\core\Model $model, string $attirbute)
    {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attribute = $attirbute;
    }

    public function __toString()
    {
        return sprintf('<label>%s:</label><br>
        <input type="%s" name="%s" value="%s" class="%s">
        <div class="text-rose-600 dark:text-rose-500 text-sm">%s</div><br>',
        $this->attribute,
        $this->type,
        $this->attribute,
        $this->model->{$this->attribute},
        $this->model->hasError($this->attribute) ? 'border-2 border-rose-600' : '',
        $this->model->getFirstError($this->attribute)
        );
    }

    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
}
