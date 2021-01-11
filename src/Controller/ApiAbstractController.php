<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
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
        $requestContent['user_logged'] = null;

        if ($user && $user->getUsername()) {
            $requestContent['user_logged'] = $user->getUsername();
        }

        return new ArrayCollection($requestContent);
    }
}
