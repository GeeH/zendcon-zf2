<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\IndexController;
use Application\Model\Comment;
use Application\Model\CommentService;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\ClassMethods;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        /* @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $event->getRequest();
        if (is_null($request->getServer('HTTP_REFERER')) && is_null($request->getPost('referer'))
            && is_null($request->getQuery('referer'))
        ) {
            throw new \Exception('REFERER is not set!');
        }

        /* @var \Application\Model\CommentService $commentService */
        $commentService = $event->getApplication()->getServiceManager()->get('Application\Model\CommentService');

        if(!is_null($request->getPost('referer'))) {
            $commentService->setReferer($request->getPost('referer'));
            return true;
        }

        if(!is_null($request->getQuery('referer'))) {
            $commentService->setReferer($request->getQuery('referer'));
            return true;
        }

        if(!is_null($request->getServer('HTTP_REFERER'))) {
            $commentService->setReferer($request->getServer('HTTP_REFERER'));
            return true;
        }

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Application\Controller\Index' => function (ControllerManager $controllerManager) {
                    $commentService = $controllerManager->getServiceLocator()->get('Application\Model\CommentService');
                    return new IndexController($commentService);
                }
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
                'Application\Model\CommentService' => function (ServiceManager $serviceManager) {
                    $commentTable = $serviceManager->get('Application\Model\CommentTable');
                    return new CommentService($commentTable);
                },
                'Application\Model\CommentTable' => function (ServiceManager $serviceManager) {
                    $dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
                    $hydrator = new ClassMethods();
                    $rowObjectPrototype = new Comment();
                    $resultSet = new HydratingResultSet($hydrator, $rowObjectPrototype);
                    $tableGateway = new TableGateway('comment', $dbAdapter, null, $resultSet);
                    return $tableGateway;
                }
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'DayDifference' => 'Application\View\Helper\DayDifference',
            ),
        );
    }
}
