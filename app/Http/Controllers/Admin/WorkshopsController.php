<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class WorkshopsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.workshops.index');
    }

    public function getWorkshopsData()
    {
        $workshops = Event::where('event_type', 'workshop')->with('programs')->get();

        return DataTables::of($workshops)

            ->addColumn('name', function ($workshop) {
                return $workshop->event_name;
            })
            ->addColumn('company_name', function ($workshop) {
                return $workshop->company_name;
            })
            ->addColumn('location', function ($workshop) {
                return $workshop->location;
            })
            ->addColumn('date', function ($workshop) {
                return Carbon::parse($workshop->event_time)->format('d-m-Y h:i A');
            })
            ->addColumn('media', function ($workshop) {
                return '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 preview-trigger" data-content="' . e($workshop->media_path) . '">
                    <i class="bi bi-eye"></i>
                </a>';
            })
            ->addColumn('documents', function ($workshop) {
                return '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 preview-trigger" data-content="' . e($workshop->document_path) . '">
                    <i class="bi bi-eye"></i>
                </a>';
            })
            ->addColumn('actions', function ($workshop) {
                $actions = '';
                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_WORKSHOPS->value,
                    PermissionEnum::DELETE_WORKSHOPS->value
                ])) {
                    $actions = '<div class="d-flex justify-content-center">';
                    $actions .= '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    '.__("workshops.actions").'
                                    <span class="svg-icon svg-icon-5 m-0">
                                       <i class="fa-solid fa-caret-down"></i>
                                   </span>
                                </a>';

                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_WORKSHOPS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-user-id="' . $workshop->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_workshop">
                                '.__("workshops.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_WORKSHOPS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $workshop->id . '">'.__("workshops.delete").'</a>
                        </div>';
                    }

                    $actions .= '</div>';
                }
                return $actions;
            })
            ->rawColumns(['actions','','media','documents'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programs = Program::all();
        return view('workshops.create', compact('programs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'event_time' => 'required|date',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:10240', // 10MB max
            'document' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240', // 10MB max
            'description' => 'nullable|string',
            'program_ids' => 'nullable|array|min:1',
            'program_ids.*' => 'exists:programs,id',
        ]);

        try {
            // Handle file uploads
            $mediaPath = null;
            $documentPath = null;

            if ($request->hasFile('media')) {
                $mediaPath = $request->file('media')->store('public/workshops/media');
                $mediaPath = str_replace('public/', 'storage/', $mediaPath);
            }

            if ($request->hasFile('document')) {
                $documentPath = $request->file('document')->store('public/workshops/documents');
                $documentPath = str_replace('public/', 'storage/', $documentPath);
            }

            // Create the event
            $event = Event::create([
                'event_name' => $validated['event_name'],
                'company_name' => $validated['company_name'],
                'location' => $validated['location'],
                'event_time' => $validated['event_time'],
                'media_path' => $mediaPath,
                'document_path' => $documentPath,
                'description' => $validated['description'],
                'event_type' => 'workshop',
            ]);

            // Sync programs
            $event->programs()->sync($validated['program_ids'] ?? []);

            return response()->json([
                'success' => true,
                'message' => __('workshops.messages.created')
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
     * Display the specified resource.
     */
    public function show(Event $workshop)
    {
        $workshop->load('programs');
        return response()->json([
            'success' => true,
            'data' => $workshop
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $workshop)
    {
        $programIds = $workshop->programs()->pluck('program_id');

        return response()->json([
            'workshop' => $workshop,
            'program_ids' => $programIds,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $workshop)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'event_time' => 'required|date',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4', // 10MB max
            'document' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240', // 10MB max
            'description' => 'nullable|string',
            'program_ids' => 'nullable|array|min:1',
            'program_ids.*' => 'exists:programs,id',
            'current_media_path' => 'nullable|string',
            'current_document_path' => 'nullable|string',
        ]);

        try {
            // === Handle media upload ===
            $mediaPath = $workshop->media_path;
            if ($request->hasFile('media')) {
                // Delete old if new file is uploaded
                if ($workshop->media_path && Storage::exists(str_replace('storage/', 'public/', $workshop->media_path))) {
                    Storage::delete(str_replace('storage/', 'public/', $workshop->media_path));
                }

                $mediaPath = $request->file('media')->store('public/workshops/media');
                $mediaPath = str_replace('public/', 'storage/', $mediaPath);
            } elseif (!$request->filled('current_media_path')) {
                // Remove if current is not set and no new file uploaded
                if ($workshop->media_path && Storage::exists(str_replace('storage/', 'public/', $workshop->media_path))) {
                    Storage::delete(str_replace('storage/', 'public/', $workshop->media_path));
                }
                $mediaPath = null;
            }

            // === Handle document upload ===
            $documentPath = $workshop->document_path;
            if ($request->hasFile('document')) {
                if ($workshop->document_path && Storage::exists(str_replace('storage/', 'public/', $workshop->document_path))) {
                    Storage::delete(str_replace('storage/', 'public/', $workshop->document_path));
                }

                $documentPath = $request->file('document')->store('public/workshops/documents');
                $documentPath = str_replace('public/', 'storage/', $documentPath);
            } elseif (!$request->filled('current_document_path')) {
                if ($workshop->document_path && Storage::exists(str_replace('storage/', 'public/', $workshop->document_path))) {
                    Storage::delete(str_replace('storage/', 'public/', $workshop->document_path));
                }
                $documentPath = null;
            }

            // === Update event ===
            $workshop->update([
                'event_name' => $validated['event_name'],
                'company_name' => $validated['company_name'],
                'location' => $validated['location'],
                'event_time' => $validated['event_time'],
                'description' => $validated['description'],
                'media_path' => $mediaPath,
                'document_path' => $documentPath,
            ]);

            // Sync programs
            $workshop->programs()->sync($validated['program_ids'] ?? []);

            return response()->json([
                'success' => true,
                'message' => __('workshops.messages.updated')
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
    public function destroy(Event $workshop)
    {
        try {
            // Delete associated files
            if ($workshop->media_path && Storage::exists(str_replace('storage/', 'public/', $workshop->media_path))) {
                Storage::delete(str_replace('storage/', 'public/', $workshop->media_path));
            }

            if ($workshop->document_path && Storage::exists(str_replace('storage/', 'public/', $workshop->document_path))) {
                Storage::delete(str_replace('storage/', 'public/', $workshop->document_path));
            }

            // Delete the workshop
            $workshop->programs()->detach();
            $workshop->delete();

            return response()->json([
                'success' => true,
                'message' => __('workshops.messages.deleted')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('workshops.messages.delete_failed')
            ], 500);
        }
    }
}
