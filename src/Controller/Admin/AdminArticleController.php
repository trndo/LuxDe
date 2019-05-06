<?php

declare(strict_types=1);

/*
 * This file is part of the "LuxDe School" package.
 * (c) Gopkalo Vitaliy <trndogv@gmail.com>
 */

namespace App\Controller\Admin;

use App\DTO\EditDTO;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\EditType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminArticleController extends AbstractController
{
    /**
     * @Route("/admin/create", name="create")
     */
    public function createArticle(EntityManagerInterface $em, Request $request, FileUploader $fileUploader)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $data */
            $data = $form->getData();
            $img = $data->getImagePath();
            try {
                if ($imgName = $fileUploader->upload($img)) {
                    $data->setImagePath($imgName);
                }
            } catch (FileException $exception) {
                $this->addFlash('danger', 'Check your img!');

                return $this->redirectToRoute('admin');
            }

            $em->persist($data);
            $em->flush();

            $this->addFlash('success', 'Статья создана!');

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/home.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{slug}/edit", name="edit")
     */
    public function editArticle(Request $request, EntityManagerInterface $em, Article $article, FileUploader $fileUploader)
    {
        $dto = new EditDTO();
        $dto->setName($article->getName())
            ->setText($article->getText());

        $form = $this->createForm(EditType::class, $dto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $img = $data->getFile();
            try {
                if ($img instanceof UploadedFile) {
                    $imgName = $fileUploader->upload($img);
                    \unlink($fileUploader->getUploadDir() . $article->getImagePath());
                    $article->setImagePath($imgName);
                }
            } catch (FileException $exception) {
                $this->addFlash('danger', 'Check your img');

                return $this->redirectToRoute('admin');
            }
            $article->setText($dto->getText())
                    ->setName($dto->getName());

            $em->flush();

            $this->addFlash('success', 'Статья обновлена!');

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edit.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
        ]);
    }

    /**
     * @Route("/admin/delete/{slug}", name="delete")
     */
    public function deleteArticle(Article $article, EntityManagerInterface $em, FileUploader $fileUploader)
    {
        $em->remove($article);

        if (\file_exists($fileUploader->getUploadDir() . $article->getImagePath())) {
            \unlink($fileUploader->getUploadDir() . $article->getImagePath());
        }

        $em->flush();

        return $this->redirectToRoute('admin');
    }
}
