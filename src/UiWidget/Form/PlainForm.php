<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 22:32
 */

namespace Howous\UiWidget\Form;

use Encore\Admin\Form\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;

/**
 * Class PlainForm.
 *
 * @method \Encore\Admin\Form\Field\Text           text($column, $label = '')
 * @method \Encore\Admin\Form\Field\Checkbox       checkbox($column, $label = '')
 * @method \Encore\Admin\Form\Field\Radio          radio($column, $label = '')
 * @method \Encore\Admin\Form\Field\Select         select($column, $label = '')
 * @method \Encore\Admin\Form\Field\MultipleSelect multipleSelect($column, $label = '')
 * @method \Encore\Admin\Form\Field\Textarea       textarea($column, $label = '')
 * @method \Encore\Admin\Form\Field\Hidden         hidden($column, $label = '')
 * @method \Encore\Admin\Form\Field\Id             id($column, $label = '')
 * @method \Encore\Admin\Form\Field\Ip             ip($column, $label = '')
 * @method \Encore\Admin\Form\Field\Url            url($column, $label = '')
 * @method \Encore\Admin\Form\Field\Color          color($column, $label = '')
 * @method \Encore\Admin\Form\Field\Email          email($column, $label = '')
 * @method \Encore\Admin\Form\Field\Mobile         mobile($column, $label = '')
 * @method \Encore\Admin\Form\Field\Slider         slider($column, $label = '')
 * @method \Encore\Admin\Form\Field\Map            map($latitude, $longitude, $label = '')
 * @method \Encore\Admin\Form\Field\Editor         editor($column, $label = '')
 * @method \Encore\Admin\Form\Field\File           file($column, $label = '')
 * @method \Encore\Admin\Form\Field\Image          image($column, $label = '')
 * @method \Encore\Admin\Form\Field\Date           date($column, $label = '')
 * @method \Encore\Admin\Form\Field\Datetime       datetime($column, $label = '')
 * @method \Encore\Admin\Form\Field\Time           time($column, $label = '')
 * @method \Encore\Admin\Form\Field\Year           year($column, $label = '')
 * @method \Encore\Admin\Form\Field\Month          month($column, $label = '')
 * @method \Encore\Admin\Form\Field\DateRange      dateRange($start, $end, $label = '')
 * @method \Encore\Admin\Form\Field\DatetimeRange  datetimeRange($start, $end, $label = '')
 * @method \Encore\Admin\Form\Field\TimeRange      timeRange($start, $end, $label = '')
 * @method \Encore\Admin\Form\Field\Number         number($column, $label = '')
 * @method \Encore\Admin\Form\Field\Currency       currency($column, $label = '')
 * @method \Encore\Admin\Form\Field\HasMany        hasMany($relationName, $callback)
 * @method \Encore\Admin\Form\Field\SwitchField    switch ($column, $label = '')
 * @method \Encore\Admin\Form\Field\Display        display($column, $label = '')
 * @method \Encore\Admin\Form\Field\Rate           rate($column, $label = '')
 * @method \Encore\Admin\Form\Field\Divide         divider()
 * @method \Encore\Admin\Form\Field\Password       password($column, $label = '')
 * @method \Encore\Admin\Form\Field\Decimal        decimal($column, $label = '')
 * @method \Encore\Admin\Form\Field\Html           html($html, $label = '')
 * @method \Encore\Admin\Form\Field\Tags           tags($column, $label = '')
 * @method \Encore\Admin\Form\Field\Icon           icon($column, $label = '')
 * @method \Encore\Admin\Form\Field\Embeds         embeds($column, $label = '')
 * @method \Encore\Admin\Form\Field\MultipleImage  multipleImage($column, $label = '')
 * @method \Encore\Admin\Form\Field\MultipleFile   multipleFile($column, $label = '')
 * @method \Encore\Admin\Form\Field\Captcha        captcha($column, $label = '')
 * @method \Encore\Admin\Form\Field\Listbox        listbox($column, $label = '')
 */
