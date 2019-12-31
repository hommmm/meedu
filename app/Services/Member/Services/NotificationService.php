<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Member\Services;

use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\Member\Interfaces\NotificationServiceInterface;
use App\Services\Member\Notifications\SimpleMessageNotification;

class NotificationService implements NotificationServiceInterface
{
    /**
     * @param int $id
     * @param string $orderId
     */
    public function notifyOrderPaidMessage(int $id, string $orderId): void
    {
        /**
         * @var User
         */
        $user = User::findOrFail($id);
        $user->notify(new SimpleMessageNotification(__('notification_content_order_paid', ['orderId' => $orderId])));
    }

    /**
     * @param int $id
     */
    public function notifyRegisterMessage(int $id): void
    {
        $user = User::findOrFail($id);
        $user->notify(new SimpleMessageNotification(__('notification_content_register')));
    }

    /**
     * @param int $userId
     * @param int $atUserId
     * @param string $scene
     * @param string $link
     */
    public function notifyAtNotification(int $userId, int $atUserId, string $scene, string $link): void
    {
        $user = User::findOrFail($userId);
        $atUser = User::findOrFail($atUserId);
        $user->notify(new SimpleMessageNotification(__('notification_content_at', [
            'atUser' => $atUser->nick_name,
            'scene' => $scene,
            'link' => $link,
        ])));
    }

    /**
     * @return int
     */
    public function getUnreadCount(): int
    {
        return User::find(Auth::id())->unreadNotifications()->count();
    }

    /**
     * @param int $userId
     */
    public function markAllRead(int $userId): void
    {
    }
}
