<?php


namespace App\Controller\Admin;


use App\Entity\Settings;
use App\Form\SettingsType;
use App\Repository\SettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class SettingsController extends AbstractController
{
    /**
     * @Route("/admin/settings", name="settings")
     */
    public function editSettings(Request $request,EntityManagerInterface $em, SettingsRepository $repository)
    {
        $settings = $repository->findOneBy([],['id' => 'DESC']);
        $form = $this->createForm(SettingsType::class,$settings);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();

            $em->persist($data);
            $em->flush();

        }

        return $this->render('admin/settings.html.twig',[
            'form' => $form->createView()
        ]);
    }
}