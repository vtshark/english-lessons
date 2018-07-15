<?php

namespace App\Controller;

use App\Entity\Word;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShowWordsController extends Controller
{
    /**
     * @Route("/", name="show_random_words")
     */
    public function actionShowRandom()
    {
        $words = $this->getDoctrine()->getManager()->getRepository(Word::class)->randomWords();
        return $this->render('words/show_random.html.twig', [
            'words' => $words,
        ]);
    }

    /**
     * @Route("/all", name="show_all_words")
     */
    public function actionShowAll()
    {
        $words = $this->getDoctrine()->getManager()->getRepository(Word::class)->findAll();
        return $this->render('words/show_random.html.twig', [
            'words' => $words,
        ]);
    }
}
