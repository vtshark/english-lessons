<?php

namespace App\Controller;

use App\Entity\Word;
use App\Form\Word as WordForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class WordsController extends AbstractController
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

    /**
     * @Route("/view/{id}", name="view_word")
     * @param Word $word
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function actionView(Word $word)
    {
        return $this->render('words/view.html.twig', [
            'word' => $word,
        ]);
    }

    /**
     * @Route("/add", name="add_words")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function actionAdd(Request $request)
    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
//        $user = $this->getUser();
//        dump($user); die;

        $word = new Word();
        $form = $this->createForm(WordForm::class, $word);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $word = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($word);
            $em->flush();

            // add flash messages
            $session = new Session();
            //$session->start();
            $session->getFlashBag()->add(
                'success',
                'Saved: ' . $word->getEng() . ' - ' . $word->getRus()
            );

            return $this->redirectToRoute('view_word', ['id' => $word->getId()]);
        }

        return $this->render('words/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/edit/{id}", requirements={"id": "\d+"}, methods={"GET", "POST"}, name="edit_words")
     * @param Request $request
     * @param Word $word
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function actionEdit(Request $request, Word $word)
    {
        $form = $this->createForm(WordForm::class, $word);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $word = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($word);
            $em->flush();

            // add flash messages
            $session = new Session();
            //$session->start();
            $session->getFlashBag()->add(
                'success',
                'Saved: ' . $word->getEng() . ' - ' . $word->getRus()
            );

            return $this->redirectToRoute('view_word', ['id' => $word->getId()]);
        }

        return $this->render('words/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", requirements={"id": "\d+"}, methods={"POST"}, name="delete_words")
     * @param Request $request
     * @param Word $word
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function actionDelete(Request $request, Word $word)
    {

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            throw new \Exception('Error!');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($word);
        $em->flush();

        $session = new Session();
        $session->getFlashBag()->add(
            'success',
            'Deleted: ' . $word->getEng() . ' - ' . $word->getRus()
        );

        return $this->redirectToRoute('show_all_words');
    }

}
