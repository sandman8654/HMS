/*
*  Author: Robin San
*  Date: 2017.4.11
*  Description: chart script for dashboard
*
*/
        var patientchart = AmCharts.makeChart("bar_Patientschartdiv", {
            "theme": "light",
            "type": "serial",
            "depth3D": 20,
            "angle": 30,
            "categoryField": "month",
            "startDuration": 1,
            "dataProvider": eval(patientChartData),
            "graphs": [{
                "balloonText": "New Patients([[month]]):[[value]]",
                "fillAlphas": 0.8,
                "id": "AmGraph-1",
                "lineAlpha": 0.2,
                "title": "New Patients",
                "type": "column",
                "valueField": "newpatients"
            },
            {
                "balloonText": "Revisits([[month]]):[[value]]",
                "fillAlphas": 0.8,
                "id": "AmGraph-2",
                "lineAlpha": 0.2,
                "title": "Reviews",
                "type": "column",
                "valueField": "revisits"
            },
            {
                "balloonText": "Reviews([[month]]):[[value]]",
                "fillAlphas": 0.8,
                "id": "AmGraph-3",
                "lineAlpha": 0.2,
                "title": "Reviews",
                "type": "column",
                "valueField": "reviews"
            }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
             "export": {
                "enabled": true
            },
            "valueAxes": [
                {
                    "id": "ValueAxis-1",
                    "position": "left",
                    "axisAlpha": 0
                }
            ],
            "categoryAxis": {
                "gridPosition": "start",
                "labelRotation": 0
            },
            "legend": {
                "horizontalGap": 5,
                "useGraphSettings": true,
                "markerSize": 10
            }
        });
        
         var incomeExpenseChart = AmCharts.makeChart("bar_IncomeExpensechartdiv", {
            "theme": "light",
            "type": "serial",
            "categoryField": "month",
            "startDuration": 0,
            "dataProvider": eval(IncomeExpenseChartData),
            "graphs": [ {
                "alphaField": "alpha",
                "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                "fillAlphas": 1,
                "bullet": "round",
                "lineThickness": 3,
                "bulletSize": 7,
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "useLineColorForBulletBorder": true,
                "bulletBorderThickness": 3,
                "fillAlphas": 0,
                "lineColor":"#03bdb0",
                "lineAlpha": 1,
                "title": "Income",
                "color":"#03bdb0",
                "valueField": "income",
                "dashLengthField": "dashLengthColumn"
            }, {
                "id": "graph2",
                "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                "bullet": "round",
                "lineThickness": 3,
                "bulletSize": 7,
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "useLineColorForBulletBorder": true,
                "bulletBorderThickness": 3,
                "fillAlphas": 0,
                "lineColor":"red",
                "lineAlpha": 1,
                "title": "Expenses",
                "valueField": "expenses",
                "dashLengthField": "dashLengthLine"
            }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
             "export": {
                "enabled": true
            },
            "valueAxes": [
                {
                    "id": "ValueAxis-1",
                    "position": "left",
                    "axisAlpha": 0
                }
            ],
            "categoryAxis": {
                "gridPosition": "start",
                "labelRotation": 0
            },
            "legend": {
                "horizontalGap": 5,
                "useGraphSettings": true,
                "markerSize": 10
            }
        });
