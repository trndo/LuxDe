<?php

namespace App\Controller;

use App\DTO\EditDTO;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\EditType;
use App\Repository\ArticleRepository;
use App\Repository\MailRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Mapping\Annotation\Slug;
use Gedmo\Mapping\Annotation\SlugHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin/create", name="create")
     */
    public function createArticle(EntityManagerInterface $em,Request $request,FileUploader $fileUploader)
    {
        $form = $this->createForm(ArticleType::class);

        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){
                /** @var Article $data */
                $data = $form->getData();
                $img = $data->getImagePath();
                try {
                    if ($imgName = $fileUploader->upload($img)) {
                        $data->setImagePath($imgName);
                    }
                }catch (FileException $exception){

                    $this->addFlash('danger','Check your img!');
                    return $this->redirectToRoute('admin');

                }

                $em->persist($data);
                $em->flush();

                $this->addFlash('success','Статья создана!');

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/home.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/mail", name="mail")
     */
    public function showMails(MailRepository $repository)
    {
        $messages = $repository->findBy([],['id' => 'DESC']);

        return $this->render('admin/journal.html.twig',[
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function showArticles(ArticleRepository $repository)
    {
        $article = $repository->findBy([],['id' => 'DESC']);

        return $this->render('admin/article.html.twig',[
            'articles' => $article,
        ]);
    }

    /**
     * @Route("/admin/{slug}/edit", name="edit")
     */
    public function editArticle(Request $request,EntityManagerInterface $em,Article $article,FileUploader $fileUploader)
    {
        $dto = new EditDTO();
        $dto->setName($article->getName())
            ->setText($article->getText());

        $form = $this->createForm(EditType::class,$dto);

        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){

                $data = $form->getData();
                $img = $data->getFile();
                try {
                    if ($img instanceof UploadedFile) {
                        $imgName = $fileUploader->upload($img);
                        unlink($fileUploader->getUploadDir().$article->getImagePath());
                        $article->setImagePath($imgName);
                    }
                }catch (FileException $exception){
                    $this->addFlash('danger','Check your img');
                    return $this->redirectToRoute('admin');
                }
                $article->setText($dto->getText())
                    ->setName($dto->getName());

                $em->flush();

                $this->addFlash('success','Статья обновлена!');

                return $this->redirectToRoute('admin');

            }
        return $this->render('admin/edit.html.twig',[
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * @Route("/admin/delete/{slug}", name="delete")
     */
    public function deleteArticle(Article $article,EntityManagerInterface $em,FileUploader $fileUploader)
    {

        $em->remove($article);

        if(file_exists($fileUploader->getUploadDir().$article->getImagePath())){
            unlink($fileUploader->getUploadDir().$article->getImagePath());
        }

        $em->flush();

        return $this->redirectToRoute('admin');

    }
}
