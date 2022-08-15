<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Message;
use App\Entity\Rappel;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use App\Repository\MessageRepository;
use App\Repository\RappelRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use PDO;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('')]
class MessageController extends AbstractController
{   
    protected $bdd;
    public function __construct()
    {
        $this->bdd = new PDO('mysql:host=localhost;dbname=auto_ecole','root','');
    }
    

    #[Route('/Message/envoi', name: 'app_message')]
    public function EnvoiMessage(MessageRepository $messageRepository)
    {
        $message = new Message();

        
        $form = $this->createForm(TransactionType::class, $message);
        $message->setContenu($_REQUEST["Message"]);
        $message->setRecuPar($_REQUEST["RecuPar"]);
        $message->setEnvoyerPar($_REQUEST["EnvoyerPar"]);
        $message->setDateEnvoi("16042051");
         
        $messageRepository->add($message,true);
    }
    
    
    
    }












