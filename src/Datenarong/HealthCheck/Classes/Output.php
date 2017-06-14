<?php
namespace Datenarong\HealthCheck\Classes;

class Output
{
    public function html($datas)
    {
        $html = $this->genHTML($datas);
        return $html;
    }

    private function genHTML($datas)
    {
        $html =
            "<html>\n
				<head>\n
				</head>\n
				<body>" . $this->getTable($datas) . "</body>\n
			</html>";

        return $html;
    }

    private function getTable($datas)
    {
        $html = "<h1>HEALTH CHECK SMS BANK<\h1>";
        return $html;
    }
}
