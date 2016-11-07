<?php

namespace Controller;

use Database\Connector;
use Repository\UniversityRepository;
use Twig_Environment;

/**
 * Class UniversityController
 */
class UniversityController
{
    private $twig;
    private $repository;

    public function __construct(Twig_Environment $twig, Connector $connector)
    {
        $this->twig = $twig;
        $this->repository = new UniversityRepository($connector);
    }

    public function indexAction()
    {
        $items = $this->repository->findAll();

        return $this->twig->render('university_index.html.twig', ['items' => $items]);
    }

    public function newAction()
    {
        if ($_POST['submit_button'] === 'OK') {
            $entityData = [
                'name' => $_POST['name'],
                'city' => $_POST['city'],
                'site' => $_POST['site'],
            ];

            $this->repository->insert($entityData);

            $this->redirectToIndex();
        }

        return $this->twig->render('university.html.twig', ['action' => 'new']);
    }

    public function editAction()
    {
        if ($_POST['submit_button'] === 'OK') {
            $entityData = [
                'id'   => $_POST['id'],
                'name' => $_POST['name'],
                'city' => $_POST['city'],
                'site' => $_POST['site'],
            ];

            $this->repository->update($entityData);

            $this->redirectToIndex();
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $entity = $this->repository->find($id);

            return $this->twig->render(
                'university.html.twig',
                [
                    'action'     => 'edit',
                    'university' => $entity,
                ]
            );
        }
    }

    public function deleteAction()
    {
        if ($_POST['submit_button'] === 'Cancel') {
            $this->redirectToIndex();
        }

        if (isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $this->repository->remove($id);

            $this->redirectToIndex();
        }

        return $this->twig->render(
            'confirm_delete.html.twig',
            [
                'controller' => 'university',
                'id'         => $_GET['id'],
            ]
        );
    }

    private function redirectToIndex()
    {
        FrontController::redirect('?controller=university&action=index');
    }
}
