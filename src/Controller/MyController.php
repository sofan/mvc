<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MyController extends AbstractController
{
    #[Route('/', name: "me")]
    public function mePage(): Response
    {
        return $this->render('me.html.twig');
    }


    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }


    #[Route('/report', name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }


    #[Route('/lucky', name: "lucky")]
    public function lucky(): Response
    {
        $number = random_int(1, 100);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky.html.twig', $data);
    }


    #[Route('/api', name: "api")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }

    #[Route("/session", name: "session_info")]
    public function sessionShow(SessionInterface $session): Response
    {
        $allSessions = $session->all();

        $data = [
            "sessionData" => $allSessions
        ];

        return $this->render('session.html.twig', $data);
    }



    #[Route("/session/delete", name: "session_delete")]
    public function sessionDelete(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash(
            'notice',
            'Sessionen är raderad!'
        );

        return $this->redirectToRoute('session_info');
    }


    #[Route('/metrics', name: "metrics")]
    public function metrics(): Response
    {
        return $this->render('metrics/metrics.html.twig');
    }

}
