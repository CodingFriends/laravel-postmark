<?php

namespace Coconuts\Mail;

use Illuminate\Notifications\Messages\MailMessage as Message;

class MailMessage extends Message
{
    /** @var string */
    protected $alias;

    /** @var array */
    protected $data;

    /** @var int */
    protected $id;

    /** @var string */
    public $view = 'postmark::template';

    public function alias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function data(): array
    {
        return [
            'id' => $this->id,
            'alias' => $this->alias,
            'model' => $this->data,
        ];
    }

    public function identifier(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function include(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function messageStream(string $messageStream): self
    {
        return $this->withSwiftMessage(function (\Swift_Message $message) use ($messageStream) {
            $message->getHeaders()->addTextHeader('X-PM-Message-Stream', $messageStream);
        });
    }
}
