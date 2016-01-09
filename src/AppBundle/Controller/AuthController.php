<?php

namespace AppBundle\Controller;

use AppBundle\Document\AccessToken;
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
        $tokenManager   = $this->get('manager.api_token');
        $form           = $this->get('form.factory')->create(new RegisterType(), $user);
        $json_data      = json_decode($request->getContent(), true);

        $password = $this->get('security.password_encoder')
            ->encodePassword($user, $user->getPlainPassword());

        $user->setPassword($password);
        $form->bind($json_data);

        if($form->isValid()) {

            $token = new AccessToken();
            $token->setAccessToken('1234abcd');
            $token->setRefreshToken('1234xyz');
            $token->setExpires(new \DateTime('2016-02-04'));
            $token->setUser($user);
            $userManager->save($user);
            $tokenManager->save($token);
            return $user;
        }

        return array(
            'success'   => false,
            'errors'    => $form->getErrors(true, false)
        );

    }

}
