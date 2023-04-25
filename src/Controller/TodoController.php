<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(TodoRepository $todoRepository): Response{
        $todos = $todoRepository->findAll();
        dump($todos);

        return $this->render('todo/index.html.twig', [
            'todos' => $todos,
        ]);
    }

    #[Route('/todo/show/{id}', name: 'todo_show')]
    public function show(Todo $todo){

        return $this->render('todo/show.html.twig',[
            'todo'=>$todo
        ]);
    }

    #[Route('/todo/delete/{id}', name: 'todo_delete')]
    public function delete(Todo $todo, EntityManagerInterface $manager){
        if($todo){
            $manager->remove($todo);
            $manager->flush();
        }

        return $this->redirectToRoute('app_todo');
    }

    #[Route('/todo/create', name: 'todo_create')]
    public function create(){


        return $this->renderForm('todo/create.html.twig', [        ]);
    }
}
