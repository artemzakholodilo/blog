<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends  Controller
{
    public function showAction(Request $request, $id, $slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException();
        }

        $comments = $em->getRepository('BloggerBlogBundle:Comment')
            ->getCommentsForBlog($blog->getTitle());

        return $this->render('BloggerBlogBundle:Page:show.html.twig', compact('blog', 'comments'));
    }
}