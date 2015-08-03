<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function indexAction(Request $request)
    {
        $postsPerPage = 10;
        $currentPage = (int)$request->get('page');
        $totalCount = $this->getTotalCount();
        $totalPages = ceil($totalCount / $postsPerPage);
        $em = $this->getDoctrine()->getEntityManager();

        if ($totalCount <= $currentPage || !is_numeric($currentPage)) {
            $currentPage = 1;
        }

        if (($currentPage * $postsPerPage) > $totalCount) {
            $currentPage = $totalPages;
        }

        $offset = 0;

        if ($currentPage > 1) {
            $offset = $postsPerPage * ($currentPage - 1);
        }

        $query = $em->createQueryBuilder()
                    ->select('b')
                    ->from('BloggerBlogBundle:Blog', 'b')
                    ->setFirstResult($offset)
                    ->setMaxResults($postsPerPage);

        $result = $query->getQuery()->getResult();

//        $blogs = $em->getRepository('BloggerBlogBundle:Blog')
//            ->getLatestBlogs();

        return $this->render('BloggerBlogBundle:Page:index.html.twig', [
            'blogs' => $result,
            'total_pages' => $totalPages,
            'current_page' => $currentPage
        ]);
    }

    public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }

    public function contactAction(Request $request)
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        if ($request->getMethod() == 'post') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                           ->setSubject('contact enquiry from symblog')
                           ->setFrom('azaholodilo@gmail.com')
                           ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
                           ->setBody($this->renderView('BloggerBlogBundle:Post:contactEmail.txt.twig', compact('enquiry')));
                $this->get('mailer')->send($message);

                $this->get('session')->setFlash('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');

                return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));
            }
        }

        return $this->render('BloggerBlogBundle:Page:contact.html.twig', ['form' => $form->createView()]);
    }

    public function sidebarAction()
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $tags = $em->getRepository('BloggerBlogBundle:Blog')
            ->getTags();

        $tagWeights = $em->getRepository('BloggerBlogBundle:Blog')
            ->getTagWeights($tags);

        $commentLimit   = $this->container
            ->getParameter('blogger_blog.comments.latest_comment_limit');
        $latestComments = $em->getRepository('BloggerBlogBundle:Comment')
            ->getLatestComments($commentLimit);

        return $this->render('BloggerBlogBundle:Page:sidebar.html.twig', array(
            'latestComments'    => $latestComments,
            'tags'              => $tagWeights
        ));
    }

    private function getTotalCount()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $qb = $em->createQueryBuilder();
        $result = $qb->select($qb->expr()->count('b'))
                     ->from('BloggerBlogBundle:Blog', 'b');

        return $result->getQuery()->getSingleScalarResult();
    }

}