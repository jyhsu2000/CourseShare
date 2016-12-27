<?php

namespace App\Services;

class AnalysisService
{
    /**
     * @return array
     */
    public function getAnalysisCourseTableIds()
    {
        $user = auth()->user();
        $courseTableIds = session('analysisTables_' . $user->id);
        if (!$courseTableIds || !is_array($courseTableIds)) {
            $courseTableIds = [];
        }

        return $courseTableIds;
    }

    /**
     * @param array $courseTableIds
     */
    public function setAnalysisCourseTableIds($courseTableIds)
    {
        $user = auth()->user();
        if (!$courseTableIds || !is_array($courseTableIds)) {
            $courseTableIds = [];
        }
        session(['analysisTables_' . $user->id => $courseTableIds]);
    }
}
