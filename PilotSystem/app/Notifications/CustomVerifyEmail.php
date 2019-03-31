<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomVerifyEmail extends VerifyEmail
{
    use Queueable;

    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }

        return (new MailMessage)
            ->from(env('MAIL_USERNAME'))
            ->subject('飞行员系统-邮箱验证激活')
            ->line('请点击下面的按钮以完成飞行员系统的邮箱激活')
            ->action(
                '验证邮箱',
                $this->verificationUrl($notifiable)
            )
            ->line('如果你没有注册任何账户,请删除此邮件');
    }
}
