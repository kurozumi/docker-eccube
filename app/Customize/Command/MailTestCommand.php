<?php

namespace Customize\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * メール送信の疎通確認コマンド。
 *
 *   bin/console customize:mail-test 宛先@example.com
 *
 * MailerInterface 経由で送るため、本番のメール経路をそのまま通る:
 * - messenger.yaml があればキュー（async）に積まれ、worker が SMTP へ送る
 * - なければ同期送信
 * SMTP 設定（MAILER_DSN）の疎通テストや、非同期経路の動作確認に使う。
 */
#[AsCommand(name: 'customize:mail-test', description: 'テストメールを送信する（メール経路の疎通確認）')]
class MailTestCommand extends Command
{
    public function __construct(private readonly MailerInterface $mailer)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('to', InputArgument::REQUIRED, '宛先メールアドレス');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $to = $input->getArgument('to');
        $email = (new Email())
            ->from('noreply@example.com')
            ->to($to)
            ->subject('[mail-test] 疎通確認 '.date('Y-m-d H:i:s'))
            ->text("このメールは customize:mail-test による疎通確認です。\n");

        $this->mailer->send($email);
        $output->writeln(sprintf('<info>送信をディスパッチしました: %s</info>', $to));
        $output->writeln('（messenger 有効時はキュー経由。worker のログと messenger:stats を確認）');

        return Command::SUCCESS;
    }
}
