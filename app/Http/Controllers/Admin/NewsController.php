<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.news.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getNewsData()
    {
        $news = News::with('user')->latest()->get();

        return DataTables::of($news)
            ->addColumn('title' , function ($news) {
                return $news->title;
            })
            ->addColumn('status', function ($news) {
                return $news->status;
            })
            ->addColumn('published_at' , function ($news) {
                return $news->published_at
                    ? Carbon::parse($news->published_at)->format('d M Y h:i A')
                    : 'Not published';            })
            ->addColumn('author', function ($news) {
                return $news->user->name;
            })
            ->addColumn('media', function ($news) {
                return '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 preview-trigger" data-content="' . e($news->media) . '">
                    <i class="bi bi-eye"></i>
                </a>';
            })
            ->addColumn('actions', function ($news) {
                $actions = '';
                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_NEWS->value,
                    PermissionEnum::DELETE_NEWS->value
                ])) {
                    $actions = '<div class="d-flex justify-content-center">';
                    $actions .= '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    '.__("news.actions").'
                                    <span class="svg-icon svg-icon-5 m-0">
                                       <i class="fa-solid fa-caret-down"></i>
                                   </span>
                                </a>';

                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_NEWS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-user-id="' . $news->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_news">
                                '.__("news.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_NEWS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $news->id . '">'.__("news.delete").'</a>
                        </div>';
                    }

                    $actions .= '</div>';
                }
                return $actions;
            })
            ->rawColumns(['media', 'actions', 'status'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:news,slug',
            'content' => 'required|string',
            'status' => 'required|boolean',
            'published_at' => 'nullable|date',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:10240',
            'current_media_path' => 'nullable|string',
        ]);

        try {
            // Handle file uploads
            $mediaPath = null;

            if ($request->hasFile('media')) {
                $mediaPath = $request->file('media')->store('public/news/media');
                $mediaPath = str_replace('public/', 'storage/', $mediaPath);
            }

            // Create the news
            $news = News::create([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'content' => $validated['content'],
                'status' => $validated['status'],
                'published_at' => $validated['published_at'],
                'media' => $mediaPath,
                'user_id' => auth()->user()->id
            ]);

            return response()->json([
                'success' => true,
                'message' => __('news.messages.created')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('common.error_occurred_processing_request'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $news->load('user');
        return response()->json($news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:news,slug,' . $news->id,
            'content' => 'required|string',
            'status' => 'required|boolean',
            'published_at' => 'nullable|date',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:10240',
            'current_media_path' => 'nullable|string',
        ]);

        try {
            // === Handle media upload ===
            $mediaPath = $news->media;
            if ($request->hasFile('media')) {
                // Delete old if new file is uploaded
                if ($news->media && Storage::exists(str_replace('storage/', 'public/', $news->media))) {
                    Storage::delete(str_replace('storage/', 'public/', $news->media));
                }

                $mediaPath = $request->file('media')->store('public/news/media');
                $mediaPath = str_replace('public/', 'storage/', $mediaPath);
            } elseif (!$request->filled('current_media_path')) {
                // Remove if current is not set and no new file uploaded
                if ($news->media && Storage::exists(str_replace('storage/', 'public/', $news->media))) {
                    Storage::delete(str_replace('storage/', 'public/', $news->media));
                }
                $mediaPath = null;
            }

            // === Update news ===
            $news->update([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'content' => $validated['content'],
                'status' => $validated['status'],
                'published_at' => $validated['published_at'] ?? null,
                'media' => $mediaPath,
            ]);

            return response()->json([
                'success' => true,
                'message' => __('news.messages.updated')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('common.error_occurred_processing_request'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        try {
            // Delete associated files
            if ($news->media && Storage::exists(str_replace('storage/', 'public/', $news->media))) {
                Storage::delete(str_replace('storage/', 'public/', $news->media));
            }
            $news->delete();

            return response()->json([
                'success' => true,
                'message' => __('news.messages.deleted')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('news.messages.delete_failed')
            ], 500);
        }
    }
}
