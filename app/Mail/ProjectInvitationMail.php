<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectInvitationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $invitation;

    /**
     * Create a new message instance.
     */
    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Define the message's envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lời mời tham gia dự án',
        );
    }

    /**
     * Define the message content.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.project_invitation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Build the message (optional, for backward compatibility).
     */
    public function build()
    {
        $view = 'emails.project_invitation';
        if (!view()->exists($view)) {
            throw new \Exception("View {$view} not found");
        }
        return $this->subject('Lời mời tham gia dự án')
                    ->view($view);
    }
}