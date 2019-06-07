<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomResetPassword extends ResetPassword
{
    use Queueable;

    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage)
            ->from(env('MAIL_USERNAME'))
            ->subject('飞行员系统-密码重置')
            ->line('你收到了这封邮件表示,你正在尝试重置你的呼号密码')
            ->action('重置密码', url(config('app.url').route('password.reset', ['token' => $this->token], false)))
            ->line(Lang::getFromJson('此密码重置链接将在 :count 分钟后过期', ['count' => config('auth.passwords.users.expire')]))
            ->line(Lang::getFromJson('如果你没有尝试重置密码, 请删除此邮件'));
    }
}
