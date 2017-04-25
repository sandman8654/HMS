/*
*  Author: Robin San
*  Date: 2017.4.11
*  Description: char script for dashboard
*
*/
        var patientchart = AmCharts.makeChart("bar_Patientschartdiv", {
            "theme": "light",
            "type": "serial",
            "depth3D": 20,
            "angle": 30,
            "categoryField": "month",
            "startDuration": 1,
            "dataProvider": [
               {    "month": 2005.3,
                    "newpatients": 23,
                    "revisits": 18,
                    "reviews": 18
                },
                {   "month": 2005.4,
                    "newpatients": 43,
                    "revisits": 28,
                    "reviews": 15
                },
                {    "month": 2005.5,
                    "newpatients": 29,
                    "revisits": 14,
                    "reviews": 20
                }
             ],
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
         var patientchart = AmCharts.makeChart("bar_IncomeExpensechartdiv", {
            "theme": "light",
            "type": "serial",
            "categoryField": "month",
            "startDuration": 0,
            "dataProvider": [
               {    "month": 2005.3,
                    "income": 390,
                    "expenses": 200
                },
                {    "month": 2005.4,
                    "income": 500,
                    "expenses": 389
                },
                {   "month": 2005.5,
                    "income": 230,
                    "expenses": 180
                },
                {    "month": 2005.6,
                    "income": 456,
                    "expenses": 328
                },
                {    "month": 2005.7,
                    "income": 378,
                    "expenses": 290
                },
                {   "month": 2005.8,
                    "income": 430,
                    "expenses": 240
                },
                {    "month": 2005.9,
                    "income": 290,
                    "expenses": 100
                },
                {    "month": 2005.10,
                    "income": 250,
                    "expenses": 138
                },
                {   "month": 2005.11,
                    "income": 330,
                    "expenses": 280
                }
             ],
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
