<?php

/**
 * Anton Baykov - Mar 18, 2016
 */

namespace Application\Form;

use Zend\Form\Form;

class CalcForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('calc');

        $this->add(array(
            'name'    => 'formula',
            'type'    => 'Text',
            'options' => array(
                'label' => 'Формула',
            ),
        ));
        
        
        $this->add(array(
            'id'    => 'result',
            'type'    => 'Text',
            'disabled'    => 'disabled',
            'options' => array(
                'label' => 'Результат',
            ),
        ));

        $this->add(array(
            'type'       => 'Submit',
            'attributes' => array(
                'value' => 'Рассчитать',
            ),
        ));

        $this->setAttribute("method", "POST");
    }

}
