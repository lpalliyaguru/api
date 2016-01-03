<?php

namespace AppBundle\Controller;

use AppBundle\Document\User;
use AppBundle\Form\RegisterType;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends FOSRestController
{
    /**
     * @Rest\Post("register")
     */
    public function registerAction(Request $request)
    {
        $user           = new User();
        $userManager    = $this->get('manager.user');
        $form           = $this->get('form.factory')->create(new RegisterType(), $user);
        $json_data      = json_decode($request->getContent(), true);

        $password = $this->get('security.password_encoder')
            ->encodePassword($user, $user->getPlainPassword());

        $user->setPassword($password);
        $form->bind($json_data);

        if($form->isValid()) {
            $userManager->save($user);
            return $user;
        }

        return array(
            'success'   => false,
            'errors'    => $form->getErrors(true, false)
        );

    }

}
