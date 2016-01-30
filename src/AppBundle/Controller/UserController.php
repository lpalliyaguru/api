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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

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
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get the user information",
     *  parameters={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="user id"},
     *  }
     * )
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
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Allow options method to the image add endpoint. purpose of this endpoint is to allow CORS",
     * )
     * @Rest\Options("user/{id}/images")
     * @param $id
     * @return array
     */
    public function optionsUsersImagesAction(Request $request, $id)
    {
        return $this->view(array(), 200);
    }

    /**
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Add the user image",
     *  parameters={
     *      {"name"="file", "dataType"="file", "required"=true, "description"="image of user"},
     *  }
     * )
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
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Update the user data",
     *  parameters={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="id of user"},
     *  }
     * )
     * @Rest\Put("user/{id}")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function putUserAction(Request $request, $id)
    {
        $userManager    = $this->get('manager.user');
        $security       = $this->get('security.context');
        $updatingUser   = $userManager->getOne($id);
        $form           = $this->get('form.factory')->createNamed('', new ProfileType(), $updatingUser);
        $json_data      = json_decode($request->getContent(), true);
        $sessionUser    = $security->getToken()->getUser();

        try {

            if(!$sessionUser instanceof UserInterface || $sessionUser->getId() !== $updatingUser->getId()) { throw new \Exception('Not authorized', 403); }
            $form->bind($json_data);

            if($form->isValid()) {
                $userManager->save($updatingUser);
                return $updatingUser;
            }

            return array(
                'success'   => false,
                'errors'    => $form->getErrors()
            );
        }
        catch(\Exception $e)
        {
            return $this->view(array(
                'success'   => false,
                'message'   => $e->getMessage()
                ),
                $e->getCode()
            );
        }
    }
}
