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

class TripsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.trips.index');
    }

    public function getTripsData()
    {
        $trips = Event::where('event_type', 'trip')->with('programs')->get();

        return DataTables::of($trips)

            ->addColumn('name', function ($trip) {
                return $trip->event_name;
            })
            ->addColumn('company_name', function ($trip) {
                return $trip->company_name;
            })
            ->addColumn('location', function ($trip) {
                return $trip->location;
            })
            ->addColumn('date', function ($trip) {
                return Carbon::parse($trip->event_time)->format('d-m-Y h:i A');
            })
            ->addColumn('media', function ($trip) {
                return '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 preview-trigger" data-content="' . e($trip->media_path) . '">
                    <i class="bi bi-eye"></i>
                </a>';
            })
            ->addColumn('documents', function ($trip) {
                return '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 preview-trigger" data-content="' . e($trip->document_path) . '">
                    <i class="bi bi-eye"></i>
                </a>';
            })
            ->addColumn('actions', function ($trip) {
                $actions = '';
                if (auth()->user()->hasAnyPermission([
                    PermissionEnum::UPDATE_TRIPS->value,
                    PermissionEnum::DELETE_TRIPS->value
                ])) {
                    $actions = '<div class="d-flex justify-content-center">';
                    $actions .= '<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    '.__("trips.actions").'
                                    <span class="svg-icon svg-icon-5 m-0">
                                       <i class="fa-solid fa-caret-down"></i>
                                   </span>
                                </a>';

                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                    if (auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_TRIPS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-user-id="' . $trip->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_update_trip">
                                '.__("trips.edit").'
                            </a>
                        </div>';
                    }

                    if (auth()->user()->hasPermissionTo(PermissionEnum::DELETE_TRIPS->value)) {
                        $actions .= '<div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row"
                               data-user-id="' . $trip->id . '">'.__("trips.delete").'</a>
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
        return view('trips.create', compact('programs'));
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
                $mediaPath = $request->file('media')->store('public/trips/media');
                $mediaPath = str_replace('public/', 'storage/', $mediaPath);
            }

            if ($request->hasFile('document')) {
                $documentPath = $request->file('document')->store('public/trips/documents');
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
                'event_type' => 'trip',
            ]);

            // Sync programs
            $event->programs()->sync($validated['program_ids'] ?? []);

            return response()->json([
                'success' => true,
                'message' => __('trips.messages.created')
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
    public function show(Event $trip)
    {
        $trip->load('programs');
        return response()->json([
            'success' => true,
            'data' => $trip
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $trip)
    {
        $programIds = $trip->programs()->pluck('program_id');

        return response()->json([
            'trip' => $trip,
            'program_ids' => $programIds,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $trip)
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
            $mediaPath = $trip->media_path;
            if ($request->hasFile('media')) {
                // Delete old if new file is uploaded
                if ($trip->media_path && Storage::exists(str_replace('storage/', 'public/', $trip->media_path))) {
                    Storage::delete(str_replace('storage/', 'public/', $trip->media_path));
                }

                $mediaPath = $request->file('media')->store('public/trips/media');
                $mediaPath = str_replace('public/', 'storage/', $mediaPath);
            } elseif (!$request->filled('current_media_path')) {
                // Remove if current is not set and no new file uploaded
                if ($trip->media_path && Storage::exists(str_replace('storage/', 'public/', $trip->media_path))) {
                    Storage::delete(str_replace('storage/', 'public/', $trip->media_path));
                }
                $mediaPath = null;
            }

            // === Handle document upload ===
            $documentPath = $trip->document_path;
            if ($request->hasFile('document')) {
                if ($trip->document_path && Storage::exists(str_replace('storage/', 'public/', $trip->document_path))) {
                    Storage::delete(str_replace('storage/', 'public/', $trip->document_path));
                }

                $documentPath = $request->file('document')->store('public/trips/documents');
                $documentPath = str_replace('public/', 'storage/', $documentPath);
            } elseif (!$request->filled('current_document_path')) {
                if ($trip->document_path && Storage::exists(str_replace('storage/', 'public/', $trip->document_path))) {
                    Storage::delete(str_replace('storage/', 'public/', $trip->document_path));
                }
                $documentPath = null;
            }

            // === Update event ===
            $trip->update([
                'event_name' => $validated['event_name'],
                'company_name' => $validated['company_name'],
                'location' => $validated['location'],
                'event_time' => $validated['event_time'],
                'description' => $validated['description'],
                'media_path' => $mediaPath,
                'document_path' => $documentPath,
            ]);

            // Sync programs
            $trip->programs()->sync($validated['program_ids'] ?? []);

            return response()->json([
                'success' => true,
                'message' => __('trips.messages.updated')
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
    public function destroy(Event $trip)
    {
        try {
            // Delete associated files
            if ($trip->media_path && Storage::exists(str_replace('storage/', 'public/', $trip->media_path))) {
                Storage::delete(str_replace('storage/', 'public/', $trip->media_path));
            }

            if ($trip->document_path && Storage::exists(str_replace('storage/', 'public/', $trip->document_path))) {
                Storage::delete(str_replace('storage/', 'public/', $trip->document_path));
            }

            // Delete the trip
            $trip->programs()->detach();
            $trip->delete();

            return response()->json([
                'success' => true,
                'message' => __('trips.messages.deleted')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('trips.messages.delete_failed')
            ], 500);
        }
    }
}
