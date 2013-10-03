<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Form\Comment as CommentForm;
use Application\Model\CommentService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    /**
     * @var CommentService
     */
    protected $commentService;

    /**
     * @param CommentService $commentService
     */
    function __construct($commentService)
    {
        $this->commentService = $commentService;
    }

    public function indexAction()
    {
        $form = new CommentForm();

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if($form->isValid()) {
                $this->commentService->save($form->getObject());
                $this->redirect('/?referer=' . $this->commentService->getReferer());
            }
        } else {
            $form->bind(new \Application\Model\Comment());
        }

        $form->get('referer')->setValue($this->commentService->getReferer());

        $comments = $this->commentService->fetchAll();

        return new ViewModel(array(
            'form' => $form,
            'comments' => $comments
        ));
    }
}
