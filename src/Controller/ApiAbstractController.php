<?php

namespace App\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiAbstractController extends AbstractController
{
    /**
     * @param Request $request
     * @return ArrayCollection
     */
    public function getRequestContent(Request $request): ArrayCollection
    {
        $user = $this->getUser();
        $requestContent = json_decode($request->getContent(), true);
        $requestContent['user_logged'] = $user->getUsername() ?? null;

        return new ArrayCollection($requestContent);
    }
}
