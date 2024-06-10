<?php

declare(strict_types=1);

namespace ArtumiSystemsLtd\AForms;

use ArtumiSystemsLtd\AForms\Form;
use ArtumiSystemsLtd\AForms\Trait\Attributes;
use ArtumiSystemsLtd\PageAssetManager\PageAssetManager;
use InvalidArgumentException;

/**
 * Represents a "Widget" for use in AForms. A simple widget would
 * correspond to something like an <input> with it's <label> and
 * perhaps some validation messages also, if the form was being
 * redisplayed after an error. But actually these widgets should be
 * able to cope with more complex inputs. Like a Start Date and End
 * Date widget should be able to understand the validation rules
 * between the start and end dates.
 *
 * @class
 **/
abstract class Widget
{
    use Attributes;

    public
        $value,
        $initialValue,
        $form,
        $bRequiredField = false,
        $sAdditionalValidator = '',
        $allowed = [
            "id"
        ];
    public $aValidationMsgSubstitute = [];
    private string $sValidationMsg = '';

    public function __construct(
        public readonly string $name,
        public readonly string $caption,
        public array $initialAttribs = []
    ) {
        $this->attribs = $this->initialAttribs;
    }

    abstract function html(): string;
    public function set($value)
    {
        $this->value = $value;
    }
    public function setInitialValue($value)
    {
        $this->initialValue = $value;
    }
    public function setRequired(bool $bRequired): void
    {
        $this->bRequiredField = $bRequired;
    }
    public function required(): bool
    {
        return $this->bRequiredField;
    }
    public function requiredIndicator(): string
    {
        return '<span class="text-red">(required)</span>';
    }
    public function get()
    {
        return $this->value;
    }
    public function label(): string
    {
        $s = '<label for="' . $this->id() . '">' . $this->caption;
        if ($this->required()) {
            $s .= ' ' . $this->requiredIndicator();
        }
        $s .= '</label>';
        return $s;
    }
    public function setForm(Form $f): void
    {
        $this->form = $f;
    }
    public function id(): string
    {
        if ($this->attrib('id'))
            return $this->attrib('id');
        if ($this->form)
            return $this->form->id() . '_' . $this->name;
        return $this->name;
    }
    /**
     * validator returns a string that can be parsed by Laravel's
     * Validation logic  https://laravel.com/docs/10.x/validation#available-validation-rules
     **/
    public function validator(): string
    {
        $s = '';
        if ($this->required()) {
            $s = 'required';
            if ($this->sAdditionalValidator) {
                return $s . '|' . $this->sAdditionalValidator;
            }
            return $s;
        }
        return $this->sAdditionalValidator;
    }
    /**
     * Adds another validator to the current string | separated list
     * that confirms tothe laravel validator logic
     **/
    public function appendValidator(string $sExistingValidator, string $sNewValidator)
    {
        if ($sExistingValidator) {
            $sExistingValidator .= '|';
        } else {
            $sExistingValidator = '';
        }
        $sExistingValidator .= $sNewValidator;
        return $sExistingValidator;
    }
    /**
     * Additional to the "required" validator which we manage
     * separately. See validator() function
     **/
    public function setAdditionalValidator(string $s): void
    {
        $this->sAdditionalValidator = $s;
    }

    public function setValidationMsg(string $sValMsg): void
    {
        $this->sValidationMsg = $sValMsg;
    }
    public function setValidation(array $aErrors): void
    {
        $a = [];
        foreach ($aErrors as $i => $sError) {
            if (isset($this->aValidationMsgSubstitute[$sError])) {
                $a[] = $this->aValidationMsgSubstitute[$sError];
            } else {
                $a[] = $sError;
            }
        }
        $this->setValidationMsg(implode(' ', $a));
    }
    public function resetValidation(): void
    {
        $this->sValidationMsg = '';
    }
    public function getValMsgHTML(): string
    {
        if (!$this->sValidationMsg) {
            return '';
        }
        return '<div id="' . $this->id() . '_v" class="validation">' . $this->sValidationMsg . '</div>';
    }
    public function pack()
    {
        return [$this->name => $this->get()];
    }
    public function populateFromTransaction($a)
    {
        if (isset($a[$this->name]))
            $this->set($a[$this->name]);
    }

    /**
     * This function uses an array and by default the widget will look
     * for a value with a key that matches the name. However it
     * doesn't have to. For example, a widget that uses a latitude and
     * longitude could check 2 keys. This allows us to have a widget
     * that can manage a number of columns in a table.
     * @param $aRow array This represents a table row, a whole record.
     **/
    public function populateFromArray($aRow)
    {
        if (isset($aRow[$this->name]))
            $this->set($aRow[$this->name]);
    }

    public function initialPopulate($a)
    {
        $this->populateFromArray($a);

        if (isset($a[$this->name]))
            $this->setInitialValue($a[$this->name]);
    }

    public function changed()
    {
        return $this->value !== $this->initialValue;
    }
    public function registerAssets(PageAssetManager $manager): void
    {
        //to override
    }
}
