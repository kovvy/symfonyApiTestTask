<?php

namespace ApiBundle\Controller;

use Doctrine\DBAL\Schema\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ApiBundle\Entity\Request as RequestModel;

class RequestController extends Controller
{

    public function listAction()
    {

        return $this->json([
            'success' => 'true',
            'requests' => $this->instanceRepository()->findAll()
        ], 200);
    }

    public function getAction($id)
    {
        $request = $this->instanceRepository()->find($id);

        if (empty($request)) {
            throw new NotFoundHttpException('Request not found');
        }

        return $this->json([
            'success' => 'true',
            'request' => $request
        ], 200);
    }

    public function getInfoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT r
            FROM ApiBundle:Request r
            WHERE r.body LIKE :search AND r.method = :method'
        );
        $query->setParameter('search', '%' . $request->get('search') . '%');
        $query->setParameter('method', $request->get('method'));

        if (!$request = $query->getResult())
        {
            throw new NotFoundHttpException('Requests not found');
        }

        return $this->json([
            'success' => 'true',
            'requests' => $this->instanceRepository()->getRecord($request)
        ], 200);

    }

    public function storeAction(Request $request)
    {
        $requestModel = new RequestModel();

        $requestModel->setHeaders(json_encode($request->headers->all()));
        $requestModel->setBody($request->getContent());
        $requestModel->setRoute($request->get('route'));
        $requestModel->setMethod($request->getMethod());
        $requestModel->setIp($request->server->get('REMOTE_ADDR'));
        $requestModel->setCreated(date_create());

        $validator = $this->get('validator');
        $errors = $validator->validate($requestModel);;

        if (count($errors) > 0) {

            return $this->json([
                    'success' => 'false',
                    'message' => 'reason of fail'
            ], 404);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($requestModel); //$em is an instance of EntityManager
        $em->flush();

        return $this->json([
            'success' => 'true',
            'id' => $requestModel->getId()
        ], 200);

    }

    public function newAction()
    {
        return $this->processForm(new RequestModel());
    }

    public function editAction(RequestModel $requestModel)
    {
        return $this->processForm($requestModel);
    }

    public function removeAction(RequestModel $requestModel)
    {
        $requestModel->delete();
    }

    public function patchAction(RequestModel $requestModel, Request $request)
    {
        $parameters = array();

        foreach ($request->request->all() as $k => $v) {
            if (in_array($k, array('email'))) {
                $parameters[$k] = $v;
            }
        }

        if (0 === count($parameters)) {
            return View::create(
                array('errors' => array('Invalid parameters.')), 400
            );
        }

        $user->fromArray($parameters);
        $errors = $this->get('validator')->validate($user);

        if (0 < count($errors)) {
            return View::create(array('errors' => $errors), 400);
        }

        $requestModel->save();

        $response = new Response();
        $response->setStatusCode(204);
        $response->headers->set('Location',
            $this->generateUrl(
                'api_request_get', array('id' => $requestModel->getId()),
                true
            )
        );

        return $response;
    }

    protected function instanceRepository($repositoryName = 'ApiBundle:Request')
    {
        return $this->getDoctrine()->getRepository($repositoryName);
    }

    private function processForm(RequestModel $requestModel)
    {
        $statusCode = $requestModel->isNew() ? 201 : 204;

        $form = $this->createForm(new RequestModel(), $requestModel);
        $form->bind($this->getRequest());

        if ($form->isValid()) {
            $requestModel->save();

            $response = new Response();
            $response->setStatusCode($statusCode);
            $response->headers->set('Location',
                $this->generateUrl(
                    'api_request_get', array('id' => $requestModel->getId()),
                    true
                )
            );

            return $response;
        }

        return View::create($form, 400);
    }
}
