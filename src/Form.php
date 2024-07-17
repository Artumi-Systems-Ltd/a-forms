<?php

declare(strict_types=1);

namespace ArtumiSystemsLtd\AForms;

use Illuminate\Support\Collection;
use \ArtumiSystemsLtd\AForms\Trait\Attributes;
use ArtumiSystemsLtd\PageAssetManager\PageAssetManager;
use Illuminate\Support\Facades\Validator as FValidator;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use InvalidArgumentException;

abstract class Form
{
    use Attributes;

    private string $defaultValidationMsg = 'There has been an error, please see details below:';
    private string $sValidationMsg = '';
    private string $buttonPressed = '';
    private array  $widgets = [];
    private array  $buttons = [];
    private ?Validator $lastValidator = null;
    private string $sAction = '';
    private string $sMethod = 'post';
    private array $widgetCollections = [];


    public $allowed = [
        'class',
        'style',
    ];

    public function __construct(
        public string $id,
        public array $initialAttribs
    ) {
        $this->attribs = $this->initialAttribs;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function addButton(string $name, string $value): void
    {
        $this->buttons[$name] = new Button($name, $value);
    }
    public function addWidget(Widget $widget)
    {
        $widget->setForm($this);
        $this->widgets[$widget->name] = $widget;
        $widget->addAuxillaryWidgetsToForm($this);
    }
    public function removeWidget(Widget|string $widget): bool
    {
        if (is_object($widget)) {
            $name = $widget->name;
        } else {
            $name = $widget;
        }
        if ($this->hasWidget($name)) {
            unset($this->widgets[$name]);
            return true;
        }
        return false;
    }
    public function hasWidget(string $name)
    {
        return isset($this->widgets[$name]);
    }
    public function getWidget(string $name): Widget
    {
        return $this->widgets[$name];
    }

    public function html(): string
    {
        $this->updateValidation();
        $s = '<form id="' . htmlspecialchars($this->id, ENT_QUOTES) . '"';
        $attribs = $this->attribString(false);
        if ($attribs)
            $s .= ' ' . $attribs;
        if ($this->sAction) {
            $s .= ' action="' . htmlspecialchars($this->sAction, ENT_QUOTES) . '"';
        }
        if ($this->sMethod) {
            switch ($this->sMethod) {
                case 'get':
                case 'post':
                case 'dialog':
                    $s .= ' method="' . $this->sMethod . '"';
                    break;
                case 'put':
                case 'patch':
                case 'delete':
                    $s .= ' method="post"';
                    break;
            }
        }
        $s .= '>';
        $s .= $this->formMethodSpoof();
        $s .= $this->csrf();
        $s .= $this->formValMsgHTML();
        foreach ($this->widgets as $widget) {
            $s .= $widget->html();
        }
        foreach ($this->buttons as $button) {
            $s .= $button->html();
        }
        $s .= '</form>';
        return $s;
    }
    public function formMethodSpoof(): string
    {
        switch ($this->sMethod) {
            case 'put':
            case 'delete':
            case 'patch':
                return '<input type="hidden" name="_method" value="' . $this->sMethod . '">';
        }
        return '';
    }
    public function __get(string $sName): Widget
    {
        return $this->widgets[$sName];
    }
    public function __set(string $sName, $value): void
    {
        $this->widgets[$sName]->set($value);
    }
    public function initialPopulate(array $a): void
    {

        foreach ($a as $k => $v) {
            if (isset($this->widgets[$k]))
                $this->widgets[$k]->initialPopulate($a);
            //no buttons can be pressed on an initial populate
        }
    }
    public function populateFromArray(array $a): void
    {
        foreach ($a as $k => $v) {
            if (isset($this->widgets[$k]))
                $this->widgets[$k]->populateFromArray($a);
            else if (isset($this->buttons[$k]))
                $this->buttonPressed = $k;
        }
    }
    public function buttonPressed(): string
    {
        return $this->buttonPressed;
    }
    public function pack(): array
    {
        $a = [];
        foreach ($this->widgets as $name => $widget) {
            $widgetVals = $widget->pack();
            foreach ($widgetVals as $widgetName => $widgetVal) {
                $a[$widgetName] = $widgetVal;
            }
        }
        if ($this->buttonPressed) {
            $a[$this->buttonPressed] = '';
        }
        return $a;
    }
    public function packChanged(): array
    {

        $a = [];
        foreach ($this->widgets as $name => $widget) {
            if ($widget->changed()) {
                $widgetVals = $widget->pack();
                foreach ($widgetVals as $widgetName => $widgetVal) {
                    $a[$widgetName] = $widgetVal;
                }
            }
        }
        return $a;
    }
    public function validators(): array
    {
        $a = [];
        foreach ($this->widgets as $name => $widget) {
            $validator = $widget->validator();
            if ($validator) {
                $a[$name] = $validator;
            }
        }
        return $a;
    }
    public function validate(): bool
    {
        $validator = FValidator::make($this->pack(), $this->validators());
        $this->lastValidator = $validator;
        return $validator->passes();
    }
    public function lastValidator()
    {
        return $this->lastValidator;
    }
    /** Passes validation information collected during a validate()
     *   call to widgets
     **/
    private function updateValidation()
    {
        if ($this->lastValidator) {
            $bGotOne = false;
            foreach ($this->widgets as $name => $widget) {
                $errors = $this->lastValidator->errors()->get($name);
                if (count($errors)) {
                    $bGotOne = true;
                    $widget->setValidation($errors);
                }
                if ($bGotOne) {
                    $this->setValidationMsg($this->defaultValidationMsg);
                }
            }
        } else {
            $this->resetValidation();
        }
    }
    private function resetValidation(): void
    {
        $this->sValidationMsg = '';
        foreach ($this->widgets as $widget) {
            $widget->resetValidation();
        }
    }
    public function setValidationMsg(string $sValMsg): void
    {
        $this->sValidationMsg = $sValMsg;
    }
    private function formValMsgHTML(): string
    {
        if (!$this->sValidationMsg) {
            return '';
        }
        return '<div id="' . $this->id() . '_valmsg" class="validation">' . $this->sValidationMsg . '</div>';
    }
    public function setAction(string $url): void
    {
        $this->sAction = $url;
    }
    public function setMethod(string $method): void
    {
        switch ($method) {
            case 'get':
            case 'post':
            case 'put':
            case 'delete':
            case 'dialog':
            case 'patch':
                $this->sMethod = $method;
                break;
            default:
                throw new InvalidArgumentException('setMethod only accespts get|post|put|patch|dialog, but received ' . $method);
        }
    }
    public function populateFromRequest(Request $request): void
    {
        $aVals = $request->all();
        $this->populateFromTransaction($aVals);
    }
    public function populateFromTransaction($aVals)
    {
        foreach ($this->widgets as $name => $widget) {
            $widget->populateFromTransaction($aVals);
        }
        foreach ($this->buttons as $button) {
            if (isset($aVals[$button->name]))
                $this->buttonPressed = $button->name;
        }
    }
    public function csrf(): string
    {
        $t = csrf_token();
        if ($t) {
            return '<input type="hidden" name="_token" value="' . htmlspecialchars($t, ENT_QUOTES) . '">';
        }
        return '';
    }
    /**
     * Saves the current data to the session
     */
    public function flash(): void
    {
        session()->flash('form-' . $this->id(), $this->pack());
    }
    /*
    * Loads the data from the session flash, if there is any.
    * @return true if something was loaded.
    **/
    public function loadFromFlash(): bool
    {
        $data = session('form-' . $this->id());
        if ($data) {
            $this->populateFromArray($data);
            return true;
        }
        return false;
    }

    public function registerAssets(PageAssetManager $manager): void
    {
        foreach ($this->widgets as $widget) {
            $widget->registerAssets($manager);
        }
    }


    /**
     * Function to add a widget for each item in a collection. This is working
     * when we're adding checkboxes, I want it to work for integers too, so we
     * but that's not there yet.
     *
     * @param string $widgetBaseName
     * @param Collection $options,
     * @param string $idField, nearly always 'id'
     * @param string $nameField, what are we showing against the widget?
     * @param string $class, which Widget are we adding
     * @return void
     **/
    public function createWidgetCollection(string $widgetBaseName, Collection $options, string $idField, string $nameField, string $class): void
    {
        $this->widgetCollections[$widgetBaseName] = [
            'options' => $options,
            'idfield' => $idField,
            'namefield' => $nameField,
            'class' => $class
        ];
        foreach ($options as $item) {
            $widget = new $class($widgetBaseName . '_' . $item->$idField, $item->$nameField);
            $this->addWidget($widget);
        }
    }

    /**
     * Sets the selected values of a collection of widgets created by
     * addWidgetCollection()
     *
     * @param string $widgetBaseName
     * @param Collection $chosen[$idField],
     * @return void
     **/
    public function setWidgetCollectionValues(string $widgetBaseName, Collection $chosen): void
    {
        $idField = $this->widgetCollections[$widgetBaseName]['idfield'];
        foreach ($chosen  as $item) {
            $name = $widgetBaseName . '_' . $item->$idField;
            if ($this->hasWidget($name)) {
                //todo - how do we alter this when it's not a checkbox?
                $this->$name->set(true);
            }
        }
    }

    /**
     * Function to get the values in a format for DB:sync()      *
     * @param string $widgetBaseName
     * @return array [id1,id2] - suitable for sync()
     **/
    public function getWidgetCollectionValues(string $widgetBaseName): array
    {
        $idField = $this->widgetCollections[$widgetBaseName]['idfield'];
        $options = $this->widgetCollections[$widgetBaseName]['options'];
        $a = [];
        foreach ($options as $item) {
            $name = $widgetBaseName . '_' . $item->$idField;
            if ($this->$name->get()) {
                $a[] = $item->$idField;
            }
        }
        return $a;
    }
}
