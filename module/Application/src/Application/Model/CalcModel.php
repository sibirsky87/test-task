<?php

/**
 * Anton Baykov - Mar 18, 2016
 */

namespace Application\Model;

use Zend\Validator;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use FormulaInterpreter\Compiler;

/**
 * Description of CalcModel
 */
class CalcModel implements InputFilterAwareInterface
{

    /**
     * Формула
     * @var string 
     */
    public $formula;

    /**
     * Фильтр фходных данных
     * @var InputFilterInterface 
     */
    protected $inputFilter;

    /**
     * Ввод запроса
     * @param array $data
     */
    public function exchangeArray($data)
    {
        $this->formula = (isset($data['formula'])) ? $data['formula'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    /**
     * Формирование фильтра данных
     * @return InputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $formula     = new Input("formula");
            $formula->getValidatorChain()
                    ->attach(new Validator\NotEmpty)
                    ->attach(new Validator\StringLength(3, 100));
            $inputFilter->add($formula);

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function getResult()
    {
        $compiler = new Compiler();
        return $compiler->compile($this->formula)->run();
    }

}
