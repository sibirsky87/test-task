<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\CalcForm;
use Application\Model\CalcModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $form    = new CalcForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $calculator = new CalcModel();
            $form->setInputFilter($calculator->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $form->get('formula')->setValue($form->getData()['formula']);
            }
        }
        return new ViewModel(["form" => $form]);
    }

    public function calcAction()
    {

        $form = new CalcForm();
        $form->get('submit');

        $request       = $this->getRequest();
        $callback      = $request->getQuery()->callback;
        $methodRequest = $callback ? $request->getQuery() : $request->getPost();

        $result     = [];
        $calculator = new CalcModel();
        $form->setInputFilter($calculator->getInputFilter());
        $form->setData($methodRequest);

        if ($form->isValid()) {
            $calculator->exchangeArray($form->getData());

            try {
                $result['amount'] = $calculator->getResult();
            } catch (\Exception $exc) {
                $result['error'] = $exc->getMessage();
            }
        } else {
            $result['error'] = $form->getMessages();
        }
        $response = new JsonModel($result);

        if (is_string($callback) && !empty($callback)) {
            $response->setJsonpCallback($callback);
        }


        return $response;
    }

}
