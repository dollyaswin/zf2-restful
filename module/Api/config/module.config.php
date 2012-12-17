<?php
namespace Api;

return array(
    'controllers' => array(
        'invokables' => array(
            'Api\Controller\Book'  => 'Api\Controller\BookController',
         ),
    ),
    'router' => array(
        'routes' => array(
            'api' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/api',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Api\Controller',
                        'controller'    => 'Book',
                        //'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route' => '/[:controller][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),

    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'api' => __DIR__ . '/../view',
        ),
        'strategies' => array(
        	'ViewJsonStrategy'
        )
    ),
);
