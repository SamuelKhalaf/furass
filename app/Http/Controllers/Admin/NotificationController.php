<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationStatus;
use App\Models\NotificationTarget;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.notifications.index');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'link' => 'nullable|url',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,docx|max:10240', // 10MB max
            'recipient_groups' => 'nullable|array',
            'recipient_groups.*' => 'string|in:admins,sub_admins,students,consultants,schools',
            'specific_users' => 'nullable|array',
            'specific_users.*' => 'integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if at least one recipient is selected
        $recipientGroups = $request->input('recipient_groups', []);
        $specificUsers = $request->input('specific_users', []);

        if (empty($recipientGroups) && empty($specificUsers)) {
            return response()->json([
                'success' => false,
                'message' => 'Please select at least one recipient group or specific user.'
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Handle file attachments
            $attachmentPaths = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $filename =  uniqid();
                    $path = $file->storeAs('notifications/attachments', $filename, 'public');

                    $attachmentPaths[] = [
                        'path' => $path,
                        'url' => Storage::url($path),
                    ];
                }
            }

            $meta = [
                'link' => $request->input('link'),
                'attachments' => $attachmentPaths,
                'sent_by' => auth()->id(),
                'sent_at' => now()->toISOString(),
            ];

            $notification = Notification::create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'meta' => $meta
            ]);

            $allTargetUsers = collect();

            // Handle recipient groups
            if (!empty($recipientGroups)) {
                foreach ($recipientGroups as $group) {
                    $groupUsers = collect();

                    switch ($group) {
                        case 'admins':
                            $groupUsers = User::where('role', RoleEnum::ADMIN)
                                ->get();
                            break;

                        case 'sub_admins':
                            $groupUsers = User::where('role', RoleEnum::SUB_ADMIN)
                                ->get();
                            break;

                        case 'students':
                            $groupUsers = User::where('role', RoleEnum::STUDENT)
                                ->get();
                            break;

                        case 'consultants':
                            $groupUsers = User::where('role', RoleEnum::CONSULTANT)
                                ->get();
                            break;

                        case 'schools':
                            $groupUsers = User::where('role', RoleEnum::SCHOOL)
                                ->get();
                            break;
                    }

                    // Create notification targets for the group
                    if ($groupUsers->isNotEmpty()) {
                        foreach ($groupUsers as $user) {
                            NotificationTarget::create([
                                'notification_id' => $notification->id,
                                'target_type' => User::class,
                                'target_id' => $user->id
                            ]);
                        }

                        $allTargetUsers = $allTargetUsers->merge($groupUsers);
                    }
                }
            }

            // Handle specific users
            if (!empty($specificUsers)) {
                // Get existing user IDs (already added from groups)
                $alreadyTargetedUserIds = $allTargetUsers->pluck('id')->toArray();

                // Filter specific users to only those not already targeted
                $filteredUserModels = User::whereIn('id', $specificUsers)
                    ->whereNotIn('id', $alreadyTargetedUserIds)
                    ->get();

                foreach ($filteredUserModels as $user) {
                    NotificationTarget::create([
                        'notification_id' => $notification->id,
                        'target_type' => User::class,
                        'target_id' => $user->id
                    ]);
                }

                $allTargetUsers = $allTargetUsers->merge($filteredUserModels);
            }

            // Remove duplicates based on user ID
            $uniqueTargetUsers = $allTargetUsers->unique('id');

            // Create notification statuses for all target users
            $notificationStatuses = [];
            foreach ($uniqueTargetUsers as $user) {
                $notificationStatuses[] = [
                    'notification_id' => $notification->id,
                    'user_id' => $user->id,
                    'is_read' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            if (!empty($notificationStatuses)) {
                NotificationStatus::insert($notificationStatuses);
            }

            // Update notification meta with final recipient count
//            $notification->update([
//                'meta' => array_merge($meta, [
//                    'total_recipients' => $uniqueTargetUsers->count(),
//                    'recipient_details' => [
//                        'groups' => $recipientGroups,
//                        'specific_users_count' => count($specificUsers),
//                        'total_unique_recipients' => $uniqueTargetUsers->count()
//                    ]
//                ])
//            ]);

            DB::commit();

            // Optional: Dispatch notification events or jobs here
            // You can add real-time notifications, email sending, etc.

            return response()->json([
                'success' => true,
                'message' => 'Notification sent successfully!',
                'data' => [
                    'notification_id' => $notification->id,
                    'recipients_count' => $uniqueTargetUsers->count(),
                    'title' => $notification->title
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up uploaded files if notification creation failed
            if (!empty($attachmentPaths)) {
                foreach ($attachmentPaths as $attachment) {
                    Storage::disk('public')->delete($attachment['path']);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to send notification. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    // Helper method for user search (for the AJAX select2)
    public function searchUsers(Request $request)
    {
        $query = $request->get('q');
        $page = $request->get('page', 1);
        $perPage = 30;

        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'email')
            ->paginate($perPage, ['*'], 'page', $page);

        $items = $users->items();
        $formattedItems = [];

        foreach ($items as $user) {
            $formattedItems[] = [
                'id' => $user->id,
                'text' => $user->name . ' (' . $user->email . ')',
                'name' => $user->name,
                'email' => $user->email
            ];
        }

        return response()->json([
            'items' => $formattedItems,
            'total_count' => $users->total(),
            'has_more' => $users->hasMorePages()
        ]);
    }

    /**
     * Get some notifications for the authenticated user
     */
    public function getSomeNotifications(Request $request): JsonResponse
    {
        $user = Auth::user();

        $notifications = Notification::whereHas('targets', function($query) use ($user) {
            $query->where('target_type', get_class($user))
                ->where('target_id', $user->id);
        })
        ->select('notifications.*')
        ->selectSub(function ($query) use ($user) {
            $query->from('notification_statuses')
                ->select('is_read')
                ->whereColumn('notification_statuses.notification_id', 'notifications.id')
                ->where('user_id', $user->id)
                ->limit(1);
        }, 'is_read')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

        $unreadCount = DB::table('notifications')
            ->join('notification_targets', function ($join) use ($user) {
                $join->on('notifications.id', '=', 'notification_targets.notification_id')
                    ->where('notification_targets.target_type', get_class($user))
                    ->where('notification_targets.target_id', $user->id);
            })
            ->join('notification_statuses', function ($join) use ($user) {
                $join->on('notifications.id', '=', 'notification_statuses.notification_id')
                    ->where('notification_statuses.user_id', $user->id)
                    ->where('notification_statuses.is_read', false);
            })
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(Request $request, $id): JsonResponse
    {
        $user = Auth::user();

        $status = NotificationStatus::firstOrCreate([
            'notification_id' => $id,
            'user_id' => $user->id,
        ]);

        $status->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $user = Auth::user();

        NotificationStatus::where('user_id', $user->id)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Display all notifications for the authenticated user (paginated)
     */
    public function allNotifications(Request $request)
    {
        $user = Auth::user();
        $perPage = 4;
        $notifications = \App\Models\Notification::whereHas('targets', function($query) use ($user) {
                $query->where('target_type', get_class($user))
                    ->where('target_id', $user->id);
            })
            ->select('notifications.*')
            ->selectSub(function ($query) use ($user) {
                $query->from('notification_statuses')
                    ->select('is_read')
                    ->whereColumn('notification_statuses.notification_id', 'notifications.id')
                    ->where('user_id', $user->id)
                    ->limit(1);
            }, 'is_read')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('admin.notifications.all', compact('notifications'));
    }

    /**
     * Show a single notification details for the authenticated user
     */
    public function show($id)
    {
        $user = Auth::user();
        $notification = Notification::where('id', $id)
            ->whereHas('targets', function($query) use ($user) {
                $query->where('target_type', get_class($user))
                    ->where('target_id', $user->id);
            })
            ->firstOrFail();

        // Mark as read if not already
        $status = NotificationStatus::firstOrCreate([
            'notification_id' => $notification->id,
            'user_id' => $user->id,
        ]);
        if (!$status->is_read) {
            $status->update(['is_read' => true]);
        }

        return view('admin.notifications.show', compact('notification'));
    }
}
