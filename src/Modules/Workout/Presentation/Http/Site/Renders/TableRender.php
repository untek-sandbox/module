<?php

namespace Untek\Sandbox\Module\Modules\Workout\Presentation\Http\Site\Renders;

use Illuminate\Support\Collection;

class TableRender
{

    public function renderTable(array $arr): string
    {
//        return $this->renderPart($arr);


        $chunks = (new Collection($arr))->chunk(40);

        $table = '';
        $table .= '<table>';
        $table .= '<tr>';
        foreach ($chunks as $chunk) {
            $partHtml = $this->renderPart($chunk);
            $table .= '<td>' . $partHtml . '</td>';
        }
        $table .= '</tr>';
        $table .= '</table>';
//        <div class="pagebreak"> </div>
        return $table;
    }

    private function renderPart($arr) {
        $table = '';
        $table .= '<table class="table table-striped table-bordered table-sm mr-3" style="width: 230px; font-size: 10px;">';
        foreach ($arr as $sum => $row) {
            $table .= '<tr>';
            $vals = [];
            /*foreach ($row['puncackes'] as $field => $val) {
                if (empty($val)) {
                    $val = '';
                }
                $table .= '<td>' . $val . '</td>';
            }*/
            foreach ($row['puncackes'] as $field => $val) {
                if(!empty($val)) {
                    $vals[] = $val;
                }
            }
            $table .= '<td>' . implode('&nbsp;|&nbsp;', $vals) . '</td>';

            $table .= '<th>' . $row['sum'] . '</th>';
            $table .= '</tr>';
        }
        $table .= '</table>';
        return $table;
    }
}
