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
            "<table id=\"responsive-example-table\" class=\"large-only\" cellspacing=\"0\">\n
                <tbody>\n
                    <tr align=\"left\">\n
                        <th width=\"12%\"></th>\n
                        <th width=\"30%\">service</th>\n
                        <th width=\"30%\">url</th>\n
                        <th width=\"12%\">response</th>\n
                        <th width=\"12%\">status</th>\n
                        <th width=\"12%\">remark</th>\n
                    </tr>\n"
                    . $this->getRows($datas) .
            "</tbody>\n
        </table>";

        return $html;
    }

    private function getRows($datas)
    {
        $html = '';
        foreach ($datas as $key => $value) {
            $html .=
                "<tr align=\"left\">\n
                    <td>{$value['module']}</td>\n
                    <td>{$value['service']}</td>\n
                    <td>{$value['url']}</td>\n
                    <td>{$value['response']}</td>\n
                    <td>{$value['status']}</td>\n
                    <td>{$value['remark']}</td>\n
                </tr>\n";
        }

        return $html;
    }
}
