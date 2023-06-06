<?php
namespace App\Mail;
use App\Models\userinfos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailWithAttachment extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $avatar;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(userinfos $user, $avatar)
    {
        $this->user = $user;
        $this->avatar = $avatar;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('sendmail')
                    ->with([
                        'user' => $this->user,
                    ])
                    ->attach(public_path('storage/assets/images/1683195822_book.jfif'), [
                        'as' => '1683195822_book.jfif',
                        'mime' => 'image/jpeg', 
                    ]);
    }
}
