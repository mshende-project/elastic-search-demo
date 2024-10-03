<?php

namespace App\Controller;

use App\DTO\ReadMessageDTO;
use App\Entity\Message;
use App\Form\CreateMessageType;
use App\Form\ReadMessageType;
use App\Services\MessageService;
use App\Services\ResponseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageController extends AbstractController
{
    public function __construct(private MessageService $messageService, private ResponseService $responseService, private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'create_message')]
    public function create(Request $request): Response
    {
        $message = new Message();
        $form = $this->createForm(CreateMessageType::class, $message);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {

                if(!$message->getText() && !$message->getRecipient()) {
                    return $this->responseService->createErrorResponse("Please provide a message and recipient", Response::HTTP_BAD_REQUEST);
                }

                $response = $this->messageService->saveMessage($message);
                return $this->responseService->createSuccessResponse($response);
            }

            return $this->render('message/create.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch(\Exception $exception){
            error_log($exception->getMessage());
            return $this->responseService->createErrorResponse("Something went wrong", Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/message/read', name: 'read_message')]
    public function read(Request $request): Response
    {
        $data = new ReadMessageDTO();
        $form = $this->createForm(ReadMessageType::class, $data);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {

                if(!$data->getIdentifier() && !$data->getDecryptionKey()) {
                    return $this->responseService->createErrorResponse("Please provide both identifier and decryption key", Response::HTTP_BAD_REQUEST);
                }

                $messageRepository = $this->entityManager->getRepository(Message::class);
                $message = $messageRepository->findOneBy(['identifier' => $data->getIdentifier()]);

                if (!$message) {
                    return $this->responseService->createErrorResponse("Message has been found read already or not found!", Response::HTTP_NOT_FOUND);
                }

                $response = $this->messageService->decryptMessageAndDeleteAfterRead($message, $data->getDecryptionKey());
                return $this->responseService->createSuccessResponse($response);
            }

            return $this->render('message/read.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            return $this->responseService->createErrorResponse("Something went wrong", Response::HTTP_BAD_REQUEST);
        }
    }
}
