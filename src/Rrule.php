<?php

namespace Mmerlijn\Rrule;

use Laravel\Nova\Fields\Field;

class Rrule extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'rrule';

    public function locale(string $language)
    {
        return $this->withMeta(['locale'=>$language]);
    }
    public function hide()
    {
        return $this->withMeta(['hide'=>true]);
    }
}
