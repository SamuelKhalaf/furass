<?php
namespace App\Services\implementation;

use App\Services\IStudentProgressService;
use App\Models\Enrollment;
use App\Models\StudentPathProgress;

class StudentProgressService implements IStudentProgressService
{
    /**
     * Unlock the next path point in the student's program flow.
     */
    public function unlockNextPathPoint(int $student_id, int $program_id, int $current_path_point_id): void
    {
        $currentProgress = StudentPathProgress::where('student_id', $student_id)
            ->where('program_id', $program_id)
            ->where('path_point_id', $current_path_point_id)
            ->first();

        if (! $currentProgress) {
            return;
        }

        $currentOrder = $currentProgress->order;

        $nextOrder = StudentPathProgress::where('student_id', $student_id)
            ->where('program_id', $program_id)
            ->where('order', '>', $currentOrder)
            ->orderBy('order')
            ->value('order');

        if (! $nextOrder) {
            return;
        }

        StudentPathProgress::where('student_id', $student_id)
            ->where('program_id', $program_id)
            ->where('order', $nextOrder)
            ->where('status', 1)
            ->update(['status' => 2]);
    }

    /**
     * Update overall program progress for a student.
     */
    public function updateProgramProgress(int $student_id, int $program_id): void
    {
        $total = StudentPathProgress::where('student_id', $student_id)
            ->where('program_id', $program_id)
            ->count();

        $completed = StudentPathProgress::where('student_id', $student_id)
            ->where('program_id', $program_id)
            ->where('status', 3)
            ->count();

        $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;

        Enrollment::where('student_id', $student_id)
            ->where('program_id', $program_id)
            ->update([
                'progress' => $percentage,
                'status' => $percentage === 100 ? 'attended' : 'active',
            ]);
    }
}
