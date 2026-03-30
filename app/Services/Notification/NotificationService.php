<?php

namespace App\Services\Notification;

use Carbon\Carbon;

class NotificationService
{
  /**
   * Create a new class instance.
   */
  public function __construct()
  {
    //
  }

  public function index($request)
  {
    $notifications = $request->user()
      ->notifications()
      ->latest()
      ->paginate(10);
    return $notifications;
  }

  public function markAsRead()
  {
    $now = Carbon::now();
    $user = auth()->user();
    $updated = $user->unreadNotifications()
      ->update(['read_at' => $now]);
    return $updated;
  }
}
