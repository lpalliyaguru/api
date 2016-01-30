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
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\Constraints\Null;

class PropertiesController extends FOSRestController
{
	/**
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get Properties",
     * )
     * @Rest\Get("properties")
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
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Search a  property based on different criteria",
     *  parameters={
     *      {"name"="places", "dataType"="string", "required"=true, "description"="place of the property"},
     *      {"name"="rent", "dataType"="string", "required"=true, "description"="rent- Search Type"},
     *      {"name"="sale", "dataType"="string", "required"=true, "description"="sale - Search Type"},
     *  }
     * )
     * @Rest\Get("properties/search")
	 */
    public function getPropertiesSearchAction(Request $request)
    {
        $propertyManager    = $this->get('manager.property');
        $placeManager       = $this->get('manager.place');

        $placeIdList    = $request->query->get('places');
        $rent           = $request->query->get('rent');
        $sale           = $request->query->get('sale');
        $placeIdList    = explode(',', $placeIdList);

        $places      = array_filter($placeIdList) ? $placeManager->getPlacesByIds($placeIdList) : $placeManager->getAll();
        $properties  = $propertyManager->searchProperties($places, $rent, $sale);

        return array(
            'properties' => $properties,
        );
    }

    /**
     * Allow options method to the update property endpoint. purpose of this endpoint is to allow CORS
     * @Rest\Options("properties/{id}")
     * @param $id
     * @return array
     */
    public function optionsPutPropertiesAction($id)
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
     *  description="Update the property data",
     *  parameters={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="id of the property"},
     *  }
     * )
     * @Rest\Put("properties/{id}")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function putPropertiesAction(Request $request, $id)
    {
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
     * Allow options method to the property create endpoint. purpose of this endpoint is to allow CORS
     * @Rest\Options("properties")
     * @return array
     */
    public function optionsPostPropertiesAction()
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
     *  description="Create the property object"
     * )
     * @Rest\Post("properties")
     * @param Request $request
     * @return array
     */
    public function postPropertiesAction(Request $request)
    {
        $propertyManager    = $this->get('manager.property');
        $property         = $propertyManager->addProperty();

        $view = $this
            ->view($property, 200)
            ->setTemplate("AppBundle:Properties:getProperty.html.twig")
            ->setTemplateVar('property')
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
     *  description="Get the property object",
     *  parameters={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="id of the property"},
     *  }
     * )
     * @Rest\Get("properties/{id}")
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
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Allow options method to the image add endpoint. purpose of this endpoint is to allow CORS",
     *  parameters={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="id of the property"},
     *      {"name"="image", "dataType"="string", "required"=true, "description"="image of the property"},
     *  }
     * )
     * @Rest\Options("properties/{id}/images")
     * @param $id
     * @return array
     */
    public function optionsPropertiesImagesAction(Request $request, $id)
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
     *  description="Add images to the existing property",
     *  parameters={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="id of the property"},
     *      {"name"="image", "dataType"="string", "required"=true, "description"="image of the property"},
     *  }
     * )
     * @Rest\Post("properties/{id}/images")
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