class PlainForm
{
    /**
     * Available Fields     所有绑定的控件
     *
     * @var array
     */
    public static $availableFields = [];

    protected $builder;

    /**
     * @var Model
     */
    protected $model;

    public function __construct($model)
    {
        $this->builder = new Builder($this);
        $this->model   = $model;
    }

    public function __call($method, $arguments)
    {
        $method = lcfirst($method);

        if ($class = self::findFieldClass($method)) {

            $column = array_get($arguments, 0);
            $field  = new $class($column, array_slice($arguments, 1));

            $this->pushFields($field);

            return $field;
        } else {
            throw new \Exception('doesn"t has method ' . $method);
        }
    }

    public function setAction($action)
    {
        $this->builder->setAction($action);

        return $this;
    }

    protected function pushFields($field)
    {
        $this->builder->fields()->push($field);

        return $this;
    }

    public static function findFieldClass($field)
    {
        $class = array_get(self::$availableFields, $field);
        if (class_exists($class)) {
            return $class;
        }

        return false;
    }

    public function getUrl()
    {
        $url = \Request::getUri();

        return $url;
    }


    public static function setBuiltinFields()
    {
        $map = [
            'button'         => \Encore\Admin\Form\Field\Button::class,
            'checkbox'       => \Encore\Admin\Form\Field\Checkbox::class,
            'color'          => \Encore\Admin\Form\Field\Color::class,
            'currency'       => \Encore\Admin\Form\Field\Currency::class,
            'date'           => \Encore\Admin\Form\Field\Date::class,
            'dateRange'      => \Encore\Admin\Form\Field\DateRange::class,
            'datetime'       => \Encore\Admin\Form\Field\Datetime::class,
            'dateTimeRange'  => \Encore\Admin\Form\Field\DatetimeRange::class,
            'datetimeRange'  => \Encore\Admin\Form\Field\DatetimeRange::class,
            'decimal'        => \Encore\Admin\Form\Field\Decimal::class,
            'display'        => \Encore\Admin\Form\Field\Display::class,
            'divider'        => \Encore\Admin\Form\Field\Divide::class,
            'divide'         => \Encore\Admin\Form\Field\Divide::class,
            'embeds'         => \Encore\Admin\Form\Field\Embeds::class,
            'editor'         => \Encore\Admin\Form\Field\Editor::class,
            'email'          => \Encore\Admin\Form\Field\Email::class,
            'file'           => \Encore\Admin\Form\Field\File::class,
            'hasMany'        => \Encore\Admin\Form\Field\HasMany::class,
            'hidden'         => \Encore\Admin\Form\Field\Hidden::class,
            'id'             => \Encore\Admin\Form\Field\Id::class,
            'image'          => \Encore\Admin\Form\Field\Image::class,
            'ip'             => \Encore\Admin\Form\Field\Ip::class,
            'map'            => \Encore\Admin\Form\Field\Map::class,
            'mobile'         => \Encore\Admin\Form\Field\Mobile::class,
            'month'          => \Encore\Admin\Form\Field\Month::class,
            'multipleSelect' => \Encore\Admin\Form\Field\MultipleSelect::class,
            'number'         => \Encore\Admin\Form\Field\Number::class,
            'password'       => \Encore\Admin\Form\Field\Password::class,
            'radio'          => \Encore\Admin\Form\Field\Radio::class,
            'rate'           => \Encore\Admin\Form\Field\Rate::class,
            'select'         => \Encore\Admin\Form\Field\Select::class,
            'slider'         => \Encore\Admin\Form\Field\Slider::class,
            'switch'         => \Encore\Admin\Form\Field\SwitchField::class,
            'text'           => \Encore\Admin\Form\Field\Text::class,
            'textarea'       => \Encore\Admin\Form\Field\Textarea::class,
            'time'           => \Encore\Admin\Form\Field\Time::class,
            'timeRange'      => \Encore\Admin\Form\Field\TimeRange::class,
            'url'            => \Encore\Admin\Form\Field\Url::class,
            'year'           => \Encore\Admin\Form\Field\Year::class,
            'html'           => \Encore\Admin\Form\Field\Html::class,
            'tags'           => \Encore\Admin\Form\Field\Tags::class,
            'icon'           => \Encore\Admin\Form\Field\Icon::class,
            'multipleFile'   => \Encore\Admin\Form\Field\MultipleFile::class,
            'multipleImage'  => \Encore\Admin\Form\Field\MultipleImage::class,
            'captcha'        => \Encore\Admin\Form\Field\Captcha::class,
            'listbox'        => \Encore\Admin\Form\Field\Listbox::class,
        ];

        foreach ($map as $abstract => $class) {
            self::extend($abstract, $class);
        }
    }


