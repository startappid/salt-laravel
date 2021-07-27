<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppNotification extends Notification
{
    use Queueable;

	protected $data;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct($notif) {
		$this->data = $notif;
	}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
		return ['mail', 'database'];
	}

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
		$mailnotif = (new MailMessage)
			->subject($this->data['subject']);
		if(isset($this->data['greeting'])) {
			$mailnotif = $mailnotif->greeting($this->data['greeting']);
		}
		foreach ($this->data['message'] as $key => $value) {
			$mailnotif = $mailnotif->line($value);
		}

		if (isset($this->data['url'])) {
			$mailnotif = $mailnotif->action($this->data['url']['text'], $this->data['url']['url']);
		}

		if (isset($this->data['attachments'])) {
			foreach ($this->data['attachments'] as $doc) {
				$mailnotif = $mailnotif->attach($doc);
			}
		}

		return $mailnotif;
	}

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
		return $this->data;
	}
}
