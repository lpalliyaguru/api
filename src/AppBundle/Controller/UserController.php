<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProfileType;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserController extends FOSRestController
{


    /**
     * @Rest\Options("user/{id}")
     */
    public function optionsUserAction(Request $request, $id)
    {
        return array();
    }

    /**
     * @Rest\Get("user/{id}")
     */
    public function getUserAction(Request $request, $id)
    {
        $userManager = $this->get('manager.user');

        $view = $this
            ->view($userManager->getOne($id), 200)
            ->setTemplate("AppBundle:User:getUser.html.twig")
            ->setTemplateVar('user')
        ;

        return $view;
    }

    /**
     * Allow options method to the image add endpoint. purpose of this endpoint is to allow CORS
     * @Rest\Options("user/{id}/images")
     * @param $id
     * @return array
     */
    public function optionsUsersImagesAction(Request $request, $id)
    {
        return $this->view(array(), 200);
    }

    /**
     * Add images to the existing property
     * @Rest\Post("user/{id}/images")
     * @return array
     */
    public function postUsersImageAction(Request $request, $id)
    {
        $file           = $request->files->get('file');
        $mediaManager   = $this->get('manager.media');
        $userManager    = $this->get('manager.user');
        $s3Folder       = 'static/images/avatars';
        $cdn            = $this->getParameter('amazon_s3_base_url');

        try {
            $user = $userManager->getOne($id);
            if(!$file instanceof UploadedFile) { throw new \Exception('Not a valid file'); }

            $fileName       = $mediaManager->upload($file, $s3Folder);
            $imageURL       = \sprintf('%s/%s', $cdn, $fileName);
            $user->setProfilePic($imageURL);
            $userManager->save($user);

            return array(
                'success'   => true,
                'image'     => $imageURL
            );
        }
        catch (\Exception $e)
        {
            return array(
                'success'   => false,
                'image'     => $e->getMessage()
            );
        }
    }

    /**
     * Update the property data
     * @Rest\Put("user/{id}")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function putUserAction(Request $request, $id)
    {
        $userManager    = $this->get('manager.user');
        $user           = $userManager->getOne($id);
        $form           = $this->get('form.factory')->createNamed('', new ProfileType(), $user);
        $json_data      = json_decode($request->getContent(), true);

        $form->bind($json_data);

        if($form->isValid()) {
            $userManager->save($user);
            return $user;
        }

        return array(
            'success'   => false,
            'errors'    => $form->getErrors()
        );
    }
}
