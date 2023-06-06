<?php

namespace App\Console\Commands;
use App\Models\userinfos;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Part\TextPart;

class DemoCron extends Command
{
    protected $signature = 'demo:cronphp';

    protected $description = 'sending mail every minutes';

    public function handle()
    {
        
        $users = Userinfos::first();
      
            $textPart = new TextPart('testing.....');
            
            Mail::send([], [], function($message) use ($users, $textPart) {
                $message->to($users->email);
                $message->subject('schedulecheking');
                $message->text($textPart->bodyToString());
            });
      
    
    }
}
