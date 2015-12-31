<?php

namespace AppBundle\Controller;

use AppBundle\Document\Location;
use AppBundle\Document\Property;
use AppBundle\Form\PropertyType;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Document\PropertyAsset;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PropertiesController extends FOSRestController
{
	/**
     * @Get("properties")
     */
    public function getPropertiesAction(Request $request)
    {
        $propertyManager = $this->get('manager.property');

        $view = $this
            ->view($propertyManager->getAll(), 200)
            ->setTemplate("AppBundle:Properties:getProperties.html.twig")
            ->setTemplateVar('properties')
        ;

        return $view;
    }

	/**
     * @Get("properties/search")
	 */
    public function getPropertiesSearchAction(Request $request)
    {
        $propertyManager    = $this->get('manager.property');
        $placeManager       = $this->get('manager.place');

        $placeIdList    = $request->query->get('places');
        $rent           = $request->query->get('rent');
        $sale           = $request->query->get('sale');
        $placeIdList    = explode(',', $placeIdList);

        $places = $placeManager->getPlacesByIds($placeIdList);

        $properties = $propertyManager->searchProperties($places, $rent, $sale);

        return array(
            'properties' => $properties,
        );
    }

    /**
     * @Options("properties/{id}")
     * @param $id
     * @return array
     */
    public function optionsPutPropertiesAction($id)
    {
        return array();
    }

    /**
     * @Put("properties/{id}")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function putPropertiesAction(Request $request, $id)
    {
        $data               = $request->getContent();
        $propertyManager    = $this->get('manager.property');
        $property           = $propertyManager->getOneById($id);
        $form               = $this->get('form.factory')->createNamed('', new PropertyType(), $property);
        $json_data          = json_decode($request->getContent(),true);

        $form->bind($json_data);

        if($form->isValid()) {
            $propertyManager->save($property);
            return $property;
        }
 
		return array(
            'success'   => false,
            'errors'    => $form->getErrors()
        );
    }

    /**
     * @Options("properties")
     * @return array
     */
    public function optionsPostPropertiesAction()
    {
        return array();
    }
    /**
     * @Post("properties")
     * @param Request $request
     * @return array
     */
    public function postPropertiesAction(Request $request)
    {
        $propertyManager    = $this->get('manager.property');
        $properties         = $propertyManager->addProperties();

        return array(
            'properties' => $properties,
        );
    }

    /**
     * @Get
     * @Route("properties/{id}")
     */
    public function getPropertyAction($id)
    {
        $propertyManager = $this->get('manager.property');

        $view = $this
            ->view($propertyManager->getOneById($id), 200)
            ->setTemplate("AppBundle:Properties:getProperty.html.twig")
            ->setTemplateVar('property')
        ;

        return $view;
    }

    /**
     * @Options
     * @param $id
     * @return array
     */
    public function optionsPropertiesImagesAction(Request $request, $id)
    {
        return $this->view(array(), 200);
    }

    /**
     * @Post
     * @return array
     */
    public function postPropertiesImageAction(Request $request, $id)
    {
        $file           = $request->files->get('file');
        $mediaManager   = $this->get('manager.media');
        $propertyManger = $this->get('manager.property');
        $s3Folder       = 'static/images/properties';
        $cdn            = $this->getParameter('amazon_s3_base_url');

        try {
            $property = $propertyManger->getOneById($id);

            if(!$file instanceof UploadedFile) { throw new \Exception('Not a valid file'); }

            $fileName       = $mediaManager->upload($file, $s3Folder);
            $imageURL       = \sprintf('%s/%s', $cdn, $fileName);
            $property->getAsset()->addImage($imageURL);
            $propertyManger->save($property);

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
}
