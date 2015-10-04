<?php

namespace AppBundle\Service\Manager;


class ManagerBase {


    public function persist($document)
    {
        $this->documentManager->persist($document);

    }

    public function persistAndFlush($document)
    {
        $this->documentManager->persist($document);
        $this->documentManager->flush();
    }
}