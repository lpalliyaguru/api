<?php

namespace AppBundle\Controller;

use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class TagsController extends Controller
{

    public function getTagsAllAction(Request $request)
    {
        $resourcePath   = $this->container->getParameter('data_dir');
        $tagsJson       = @json_decode(file_get_contents(sprintf('%s/%s', $resourcePath, 'tags.json')), true);

        return array(
            "total_count"           => 6964,
            "incomplete_results"    => false,
            'items'                  => $tagsJson
        );
    }
}
