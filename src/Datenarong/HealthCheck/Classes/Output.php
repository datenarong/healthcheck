<?php
namespace Datenarong\HealthCheck\Classes;

class Output
{
    public function html($datas)
    {
        return $this->getTable($datas);
    }

    private function getTable($datas)
    {
        $html =
            "<table id=\"responsive-example-table\" class=\"large-only\" cellspacing=\"0\">
                <tbody>
                    <tr align=\"left\">
                        <th width=\"12%\"></th>
                        <th width=\"30%\">service</th>
                        <th width=\"30%\">url</th>
                        <th width=\"12%\">response</th>
                        <th width=\"12%\">status</th>
                        <th width=\"12%\">remark</th>
                    </tr>"
                    . $this->getRows($datas) .
            "</tbody>
        </table>";

        return $html;
    }

    private function getRows($datas)
    {
        $html = '';
        foreach ($datas as $key => $value) {
            $html .=
                "<tr align=\"left\">
                    <td>{$value['module']}</td>
                    <td>{$value['service']}</td>
                    <td>{$value['url']}</td>
                    <td>{$value['response']}</td>
                    <td>{$value['status']}</td>
                    <td>{$value['remark']}</td>
                </tr>";
        }

        return $html;
    }
}
