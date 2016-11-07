<?php

namespace Controller;

use Twig_Environment;

/**
 * Class IndexController
 */
class IndexController
{
    private $twig;

    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function indexAction()
    {
        $menuLinks = [
            [
                'href'  => '?controller=database&action=createDatabaseSchema',
                'title' => 'Recreate database',
            ],
            [
                'href'  => '?controller=database&action=fillDatabase',
                'title' => 'Fill database with test data',
            ],

            [
                'href'  => '?controller=university&action=index',
                'title' => 'Universities',
            ],
            [
                'href'  => '?controller=department&action=index',
                'title' => 'Departments',
            ],
//            [
//                'href'  => '?controller=student&action=index',
//                'title' => 'Students',
//            ],
//            [
//                'href'  => '?controller=teacher&action=index',
//                'title' => 'Teachers',
//            ],
//            [
//                'href'  => '?controller=subject&action=index',
//                'title' => 'Subjects',
//            ],
//            [
//                'href'  => '?controller=home_task&action=index',
//                'title' => 'Home tasks',
//            ],
        ];

        return $this->twig->render('index.html.twig', ['links' => $menuLinks]);
    }
}
