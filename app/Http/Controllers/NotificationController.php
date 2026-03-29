<?php

namespace App\Http\Controllers;

use App\Services\Notification\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
  protected $notificationService;

  public function __construct(NotificationService $notificationService)
  {
    $this->notificationService = $notificationService;
  }

  public function index(Request $request)
  {
    $notifications = $this->notificationService->index($request);
    return response()->json($notifications);
  }

  public function markAsRead()
  {
    $notification = $this->notificationService->markAsRead();
    return response()->json([
      'message' => $notification['message']
    ], $notification['status']);
  }
}
