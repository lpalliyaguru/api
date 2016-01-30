<?php

namespace AppBundle\Controller;

use AppBundle\Document\AccessToken;
use AppBundle\Document\User;
use AppBundle\Form\RegisterType;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class AuthController extends FOSRestController
{
    /**
     * CORS setting
     * @Rest\Options("login")
     */
    public function optionsLoginAction(Request $request)
    {
    }

    /**
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Login To API",
     *  parameters={
     *      {"name"="email", "dataType"="string", "required"=true, "description"="email of the account"},
     *      {"name"="password", "dataType"="string", "required"=true, "description"="password of the account"}
     *  }
     * )
     * @Rest\Post("login")
     */
    public function postLoginAction(Request $request)
    {
        $email      = $request->request->get('email');
        $password   = $request->request->get('password');
        $userAgent  = $request->headers->get('User-Agent');

        $encoderFactory = $this->get('security.encoder_factory');
        $userManager    = $this->get('manager.user');
        $tokenManager   = $this->get('manager.api_token');
        $user           = $userManager->getOneByEmail($email);

        if($user) {
            $encoder = $encoderFactory->getEncoder($user);
            $validPassword = $encoder->isPasswordValid(
                $user->getPassword(),
                $password,
                $user->getSalt()
            );

            if($validPassword) {
                $accessToken = $tokenManager->createNewToken($user, $userAgent);
            }

            return array( 'access_token' => $accessToken, 'success' => true, 'user' => $user);
        }

        return array();

    }

    /**
     * CORS setting
     * @Rest\Options("register")
     */
    public function optionsRegisterAction(Request $request)
    {
    }

    /**
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     * @ApiDoc(
     *  resource=true,
     *  description="User Account Registration API",
     *  parameters={
     *      {"name"="firstname", "dataType"="string", "required"=true, "description"="firstname of the account"},
     *      {"name"="lastname", "dataType"="string", "required"=true, "description"="lastname of the account"},
     *      {"name"="password", "dataType"="string", "required"=true, "description"="password of the account"},
     *      {"name"="image",    "dataType"=".jpeg,png", "required"=true, "description"="profile picture of the account"}
     *  }
     * )
     * @Rest\Post("register")
     */
    public function postRegisterAction(Request $request)
    {
        $user           = new User();
        $userManager    = $this->get('manager.user');
        $tokenManager   = $this->get('manager.api_token');
        $encryptor      = $this->get('app.encryptor');
        $encoderFactory = $this->get('security.encoder_factory');
        $form           = $this->get('form.factory')->create(new RegisterType(), $user);
        $json_data      = json_decode($request->getContent(), true);
        $form->bind($json_data);

        if($form->isValid()) {
            $encoder    = $encoderFactory->getEncoder($user);
            $salt       = $encryptor->encrypt($user->getFirstName(). $user->getLastName());
            $user->setSalt($salt);
            $password   = $encoder->encodePassword($user->getPlainPassword(), $user->getSalt());
            $user->setPassword($password);
            $user->setProfilePic('/images/avatar.png');
            $userManager->save($user);

            return array(
                'success' => true,
                'user'    => $user
            );
        }

        return array(
            'success'   => false,
            'errors'    => $form->getErrors(true, false)
        );

    }
}
