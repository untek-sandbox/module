<?php

namespace Untek\Sandbox\Module\Modules\Workout\Presentation\Http\Site\Renders;

class TableRender
{

    public function renderTable(array $arr): string
    {
        $table = '';
        $table .= '<table class="table table-striped table-bordered table-sm" style="width: 300px">';
        foreach ($arr as $sum => $row) {
            $table .= '<tr>';
            foreach ($row as $field => $val) {
                if (empty($val)) {
                    $val = '';
                }
                if ($field == 'sum') {
                    $table .= '<th>' . $val . '</th>';
                } else {
                    $table .= '<td>' . $val . '</td>';
                }
            }
            $table .= '</tr>';
        }
        $table .= '</table>';
        return $table;
    }
}
