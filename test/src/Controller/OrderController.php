<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use App\Entity\Client;
use App\Entity\Order;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;


class OrderController extends Controller
{
    /**
     * @Route("/order", name="order")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/OrderController.php',
        ]);
    }

    /**
     * @Route("/order/add",name="add_order", Methods={"POST"})
     */
    public function addOrder(Request $request)
    {

        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();

        $client = new Client();
        $client->setName($data['name']);
        $client->setLastName($data['lastName']);
        $client->setEmail($data['email']);
        $client->setPhone($data['phone']);
        $order = new Order();
        $order->setClient($client);
        $order->setDeliveryDate(new \DateTime($data['deliveryDate']));
        $order->setOrderAddress($data['orderAddress']);
        $order->setDeliveryHour(new \DateTime($data['deliveryHour']));
        $hour = $order->getDeliveryHour()->format('H');
        $minutes = $order->getDeliveryHour()->format('i');
        $seconds = $order->getDeliveryHour()->format('s');

        if ($hour > 8 || ($hour == 8 && $minutes > 0) || ($hour == 8 && $seconds > 0)) {
            return new JsonResponse(array('message' => 'The delivery waiting time cannot be more than 8 hours'));
        }

        try {
            $em->persist($order);
            $em->flush();
        } catch (UniqueConstraintViolationException $e) {
            return new JsonResponse(array('message' => 'This email is registered'));
        }

        $this->assignOrder($order);

        return new JsonResponse(array('message' => 'Order added!'));
    }

    public function assignOrder($orderId)
    {
        $em = $this->getDoctrine()->getManager();

        $order = $em->getRepository('App:Order')->findOneBy(['id' => $orderId]);

        if (!empty($order->getDriver())) {
            return new Response('<h2>There is a driver for this order!</h2>');
        }

        if (!$order) {
            throw $this->createNotFoundException(
                'No order found for id ' . $orderId
            );
        }

        $drivers = $em->getRepository('App:Driver')->findAll();

        if (sizeof($drivers) == 0) {
            throw $this->createNotFoundException(
                'There is no driver registered'
            );
        }

        $drivers[rand(0, sizeof($drivers) - 1)]->addOrder($order);

        $em->flush();
    }


    /**
     * @Route("/orders",name="list_orders", Methods={"POST"})
     */
    public function getOrdersByDriverAndDate(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();

        $orders = $em->getRepository('App:Order')->findByDriverIdAndDate($data['driverId'], $data['deliveryDate']);

        if (!$orders) {
            return new JsonResponse(['message' => "There is not orders for this driver or date"]);
        }

        return new JsonResponse($orders);

    }


}
