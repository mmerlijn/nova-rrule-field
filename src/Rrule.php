<?php

namespace Mmerlijn\NovaRruleField;

use Laravel\Nova\Fields\Field;

class Rrule extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-rrule-field';

    public function locale(string $language)
    {
        return $this->withMeta(['locale' => $language]);
    }

    public function hide(bool $hide = true)
    {
        return $this->withMeta(['hide' => $hide]);
    }
}
