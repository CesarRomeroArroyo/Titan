<?php
class chart
{
    public static function Barras_Horizontal($div, $titulo, $subtitulo,  $titulosVertical, $tituloHorizontal, $datos)
    {   
        $data="[";
        for($i=0;$i<=count($datos)-1;$i++)
        {
            $data.="{name:'".$datos[$i][0]."', data: [".$datos[$i][1]."]}";
            if($i<=count($datos)-1)
            {
                $data.=",";
            }
        }
        $data.="]";
        
        echo "<script type='text/javascript'>
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: '".$div."',
                        type: 'bar'
                    },
                    title: {
                        text: '".$titulo."'
                    },
                    subtitle: {
                        text: '".$subtitulo."'
                    },
                    xAxis: {
                        categories: [".$titulosVertical."],
                        title: {
                            text: null
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '".$tituloHorizontal."',
                            align: 'high'
                        },
                        labels: {
                            overflow: 'justify'
                        }
                    },
                    tooltip: {
                        formatter: function() {
                            return ''+
                                this.series.name +': '+ this.y;
                        }
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: true
                            }
                        }
                    },
                    legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
                    credits: {
                        enabled: false
                    },
                    series: ".$data."
                });
            });


        </script>";
    }
}
?>
