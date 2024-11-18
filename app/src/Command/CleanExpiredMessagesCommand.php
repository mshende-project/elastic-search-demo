<?php

namespace App\Command;

use App\Repository\MessageRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:clean-expired-messages',
    description: 'This command will clean expired messages',
)]
class CleanExpiredMessagesCommand extends Command
{
    public function __construct(public MessageRepository $messageRepository)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $expiredMessages = $this->messageRepository->findExpiredMessages();
        if(count($expiredMessages) > 0) {
            foreach ($expiredMessages as $message) {
                $this->messageRepository->remove($message);
            }
            $output->writeln(sprintf('%d expired message(s) cleaned up!', count($expiredMessages)));
        } else {
            $output->writeln('No expired messages to clean up.');
        }

        return Command::SUCCESS;
    }
}
