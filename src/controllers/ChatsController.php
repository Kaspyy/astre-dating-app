<?php
require_once 'AppController.php';
require_once __DIR__.'/../repository/UserDetailsRepository.php';
require_once __DIR__.'/../repository/UserMessagesRepository.php';
require_once __DIR__.'/../models/Message.php';
require_once __DIR__.'/SessionController.php';

class ChatsController extends AppController
{
    private $id;
    private $userDetailsRepository;
    private $sessionController;
    private $userMessageRepository;

    public function __construct()
    {
        parent::__construct();
        $this->sessionController = new SessionController();
        $this->userDetailsRepository = new UserDetailsRepository();
        $this->userMessageRepository = new UserMessagesRepository();
    }

    public function chats()
    {
        $this->id = $this->sessionController->get("id");
//        $this->userDetailsRepository->insertChat($this->id);
        $userPairs = $this->userDetailsRepository->getPairs($this->id);
        $userChats = $this->userDetailsRepository->getChats($this->id);
        $this->render('chats', ['userChats' => $userChats, 'userPairs' => $userPairs]);
    }


    public function chat()
    {
        $chat_id = $_GET['chat_id'];
        $this->id = $this->sessionController->get("id");
        $receiver = $_POST['receiver_id'];
        $userChatInfo = $this->userDetailsRepository->getChatInfo($this->id, $chat_id);
        $messages = $this->userMessageRepository->getMessages($this->id, $userChatInfo->getId());

        $this->render('chat', ['userChatInfo' => $userChatInfo, 'messages' => $messages]);
    }

    public function chatJS($userId, $receiverId)
    {
        header('Content-type: application/json');
        http_response_code(200);
        echo $this->userMessageRepository->getMessagesJSON($userId, $receiverId);
    }

    public function sendMessage()
    {
        $chat_id = $_GET['chat_id'];
        $this->id = $this->sessionController->get("id");
        $receiver = $_POST['receiver_id'];
        $content = $_POST['message'];
        $userMessage = new Message($this->id, $receiver, $content);
        $this->userMessageRepository->sendMessage($chat_id, $userMessage);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/chat?chat_id={$chat_id}");
    }
    public function sendMessageJS($chatId, $userId, $receiverId)
    {
        header('Content-type: application/json');
        http_response_code(200);

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $this->userMessageRepository->sendMessageJSON($chatId, $userId, $receiverId, $decoded['content']);
        }

    }

}