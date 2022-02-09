<?php

namespace App\Exports;

use App\DailyAgent;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use \DateTime;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DailyAgentExport implements FromQuery, ShouldAutoSize, WithMapping, WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'date',
            'kw',
            'dialog_call_id',
            'agent_id',
            'agent_login_name',
            'agent_name',
            'agent_group_id',
            'agent_group_name',
            'agent_team_id',
            'agent_team_name',
            'queue_id',
            'queue_name',
            'skill_id',
            'skill_name',
            'status',
            'start_time',
            'end_time',
            'time_in_state',
            'timezone'
        ];
    }

    public function map($dailyAgent): array
    {
        return [
            $dailyAgent->date->format('d.m.Y'),
            $dailyAgent->kw,
            $dailyAgent->dialog_call_id,
            $dailyAgent->agent_id,
            $dailyAgent->agent_login_name,
            $dailyAgent->agent_name,
            $dailyAgent->agent_group_id,
            $dailyAgent->agent_group_name,
            $dailyAgent->agent_team_id,
            $dailyAgent->agent_team_name,
            $dailyAgent->queue_id,
            $dailyAgent->queue_name,
            $dailyAgent->skill_id,
            $dailyAgent->skill_name,
            $dailyAgent->status,
            $dailyAgent->start_time,
            $dailyAgent->end_time,
            $dailyAgent->time_in_state,
            $dailyAgent->timezone
        ];
    }

    public function whereStartDate(DateTime $startDate){
        $this->startDate = $startDate;
        return $this;
    }

    public function whereEndDate(DateTime $endDate){
        $this->endDate = $endDate;
        return $this;
    }

    public function query()
    {
        return DailyAgent::query()->where('start_time', '>=', $this->startDate)->where('end_time', '<=', $this->endDate);
    }
}