    /**
     * Get validation messages.
     *
     * @param array $input
     *
     * @return MessageBag|bool
     */
    protected function validationMessages($input)
    {
        $failedValidators = [];

        foreach ($this->builder->fields() as $field) {
            if (!$validator = $field->getValidator($input)) {
                continue;
            }

            if (($validator instanceof Validator) && !$validator->passes()) {
                $failedValidators[] = $validator;
            }
        }

        $message = $this->mergeValidationMessages($failedValidators);

        return $message->any() ? $message : false;
    }

    /**
     * Merge validation messages from input validators.
     *
     * @param \Illuminate\Validation\Validator[] $validators
     *
     * @return MessageBag
     */
    protected function mergeValidationMessages($validators)
    {
        $messageBag = new MessageBag();

        foreach ($validators as $validator) {
            $messageBag = $messageBag->merge($validator->messages());
        }

        return $messageBag;
    }


    public function store()
    {
        $data = \Request::all();
        // Handle validation errors.
        if ($validationMessages = $this->validationMessages($data)) {
            return back()->withInput()->withErrors($validationMessages);
        }

        $prepare_data = $this->prepareInsert($data);

        foreach ($prepare_data as $column => $value) {
            $this->model->where('name', $column)->update(['value' => $value]);
        }

        admin_toastr(trans('admin.save_succeeded'));
    }


    public function operate(\Closure $callback)
    {
        $data = \Request::all();
        if ($validationMessages = $this->validationMessages($data)) {
            return back()->withInput()->withErrors($validationMessages);
        }
        $prepare_data = $this->prepareInsert($data);

        $result = call_user_func($callback, $prepare_data);

        if (!is_array($result) || !array_key_exists('status', $result) || !array_key_exists('message', $result)) {
            throw new \Exception('返回数据格式不正确', 500);
        }

        admin_toastr($result['message'], $result['status']);
    }


    /**
     * Prepare input data for insert.
     *
     * @param $inserts
     *
     * @return array
     */
    protected function prepareInsert($inserts)
    {
        foreach ($inserts as $column => $value) {
            if (is_null($field = $this->getFieldByColumn($column))) {
                unset($inserts[$column]);
                continue;
            }

            $inserts[$column] = $field->prepare($value);
        }

        $prepared = [];

        foreach ($inserts as $key => $value) {
            array_set($prepared, $key, $value);
        }

        return $prepared;
    }

    /**
     * Find field object by column.
     *
     * @param $column
     *
     * @return mixed
     */
    protected function getFieldByColumn($column)
    {
        return $this->builder->fields()->first(
            function (Field $field) use ($column) {
                if (is_array($field->column())) {
                    return in_array($column, $field->column());
                }

                return $field->column() == $column;
            }
        );
    }

    public static function extend($abstract, $class)
    {
        self::$availableFields[$abstract] = $class;
    }

    public function render()
    {
        return $this->builder->render();
    }

    public function __toString()
    {
        return $this->render();
    }
}
