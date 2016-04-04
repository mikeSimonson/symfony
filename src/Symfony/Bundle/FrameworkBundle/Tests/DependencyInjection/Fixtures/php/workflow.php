<?php

$container->loadFromExtension('framework', array(
    'workflows' => array(
        'my_workflow' => array(
            'marking_store' => array(
                'type' => 'property_accessor',
            ),
            'supports' => array(
                'Symfony\Bundle\FrameworkBundle\Tests\DependencyInjection\FrameworkExtensionTest',
            ),
            'places' => array(
                'first',
                'last',
            ),
            'transitions' => array(
                'go' => array(
                    'from' => array(
                        'first',
                    ),
                    'to' => array(
                        'last',
                    ),
                ),
            ),
        ),
    ),
));
