<?php

namespace App\Services;

interface IStudentProgressService
{
    /**
     * Unlock the next path point for a student in a program.
     */
    public function unlockNextPathPoint(int $student_id, int $program_id, int $current_path_point_id): void;

    /**
     * Update the overall program progress for a student.
     */
    public function updateProgramProgress(int $student_id, int $program_id): void;
}
