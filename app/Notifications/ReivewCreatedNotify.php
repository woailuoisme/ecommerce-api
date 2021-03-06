<?php

namespace App\Notifications;

use App\Models\ProductReview;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReivewCreatedNotify extends Notification
{
    use Queueable;

    /**
     * @var ProductReview
     */
    private $review;

    /**
     * Create a new notification instance.
     *
     * @param  ProductReview  $review
     */
    public function __construct(ProductReview $review)
    {
        //
        $this->review = $review;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
//        return (new MailMessage)
//            ->line('The introduction to the notification.')
//            ->action('Notification Action', url('/'))
//            ->line('Thank you for using our application!');

        $url = url('/invoice/'.$this->review->id);

        return (new MailMessage)
            ->greeting('Hello!')
            ->line('One of your invoices has been paid!')
            ->action('View Invoice', $url)
            ->line('Thank you for using our application!');

//        return (new MailMessage)->view(
//            'emails.name', ['invoice' => $this->invoice]
//        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
