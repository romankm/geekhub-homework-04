<?php

namespace Controller;

use Database\Connector;
use Repository\DepartmentRepository;
use Repository\UniversityRepository;
use Twig_Environment;

/**
 * Class DepartmentController
 */
class DepartmentController
{
    private $twig;
    private $repository;

    public function __construct(Twig_Environment $twig, Connector $connector)
    {
        $this->twig = $twig;
        $this->repository = new DepartmentRepository($connector);
        $this->universityRepository = new UniversityRepository($connector);
    }

    public function indexAction()
    {
        $items = $this->repository->findAll();

        return $this->twig->render('department_index.html.twig', ['items' => $items]);
    }

    public function newAction()
    {
        if ($_POST['submit_button'] === 'OK') {
            $entityData = [
                'name'         => $_POST['name'],
                'universityId' => $_POST['university_id'],
            ];

            $this->repository->insert($entityData);

            $this->redirectToIndex();
        }

        $universities = $this->universityRepository->findAll();

        return $this->twig->render(
            'department.html.twig',
            [
                'action' => 'new',
                'universities' => $universities,
            ]
        );
    }

    public function editAction()
    {
        if ($_POST['submit_button'] === 'OK') {
            $entityData = [
                'name'         => $_POST['name'],
                'universityId' => $_POST['university_id'],
            ];

            $this->repository->update($entityData);

            $this->redirectToIndex();
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $entity = $this->repository->find($id);
            $universities = $this->universityRepository->findAll();

            return $this->twig->render(
                'department.html.twig',
                [
                    'action'     => 'edit',
                    'department' => $entity,
                    'universities' => $universities,
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
                'controller' => 'department',
                'id'         => $_GET['id'],
            ]
        );
    }

    private function redirectToIndex()
    {
        FrontController::redirect('?controller=department&action=index');
    }
}