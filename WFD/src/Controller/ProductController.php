<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/product/create/{description}/{price}", name="product_create")
     * @param $description
     * @param $price
     * @return Response
     */
  public function createAction($description, $price)
  {
      //create new product object
      $product = new Product();
      $product->setDescription($description);
      $product->setPrice($price);

      //persist (save/store) this object's contents to the database
      $em = $this->getDoctrine()->getManager();
      $em->persist($product);
      $em->flush();

      return new Response('Saved new product with id ' .$product->getId());

  }
}
