<?php
namespace App\Services\implementation;

use App\Models\Student;
use App\Services\IStudentProgressService;
use App\Models\Enrollment;
use App\Models\StudentPathProgress;

class StudentProgressService implements IStudentProgressService
{
    /**
     * Unlock the next path point in the student's program flow.
     * Skips grade-locked path points and finds the next available one.
     */
    public function unlockNextPathPoint(int $student_id, int $program_id, int $current_path_point_id): void
    {
        $student = Student::find($student_id);
        if (!$student) {
            return;
        }

        $hasActive = StudentPathProgress::where('student_id', $student_id)
            ->where('program_id', $program_id)
            ->where('status', 2)
            ->exists();

        if ($hasActive) {
            return;
        }

        $currentProgress = StudentPathProgress::where('student_id', $student_id)
            ->where('program_id', $program_id)
            ->where('path_point_id', $current_path_point_id)
            ->first();

        if (!$currentProgress) {
            return;
        }

        $currentOrder = $currentProgress->order;

        // Get all path points after the current one, ordered by their sequence
        $nextPathPoints = StudentPathProgress::where('student_id', $student_id)
            ->where('program_id', $program_id)
            ->where('order', '>', $currentOrder)
            ->with('pathPoint')
            ->orderBy('order')
            ->get();

        // Find the next available (not grade-locked) path point
        foreach ($nextPathPoints as $nextProgress) {
            $pathPoint = $nextProgress->pathPoint;

            // Check if this path point is grade-locked
            $isGradeLocked = $pathPoint->grade && $student->grade < $pathPoint->grade;

            if (!$isGradeLocked && $nextProgress->status == 1) {
                // Unlock this path point
                $nextProgress->update(['status' => 2]);
                break; // Only unlock the first available path point
            }
        }
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
            ->whereIn('status', [3,4])
            ->count();

        $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;

        Enrollment::where('student_id', $student_id)
            ->where('program_id', $program_id)
            ->update([
                'progress' => $percentage,
                'status' => $percentage == 100 ? 'attended' : 'active',
            ]);
    }

    /**
     * Refresh path point statuses when student's grade changes
     * This method can be called when a student's grade is updated
     */
    public function refreshPathPointsForGradeChange(int $student_id): void
    {
        $student = Student::find($student_id);
        if (!$student) {
            return;
        }

        // Get all student's enrollments
        $enrollments = $student->enrollments;

        foreach ($enrollments as $enrollment) {
            $this->refreshProgramPathPointsForStudent($student_id, $enrollment->program_id);
        }
    }

    /**
     * Refresh path point statuses for a specific program when student's grade changes
     */
    private function refreshProgramPathPointsForStudent(int $student_id, int $program_id): void
    {
        $student = Student::find($student_id);
        if (!$student) {
            return;
        }

        $pathPoints = StudentPathProgress::where('student_id', $student_id)
            ->where('program_id', $program_id)
            ->with('pathPoint')
            ->orderBy('order')
            ->get();

        // First, check if there's already an active path point (status = 2)
        $hasActivePathPoint = $pathPoints->where('status', 2)->isNotEmpty();

        foreach ($pathPoints as $progress) {
            $pathPoint = $progress->pathPoint;
            $isGradeLocked = $pathPoint->grade && $student->grade < $pathPoint->grade;

            if ($isGradeLocked) {
                // Lock grade-restricted path points
                if ($progress->status != 1) {
                    $progress->update(['status' => 1]);
                }
            } else {
                // For available path points, maintain their current status if they're completed or in progress
                if (in_array($progress->status, [3, 4])) {
                    // Keep completed/in-progress status
                    continue;
                }

                // If this path point is currently active (status = 2), keep it active
                if ($progress->status == 2) {
                    continue;
                }
            }
        }

        // If no path point is currently active, activate the first available one
        if (!$hasActivePathPoint) {
            foreach ($pathPoints as $progress) {
                $pathPoint = $progress->pathPoint;
                $isGradeLocked = $pathPoint->grade && $student->grade < $pathPoint->grade;

                if (!$isGradeLocked && $progress->status == 1) {
                    $progress->update(['status' => 2]);
                    break; // Only activate the first available path point
                }
            }
        }

        // Update overall progress
        $this->updateProgramProgress($student_id, $program_id);
    }
}
